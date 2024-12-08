<?php

// require_once "Appointment.php";
require_once "../models/Appointment.php";

if (!isset($_GET["id"])) {
    die("Nedostaje id");
}

$appointmetToDel = $_GET["id"];

$appointment = new Appointment();
$appointment->deleteAppointment($appointmetToDel);

header("location: " . $_SERVER["HTTP_REFERER"]);
