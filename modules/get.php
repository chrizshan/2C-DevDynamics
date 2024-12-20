<?php
class Get {
    protected $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getPatient($id = null) {
        try {
            if ($id) {
                $sql = "SELECT * FROM patients WHERE id = :id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([':id' => $id]);
                $patient = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($patient) {
                    return $patient;
                } else {
                    return ["error" => "Patient not found"];
                }
            } else {
                $sql = "SELECT * FROM patients";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            return ["error" => "Error fetching patients: " . $e->getMessage()];
        }
    }

    public function getMedicalRecord($id = null) {
        try {
            if ($id) {
                $sql = "SELECT * FROM medical_records WHERE id = :id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([':id' => $id]);
                $record = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($record) {
                    return $record;
                } else {
                    return ["error" => "Medical record not found"];
                }
            } else {
                $sql = "SELECT * FROM medical_records";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            return ["error" => "Error fetching medical records: " . $e->getMessage()];
        }
    }

    public function getBilling($id = null) {
        try {
            if ($id) {
                $sql = "SELECT * FROM billing WHERE id = :id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([':id' => $id]);
                $billing = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($billing) {
                    return $billing;
                } else {
                    return ["error" => "Billing record not found"];
                }
            } else {
                $sql = "SELECT * FROM billing";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            return ["error" => "Error fetching billing records: " . $e->getMessage()];
        }
    }
}
