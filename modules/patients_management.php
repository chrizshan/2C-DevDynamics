<?php

class PatientManagement {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /* Patients Methods */
    public function createPatient($name, $age, $gender) {
        try {
            $sql = "INSERT INTO patients (name, age, gender) VALUES (?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$name, $age, $gender]);
            return ["id" => $this->pdo->lastInsertId()];
        } catch (PDOException $e) {
            return ["error" => "Error creating patient: " . $e->getMessage()];
        }
    }

    public function getPatient($id = null) {
        try {
            if ($id) {
                $sql = "SELECT * FROM patients WHERE id = ?";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$id]);
                $patient = $stmt->fetch(PDO::FETCH_ASSOC);
                return $patient ? $patient : ["error" => "Patient not found"];
            } else {
                $sql = "SELECT * FROM patients";
                $stmt = $this->pdo->query($sql);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            return ["error" => "Error retrieving patients: " . $e->getMessage()];
        }
    }

    public function updatePatient($id, $name, $age, $gender) {
        try {
            $sql = "UPDATE patients SET name = ?, age = ?, gender = ? WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$name, $age, $gender, $id]);
            return true;
        } catch (PDOException $e) {
            return ["error" => "Error updating patient: " . $e->getMessage()];
        }
    }

    public function deletePatient($id) {
        try {
            $sql = "DELETE FROM patients WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            return true;
        } catch (PDOException $e) {
            return ["error" => "Error deleting patient: " . $e->getMessage()];
        }
    }

    /* Medical Records Methods */
    public function createMedicalRecord($patientId, $recordData) {
        try {
            $sql = "INSERT INTO medical_records (patient_id, record_data) VALUES (?, ?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$patientId, $recordData]);
            return ["id" => $this->pdo->lastInsertId()];
        } catch (PDOException $e) {
            return ["error" => "Error creating medical record: " . $e->getMessage()];
        }
    }

    public function getMedicalRecord($id = null) {
        try {
            if ($id) {
                $sql = "SELECT * FROM medical_records WHERE id = ?";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$id]);
                $record = $stmt->fetch(PDO::FETCH_ASSOC);
                return $record ? $record : ["error" => "Medical record not found"];
            } else {
                $sql = "SELECT * FROM medical_records";
                $stmt = $this->pdo->query($sql);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            return ["error" => "Error retrieving medical records: " . $e->getMessage()];
        }
    }

    public function updateMedicalRecord($id, $recordData) {
        try {
            $sql = "UPDATE medical_records SET record_data = ? WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$recordData, $id]);
            return true;
        } catch (PDOException $e) {
            return ["error" => "Error updating medical record: " . $e->getMessage()];
        }
    }

    public function deleteMedicalRecord($id) {
        try {
            $sql = "DELETE FROM medical_records WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            return true;
        } catch (PDOException $e) {
            return ["error" => "Error deleting medical record: " . $e->getMessage()];
        }
    }

    /* Billing Methods */
    public function createBilling($patientId, $amount) {
        try {
            $sql = "INSERT INTO billing (patient_id, amount) VALUES (?, ?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$patientId, $amount]);
            return ["id" => $this->pdo->lastInsertId()];
        } catch (PDOException $e) {
            return ["error" => "Error creating billing record: " . $e->getMessage()];
        }
    }

    public function getBilling($id = null) {
        try {
            if ($id) {
                $sql = "SELECT * FROM billing WHERE id = ?";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$id]);
                $billing = $stmt->fetch(PDO::FETCH_ASSOC);
                return $billing ? $billing : ["error" => "Billing record not found"];
            } else {
                $sql = "SELECT * FROM billing";
                $stmt = $this->pdo->query($sql);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            return ["error" => "Error retrieving billing records: " . $e->getMessage()];
        }
    }

    public function updateBilling($id, $amount) {
        try {
            $sql = "UPDATE billing SET amount = ? WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$amount, $id]);
            return true;
        } catch (PDOException $e) {
            return ["error" => "Error updating billing record: " . $e->getMessage()];
        }
    }

    public function deleteBilling($id) {
        try {
            $sql = "DELETE FROM billing WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            return true;
        } catch (PDOException $e) {
            return ["error" => "Error deleting billing record: " . $e->getMessage()];
        }
    }
}

?>
