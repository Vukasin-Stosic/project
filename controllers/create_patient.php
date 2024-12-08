<?php

// require_once "Patient.php";
require_once "../models/Patient.php";

if (!isset($_POST["patientName"]) || empty($_POST["patientName"])) {
    die("Niste uneli ime pacijenta!");
}
if (!isset($_POST["phone"]) || empty($_POST["phone"])) {
    die("Niste uneli broj telefona!");
}

$patientName = $_POST["patientName"];
$phone = $_POST["phone"];

$patient = new Patient();
$patientExist = $patient->patientExist($patientName);
if ($patientExist) {
    die("Ime zauzeto!");
} else {
    $patient->createPatient($patientName, $phone);
}

header("location: ../patients.php");
