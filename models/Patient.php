<?php

require_once "Base.php";

class Patient extends Base
{
    public function createPatient($patientName, $phone)
    {
        $patientName = $this->sql->real_escape_string($patientName);
        $phone = $this->sql->real_escape_string($phone);
        $this->sql->query("INSERT INTO patients (patient_name, phone) VALUE ('$patientName', '$phone')");
    }

    public function getAllPatients()
    {
        $result = $this->sql->query("SELECT * FROM patients");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getCurrentPatient($id)
    {
        $id = $this->sql->real_escape_string($id);
        $result = $this->sql->query("SELECT * FROM patients WHERE id = $id");
        return $result->fetch_assoc();
    }

    public function deletePatient($id)
    {
        $id = $this->sql->real_escape_string($id);
        $this->sql->query("DELETE FROM patients WHERE id = '$id'");
    }

    public function updatePatient($id, $name, $phone)
    {
        $id = $this->sql->real_escape_string($id);
        $name = $this->sql->real_escape_string($name);
        $phone = $this->sql->real_escape_string($phone);
        $this->sql->query("UPDATE patients SET patient_name = '$name', phone = '$phone' WHERE id = $id");
    }

    public function patientExist($patientName)
    {
        $patientName = $this->sql->real_escape_string($patientName);
        $result = $this->sql->query("SELECT * FROM patients WHERE patient_name = '$patientName'");
        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function patientIDExist($id)
    {
        $id = $this->sql->real_escape_string($id);
        $result = $this->sql->query("SELECT * FROM patients WHERE id = $id");
        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }
}
