<?php

// require_once "Appointment.php";
require_once "../models/Appointment.php";

if (!isset($_GET["id"])) {
    die("Nije pronađen id!");
}
if (!isset($_GET["date"])) {
    die("Nije pronađen datum!");
}
if (!isset($_GET["old_date"])) {
    die("Nije pronađen datum!");
}
if (!isset($_GET["time"])) {
    die("Nije pronađeo termin!");
}
if (!isset($_GET["old_time"])) {
    die("Nije pronađeo termin!");
}
if (!isset($_GET["descr"])) {
    die("Nije pronađen opis!");
}

$id = $_GET["id"];
$date = $_GET["date"];
$dayOfWeek = date_format(date_create($date), "w");
if ($dayOfWeek == 6 || $dayOfWeek == 0) {
    die("Odabrani dan je vikend!");
}
$dateOld = $_GET["old_date"];
$time = $_GET["time"];
$timeOld = $_GET["old_time"];
$descr = $_GET["descr"];

$appointment = new Appointment();
$appointments = $appointment->getAllAppointments($date);
if ($date !== $dateOld) {
    foreach ($appointments as $newAppointment) {
        if ($time === $newAppointment["appointment"]) {
            die("Termin je zauzet!");
        }
    }
} else if ($time !== $timeOld) {
    foreach ($appointments as $oldAppointment) {
        if ($time === $oldAppointment["appointment"]) {
            die("Termin je zauzet!");
        }
    }
}
$appointment->updateAppointment($id, $date, $time, $descr);

header("location: ../index.php?date=$date");
