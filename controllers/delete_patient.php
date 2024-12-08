<?php

// require_once "Patient.php";
require_once "../models/Patient.php";

if (!isset($_GET["id"])) {
    die("Nedostaje id pacijenta!");
}

$id = $_GET["id"];

$patient = new Patient();
$patient->deletePatient($id);

header("location: ../patients.php");
