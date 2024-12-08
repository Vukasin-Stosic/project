<?php

require_once "Base.php";

class Appointment extends Base
{
    public function createAppointment($appDate, $appointment, $patientID, $patientName, $descr)
    {

        $appDate = $this->sql->real_escape_string($appDate);
        $appointment = $this->sql->real_escape_string($appointment);
        $patientID = $this->sql->real_escape_string($patientID);
        $patientName = $this->sql->real_escape_string($patientName);
        $descr = $this->sql->real_escape_string($descr);
        $this->sql->query("INSERT INTO schedule (app_date, appointment, patient_id, patient_name, descr) VALUES ('$appDate', '$appointment','$patientID', '$patientName', '$descr')");
    }

    public function getAllAppointments($date)
    {
        $date = $this->sql->real_escape_string($date);
        $result = $this->sql->query("SELECT * FROM schedule WHERE app_date = '$date'");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function deleteAppointment($id)
    {
        $id = $this->sql->real_escape_string($id);
        $this->sql->query("DELETE FROM schedule WHERE id = $id");
    }

    public function updateAppointment($id, $date, $time, $descr)
    {
        $id = $this->sql->real_escape_string($id);
        $date = $this->sql->real_escape_string($date);
        $time = $this->sql->real_escape_string($time);
        $descr = $this->sql->real_escape_string($descr);
        $this->sql->query("UPDATE schedule SET app_date = '$date', appointment = '$time', descr = '$descr' WHERE id = $id");
    }

    public function currentPatientAppointments($id)
    {
        $id = $this->sql->real_escape_string($id);
        $result = $this->sql->query("SELECT * FROM schedule WHERE patient_id = $id");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getHours()
    {
        $times = [];
        for ($i = 8; $i < 15; $i++) {
            if ($i < 10) {
                array_push($times, "0$i:00", "0$i:30");
            } else {
                array_push($times, "$i:00", "$i:30");
            }
        }
        return $times;
    }
}
