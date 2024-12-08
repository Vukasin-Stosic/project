<?php

if (!isset($_GET["id"])) {
    die("Nije pronađen id!");
}
if (!isset($_GET["date"])) {
    die("Nije pronađen datum!");
}
if (!isset($_GET["descr"])) {
    die("Nije pronađen opis!");
}

$id = $_GET["id"];
$date = $_GET["date"];
if (isset($_GET["time"])) {
    $time = $_GET["time"];
} else {
    $time = "";
}
$descr = $_GET["descr"];

require_once "models/Appointment.php";
$temp = new Appointment;

$times = $temp->getHours();

$appointmentsList = $temp->getAllAppointments($date);
$appointments = [];
foreach ($appointmentsList as $appointment) {
    array_push($appointments, $appointment["appointment"]);
}

$appointments = array_diff($appointments, [$time]);

$appointmentsFree = array_diff($times, $appointments);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <nav>
        <a class="nav--link" href="index.php">Zakazivanje</a>
        <a class="nav--link" href="patients.php">Pacijenti</a>
    </nav>
    <div class="container">
        <form class="form" action="controllers/update_appointment.php" method="get">
            <label for="date">Datum:</label>
            <input type="date" name="date" id="date" value=<?= $date ?> onchange="handleChange(event)">
            <input type="hidden" name="old_date" value=<?= $date ?>>
            <label for="time">Vreme:</label>
            <select name="time" id="time">
                <?php foreach ($appointmentsFree as $appointment): ?>
                    <?php if ($appointment === $time): ?>
                        <option selected value=<?= $appointment ?>><?= $appointment ?></option>
                    <?php else: ?>
                        <option value=<?= $appointment ?>><?= $appointment ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
            <input type="hidden" name="old_time" value=<?= $time ?>>
            <input type="hidden" name="id" value=<?= $id ?>>
            <label for="descr">Opis:</label>
            <textarea name="descr" id="descr"><?= $descr ?></textarea>
            <button class="btn">Potvrdi</button>
        </form>
    </div>
    <script>
        function handleChange(event) {
            const date = event.currentTarget.value;
            const link = document.createElement("a");
            const description = document.querySelector("#descr").value;
            link.setAttribute("href", `appointment_update.php?id=<?= $id ?>&date=${date}&descr=${description}`);
            const body = document.querySelector("body");
            body.append(link);
            link.click();
        }
    </script>
</body>

</html>