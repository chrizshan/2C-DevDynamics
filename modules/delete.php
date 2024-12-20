<?php
class Delete {
    protected $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function deletePatient($id) {
        try {
            $sql = "SELECT * FROM patients WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            $patient = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$patient) {
                return ["error" => "Patient not found"];
            }
            $sql = "DELETE FROM patients WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);

            return ["success" => "Patient deleted successfully"];
        } catch (PDOException $e) {
            return ["error" => "Error deleting patient: " . $e->getMessage()];
        }
    }
    public function deleteMedicalRecord($id) {
        try {
            $sql = "SELECT * FROM medical_records WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            $record = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$record) {
                return ["error" => "Medical record not found"];
            }

            $sql = "DELETE FROM medical_records WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);

            return ["success" => "Medical record deleted successfully"];
        } catch (PDOException $e) {
            return ["error" => "Error deleting medical record: " . $e->getMessage()];
        }
    }

    public function deleteBilling($id) {
        try {
            $sql = "SELECT * FROM billing WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            $billing = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$billing) {
                return ["error" => "Billing record not found"];
            }
            $sql = "DELETE FROM billing WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);

            return ["success" => "Billing record deleted successfully"];
        } catch (PDOException $e) {
            return ["error" => "Error deleting billing record: " . $e->getMessage()];
        }
    }
}
