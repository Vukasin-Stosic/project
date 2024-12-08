<?php
// require_once "Patient.php";
require_once "../models/Patient.php";

if (!isset($_GET["id"])) {
    die("Nije pronađen id!");
}
if (!isset($_GET["patient_name"])) {
    die("Nije pronađeno ime!");
}
if (!isset($_GET["old_name"])) {
    die("Nije pronađeno ime!");
}
if (!isset($_GET["phone"])) {
    die("Nije pronađen broj telefona!");
}

$id = $_GET["id"];
$name = $_GET["patient_name"];
$oldName = $_GET["old_name"];
$phone = $_GET["phone"];

$patient = new Patient();
if ($name !== $oldName) {
    $patientExist = $patient->patientExist($name);
    if ($patientExist) {
        die("Ime je zauzeto!");
    }
}
$patient->updatePatient($id, $name, $phone);

header("location: ../patient_view.php?id=$id");
