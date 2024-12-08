<?php

require_once "models/Appointment.php";
require_once "models/Base.php";

if (isset($_GET["date"])) {
    $date = $_GET["date"];
} else {
    $date = date("Y-m-d");
}

$dayOfWeek = date_format(date_create($date), "w");

if ($dayOfWeek == 1) {
    $monday = $date;
} else {
    $singleDay = $dayOfWeek == 0 ? 6 : --$dayOfWeek;
    $monday = date_modify(date_create($date), "- $singleDay days");
    $monday = date_format($monday, "Y-m-d");
}

$tuesday = date_modify(date_create($monday), "+ 1 day");
$tuesday = date_format($tuesday, "Y-m-d");
$wednesday = date_modify(date_create($monday), "+ 2 day");
$wednesday = date_format($wednesday, "Y-m-d");
$thursday = date_modify(date_create($monday), "+ 3 day");
$thursday = date_format($thursday, "Y-m-d");
$friday = date_modify(date_create($monday), "+ 4 day");
$friday = date_format($friday, "Y-m-d");

$previousMonday = date_modify(date_create($monday), "- 7 days");
$previousMonday = date_format($previousMonday, "Y-m-d");
$nextMonday = date_modify(date_create($monday), "+ 7 days");
$nextMonday = date_format($nextMonday, "Y-m-d");

$appointment = new Appointment();
$allApp = $appointment->getAllAppointments($date);
$times = $appointment->getHours();

$appTimes = [];
foreach ($allApp as $app) {
    $appTimes[] = $app["appointment"];
}

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
        <div class="week flex">
            <a href="index.php?date=<?= $previousMonday ?>" class="nav--link">Prethodna</a>
            <p><?= $monday ?> - <?= $friday ?></p>
            <a href="index.php?date=<?= $nextMonday ?>" class="nav--link">Sledeća</a>
        </div>
        <div class="days">
            <a href="index.php?date=<?= $monday ?>" class="nav--link"><span class="day">Ponedeljak</span><br><?= date_format(date_create($monday), "d-M") ?></a>
            <a href="index.php?date=<?= $tuesday ?>" class="nav--link"><span class="day">Utorak</span><br><?= date_format(date_create($tuesday), "d-M") ?></a>
            <a href="index.php?date=<?= $wednesday ?>" class="nav--link"><span class="day">Sreda</span><br><?= date_format(date_create($wednesday), "d-M") ?></a>
            <a href="index.php?date=<?= $thursday ?>" class="nav--link"><span class="day">Četvrtak</span><br><?= date_format(date_create($thursday), "d-M") ?></a>
            <a href="index.php?date=<?= $friday ?>" class="nav--link"><span class="day">Petak</span><br><?= date_format(date_create($friday), "d-M") ?></a>
        </div>
        <?php foreach ($times as $time): ?>
            <div class="card">
                <p class="card--item">
                    <?= $time ?>
                </p>
                <?php if (in_array($time, $appTimes)): ?>
                    <?php foreach ($allApp as $app): ?>
                        <?php if ($time === $app["appointment"]): ?>
                            <p class="card--item card--item_main">
                                <?= $app["patient_name"] ?>
                            </p>
                            <p class="card--item card--item_main">
                                <?= $app["descr"] ?>
                            </p>
                            <div class="card--item flex">
                                <div class="delete">
                                    <span class="popup">
                                        <span class="close">
                                            &times;
                                        </span>
                                        <span>
                                            Otkaži termin!
                                        </span>
                                        <button class="btn">
                                            <a href="controllers/delete_appointment.php?id=<?= $app["id"] ?>" class="link">Potvrdi</a>
                                        </button>
                                    </span>
                                    <button class="btn delete_btn">Otkaži</button>
                                </div>
                                <div>
                                    <button class="btn">
                                        <a href="appointment_update.php?id=<?= $app["id"] ?>&date=<?= $app["app_date"] ?>&time=<?= $app["appointment"] ?>&descr=<?= $app["descr"] ?>" class="link">
                                            Izmeni
                                        </a>
                                    </button>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="card--item">
                        <button class="btn">
                            <a href='appointment_new.php?time=<?= $time ?>&date=<?= $date ?>' class="link">Zakaži</a>
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <script>
        const deletebtns = document.querySelectorAll(".delete_btn");
        deletebtns.forEach(btn => {
            btn.addEventListener("click", popupOpen)
        })

        function popupOpen(event) {
            const popup = event.currentTarget.previousElementSibling;
            popup.classList.add("show");
        }

        const closebtns = document.querySelectorAll(".close");
        closebtns.forEach(btn => {
            btn.addEventListener("click", popupClose);
        })

        function popupClose(event) {
            const popup = event.currentTarget.parentElement;
            popup.classList.remove("show");
        }

        // days of the week
        const daysArray = ["Ponedeljak", "Utorak", "Sreda", "Četvrtak", "Petak"];
        const day = "<?= $date ?>";
        const dayIndex = new Date(day).getDay();
        const currentDay = daysArray[dayIndex - 1];
        const days = document.querySelectorAll(".day");
        days.forEach(day => {
            if (day.textContent === currentDay) {
                day.parentElement.classList.add("active");
            }
        })
    </script>
</body>

</html>