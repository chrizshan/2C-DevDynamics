<?php 
class Authentication {
    protected $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    // Check if the user is authorized by comparing token in headers
    public function isAuthorized() {
        $headers = array_change_key_case(getallheaders(), CASE_LOWER);
        // Make sure the Authorization header is present
        if (isset($headers['authorization'])) {
            return $this->getToken() === $headers['authorization'];
        }
        return false;
    }

    // Retrieve the token associated with the current user from the database
    private function getToken() {
        $headers = array_change_key_case(getallheaders(), CASE_LOWER);

        // Retrieve the username from the "x-auth-user" header and fetch the token
        if (isset($headers['x-auth-user'])) {
            $sqlString = "SELECT token FROM account_tbl WHERE Username=?";
            try {
                $stmt = $this->pdo->prepare($sqlString);
                $stmt->execute([$headers['x-auth-user']]);
                $result = $stmt->fetch();
                return $result ? $result['token'] : '';
            } catch (Exception $e) {
                // Handle exception if any
                return "";
            }
        }
        return "";
    }

    // Generate the header part of the JWT
    private function generateHeader() {
        $header = [
            "typ" => "JWT",
            "alg" => "HS256",
            "app" => "QUIZ System for Students"
        ];
        return base64_encode(json_encode($header));
    }

    // Generate the payload part of the JWT
    private function generatePayload($id, $username) {
        $payload = [
            "user_id" => $id,
            "user_cred" => $username,
        ];
        return base64_encode(json_encode($payload));
    }

    // Generate the full JWT token
    private function generateToken($id, $username) {
        $header = $this->generateHeader();
        $payload = $this->generatePayload($id, $username);
        $signature = base64_encode(hash_hmac("sha256", "$header.$payload", "your_secret_key", true));
        return "$header.$payload.$signature";
    }

    // Save the token in the database
    public function saveToken($token, $username) {
        try {
            $sqlString = "UPDATE account_tbl SET token=? WHERE Username=?";
            $sql = $this->pdo->prepare($sqlString);
            $sql->execute([$token, $username]);
            return ["data" => null, "code" => 200];
        } catch (\PDOException $e) {
            return ["errmsg" => $e->getMessage(), "code" => 400];
        }
    }

    public function login($body) {
        $username = $body['Username'] ?? null;
        $password = $body['Password'] ?? null;

        if (empty($username) || empty($password)) {
            return ["message" => "Username and password are required.", "code" => 400];
        }

        try {
            // Check if the user exists in the database
            $sqlString = "SELECT id, Username, Password FROM account_tbl WHERE Username=?";
            $stmt = $this->pdo->prepare($sqlString);
            $stmt->execute([$username]);

            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetch();

                // Verify the password
                if (password_verify($password, $result['Password'])) {
                    // Success: Password matches
                    $token = $this->generateToken($result['id'], $result['Username']); // Assuming you generate a token
                    return ["message" => "Logged in successfully", "token" => $token, "code" => 200];
                } else {
                    // Failed: Incorrect password
                    return ["message" => "Incorrect password.", "code" => 401];
                }
            } else {
                // Failed: Username not found
                return ["message" => "Username does not exist.", "code" => 404];
            }
        } catch (\PDOException $e) {
            return ["message" => "Database error: " . $e->getMessage(), "code" => 500];
        }
    }

    public function addAccount($body) {
        $values = [];
        $errmsg = "";
        $code = 0;

        // Encrypt the password before saving
        $password = isset($body["Password"]) ? password_hash($body["Password"], PASSWORD_BCRYPT) : '';

        // Add other values except Password
        foreach ($body as $key => $value) {
            if ($key != 'Password') { 
                array_push($values, $value);
            }
        }

        // Add the hashed password
        array_push($values, $password);

        try {
            // Insert account into the database
            $sqlString = "INSERT INTO account_tbl (Username, Password) VALUES (?, ?)";
            $sql = $this->pdo->prepare($sqlString);
            $sql->execute($values);

            $code = 200;
            return ["message" => "Account created successfully", "code" => $code];
        } catch (\PDOException $e) {
            $errmsg = $e->getMessage();
            $code = 400;
        }

        return ["errmsg" => $errmsg, "code" => $code];
    }
}
?>
