<?php
if (!isset($_GET["id"])) {
    die("Nedostaje id pacijenta!");
}
$id = $_GET["id"];

require_once "models/Patient.php";
require_once "models/Appointment.php";

$patients = new Patient();
$current = $patients->getCurrentPatient($id);

$appointments = new Appointment();
$allAppointments = $appointments->currentPatientAppointments($id);

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
        <div class="patient">
            <p class="bold">Ime:</p>
            <p>
                <?= $current["patient_name"] ?>
            </p>
            <p class="bold">Telefon:</p>
            <p>
                <?= $current["phone"] ?>
            </p>
            <div>
                <h3>Intervencije:</h3>
                <ol>
                    <?php foreach ($allAppointments as $singleAppointment): ?>
                        <li>
                            <span><?= $singleAppointment["app_date"] ?></span>
                            <p><?= $singleAppointment["descr"] ?></p>
                        </li>
                    <?php endforeach; ?>
                </ol>

            </div>
            <form action="patient_update.php" method="get">
                <input type="hidden" name="name" value="<?= $current["patient_name"] ?>">
                <input type="hidden" name="phone" value="<?= $current["phone"] ?>">
                <input type="hidden" name="id" value="<?= $current["id"] ?>">
                <button class="btn">Uredi</button>
            </form>
        </div>
    </div>

</body>

</html>