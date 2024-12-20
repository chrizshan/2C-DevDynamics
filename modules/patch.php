<?php
//only works for updating the medical record and billings type shits 
class Patch {
    protected $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
// In Patch.php
public function updateMedicalRecord($id, $recordData) {
    try {
        $sql = "UPDATE medical_records SET record_data = :record_data WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':record_data' => $recordData,
            ':id' => $id
        ]);
        
        if ($stmt->rowCount() > 0) {
            return [
                "success" => true,
                "message" => "Medical record updated successfully."
            ];
        } else {
            return [
                "success" => false,
                "error" => "Medical record not found or no changes made."
            ];
        }
    } catch (PDOException $e) {
        return [
            "success" => false,
            "error" => "Error updating medical record: " . $e->getMessage()
        ];
    }
}


    public function updateBilling($body, $id) {
        try {
            if (empty($body['amount'])) {
                return ["error" => "Amount is required to update the billing record."];
            }

            $amount = $body['amount'];

            $sql = "SELECT * FROM billing WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            $billing = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$billing) {
                return ["error" => "Billing record not found"];
            }

            $sql = "UPDATE billing SET amount = :amount WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':amount' => $amount, ':id' => $id]);

            return ["success" => "Billing record updated successfully"];
        } catch (PDOException $e) {
            return ["error" => "Error updating billing record: " . $e->getMessage()];
        }
    }
}
?>