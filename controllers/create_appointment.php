<?php

// require_once "Appointment.php";
// require_once "Patient.php";
require_once "../models/Appointment.php";
require_once "../models/Patient.php";

if (!isset($_POST["app_date"]) || empty($_POST["app_date"])) {
    die("Niste odabrali datum!");
}
if (!isset($_POST["appointment"]) || empty($_POST["appointment"])) {
    die("Niste odabrali vreme!");
}
if (!isset($_POST["patient_id"]) || empty($_POST["patient_id"])) {
    die("Niste odabrali pacijenta");
}
if (!isset($_POST["patient_name"]) || empty($_POST["patient_name"])) {
    die("Niste odabrali pacijenta!");
}
if (!isset($_POST["descr"]) || empty($_POST["descr"])) {
    die("Niste uneli opis!");
}

$appDate = $_POST["app_date"];
$dayOfWeek = date_format(date_create($appDate), "w");
if ($dayOfWeek == 6 || $dayOfWeek == 0) {
    die("Odabrani dan je vikend!");
}
$appointment = $_POST["appointment"];
$patientID = $_POST["patient_id"];
$patientName = $_POST["patient_name"];
$descr = $_POST["descr"];

$time = new Appointment();
$allAppointments = $time->getAllAppointments($appDate);
foreach ($allAppointments as $singleAppointment) {
    if ($singleAppointment["appointment"] === $appointment) {
        die("Termin je već zauzet!");
    }
}

$tempPatient = new Patient();
$patientExist = $tempPatient->patientExist($patientName);
if (!$patientExist) {
    die("Nepostoji traženi pacijent!");
}

$patientIDExist = $tempPatient->patientIDExist($patientID);
if (!$patientIDExist) {
    die("Nepostoji pacijent sa traženim id-jem!");
}

$currentPatient = $tempPatient->getCurrentPatient($patientID);
if ($currentPatient["patient_name"] !== $patientName) {
    die("Ime i id se ne podudaraju!");
}
$time->createAppointment($appDate, $appointment, $patientID, $patientName, $descr);

header("location: ../index.php?date=$appDate");
