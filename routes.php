<?php
// Import required files
require_once "./config/database.php";
require_once "./modules/Get.php";
require_once "./modules/Post.php";
require_once "./modules/Patch.php"; 
require_once "./modules/Delete.php";
require_once "./modules/auth.php";

// Initialize database connection
try {
    $db = new Connection();
    $pdo = $db->connect();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed: " . $e->getMessage()]);
    exit;
}

// Instantiate classes
$get = new Get($pdo);
$post = new Post($pdo);
$patch = new Patch($pdo);
$delete = new Delete($pdo);
$auth = new Authentication($pdo);

$request = isset($_REQUEST['request']) ? explode("/", trim($_REQUEST['request'], "/")) : [];
$method = $_SERVER['REQUEST_METHOD'];

if (empty($request)) {
    http_response_code(404);
    echo json_encode(["error" => "Endpoint not found."]);
    exit;
}

$endpoint = $request[0];
$id = $request[1] ?? null;

try {
    switch ($method) {
        case "GET":
            handleGet($endpoint, $id, $get); 
            break;
        case "POST":
            $body = getRequestBody();
            handlePost($endpoint, $body, $post, $auth); 
            break;
        case "PATCH":
            $body = getRequestBody();
            handlePatch($endpoint, $id, $body, $patch); 
            break;
        case "DELETE":
            handleDelete($endpoint, $id, $delete); 
            break;
        default:
            http_response_code(405);
            echo json_encode(["error" => "Method not allowed."]);
            break;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "An error occurred: " . $e->getMessage()]);
}

// Function to handle GET requests
function handleGet($endpoint, $id, $get) {
    switch ($endpoint) {
        case "patients":
            echo json_encode($id ? $get->getPatient($id) : $get->getPatient());
            break;
        case "medical":
            echo json_encode($id ? $get->getMedicalRecord($id) : $get->getMedicalRecord());
            break;
        case "billing":
            echo json_encode($id ? $get->getBilling($id) : $get->getBilling());
            break;
        default:
            http_response_code(404);
            echo json_encode(["error" => "Endpoint not found."]);
    }
}

// Function to handle POST requests
function handlePost($endpoint, $body, $post, $auth) {
    switch ($endpoint) {
        case "accounts":
            echo json_encode($auth->addAccount($body));
            break;
        case "login":
            echo json_encode($auth->login($body));
            break;
        case "medical":
            if (isset($body['patient_id']) && isset($body['record_data'])) {
                $result = $post->createMedicalRecord($body['patient_id'], $body['record_data']);
                echo json_encode($result);
            } else {
                http_response_code(400);
                echo json_encode(["error" => "Patient ID and record data are required."]);
            }
            break;
        case "billing":
            if (isset($body['patient_id']) && isset($body['amount'])) {
                $result = $post->createBilling($body['patient_id'], $body['amount']);
                echo json_encode($result);
            } else {
                http_response_code(400);
                echo json_encode(["error" => "Patient ID and amount are required."]);
            }
            break;
        case "patients":
            if (isset($body['name']) && isset($body['age']) && isset($body['gender'])) {
                $result = $post->createPatient($body['name'], $body['age'], $body['gender']);
                echo json_encode($result);
            } else {
                http_response_code(400);
                echo json_encode(["error" => "Name, age, and gender are required."]);
            }
            break;
        default:
            http_response_code(404);
            echo json_encode(["error" => "Endpoint not found."]);
    }
}

function handlePatch($endpoint, $id, $body, $patch) {
    switch ($endpoint) {
        case "medical":
            if (isset($body['record_data'])) {
                echo json_encode($patch->updateMedicalRecord($id, $body['record_data']));
            } else {
                http_response_code(400);
                echo json_encode(["error" => "Record data is required."]);
            }
            break;
        default:
            http_response_code(404);
            echo json_encode(["error" => "Endpoint not found."]);
    }
}
function handleDelete($endpoint, $id, $delete) {
    switch ($endpoint) {
        case "patients":
            echo json_encode($delete->deletePatient($id));
            break;
        default:
            http_response_code(404);
            echo json_encode(["error" => "Endpoint not found."]);
    }
}

function getRequestBody() {
    return json_decode(file_get_contents("php://input"), true);
}
?>
