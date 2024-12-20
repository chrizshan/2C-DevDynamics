<?php
class Post {
    protected $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Create a new patient
    public function createPatient($name, $age, $gender) {
        try {
            $sql = "INSERT INTO patients (name, age, gender) VALUES (:name, :age, :gender)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':name' => $name,
                ':age' => $age,
                ':gender' => $gender
            ]);
            return [
                "success" => true,
                "patient_id" => $this->pdo->lastInsertId()
            ];
        } catch (PDOException $e) {
            return [
                "success" => false,
                "error" => "Error creating patient: " . $e->getMessage()
            ];
        }
    }

    // Create a new medical record
    public function createMedicalRecord($patientId, $recordData) {
        try {
            $sql = "INSERT INTO medical_records (patient_id, record_data) VALUES (:patient_id, :record_data)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':patient_id' => $patientId,
                ':record_data' => $recordData
            ]);
            return [
                "success" => true,
                "record_id" => $this->pdo->lastInsertId()
            ];
        } catch (PDOException $e) {
            return [
                "success" => false,
                "error" => "Error creating medical record: " . $e->getMessage()
            ];
        }
    }

    // Create a new billing record
    public function createBilling($patientId, $amount) {
        try {
            $sql = "INSERT INTO billing (patient_id, amount) VALUES (:patient_id, :amount)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':patient_id' => $patientId,
                ':amount' => $amount
            ]);
            return [
                "success" => true,
                "billing_id" => $this->pdo->lastInsertId()
            ];
        } catch (PDOException $e) {
            return [
                "success" => false,
                "error" => "Error creating billing record: " . $e->getMessage()
            ];
        }
    }

}
