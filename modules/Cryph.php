<?php

class Post {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Create a new patient
     *
     * @param array $patientData
     * @return array
     */
    public function createPatient(array $patientData): array
    {
        try {
            // Validate patient data
            $this->validatePatientData($patientData);

            // Insert patient data into the database
            $sql = "INSERT INTO patients (name, age, gender) VALUES (:name, :age, :gender)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':name' => $patientData['name'],
                ':age' => $patientData['age'],
                ':gender' => $patientData['gender'],
            ]);

            // Return success response
            return [
                'success' => true,
                'message' => 'Patient created successfully',
            ];
        } catch (PDOException $e) {
            // Return error response
            return [
                'success' => false,
                'error' => 'Error creating patient: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Validate patient data
     *
     * @param array $patientData
     * @throws InvalidArgumentException
     */
    private function validatePatientData(array $patientData): void
    {
        if (!isset($patientData['name']) || !isset($patientData['age']) || !isset($patientData['gender'])) {
            throw new InvalidArgumentException('Name, age, and gender are required');
        }
    }
}
