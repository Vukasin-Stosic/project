<?php

require_once "models/Patient.php";

if (!isset($_GET["time"])) {
    die("Nije odabrano vreme!");
}

if (!isset($_GET["date"])) {
    die("Nije odabran datum!");
}

$patients = new Patient();
$allPatients = $patients->getAllPatients();

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
    <div class="container flex">
        <div class="patients">
            <div class="searchbar" id="patientsSearchbar">
                <p class="searchbar_text">Pretraži</p>
                <input type="text" name="filter" id="filter" onkeyup="search()" class="searchbar_input">
            </div>
            <div class="patients_container">
                <?php foreach ($allPatients as $patient): ?>
                    <div class="flex patients_single">
                        <p class="name"><?= $patient["patient_name"] ?></p>
                        <button class="btn chose">Odaberi</button>
                        <input type="hidden" value="<?= $patient["id"] ?>">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <form class="form patients_form" action="controllers/create_appointment.php" method="post">
            <input type="hidden" name="app_date" value=<?= $_GET["date"] ?>>
            <input type="hidden" name="appointment" value=<?= $_GET["time"] ?>>
            <input type="hidden" name="patient_id" id="patientID">
            <input type="hidden" name="patient_name" id="patientName">
            <p><strong>Ime: </strong><span id="displayPatient"></span></p>
            <label for="descr">Opis</label>
            <textarea name="descr" placeholder="opis" id="descr"></textarea>
            <button class="btn">Zakaži</button>
        </form>
    </div>
    <script>
        const patients = document.querySelectorAll(".patients_single");
        const btns = document.querySelectorAll(".chose");

        btns.forEach(btn => {
            btn.addEventListener("click", chosePatient);
        })

        function chosePatient(event) {
            const name = event.currentTarget.previousElementSibling.textContent;
            const id = event.currentTarget.nextElementSibling.value;
            const inputName = document.querySelector("#patientName");
            const inputID = document.querySelector("#patientID")
            const displayPatient = document.querySelector("#displayPatient");
            displayPatient.textContent = name;
            inputName.value = name;
            inputID.value = id;

        }

        function search() {
            const filter = document.querySelector("#filter");
            let value = filter.value.toUpperCase();
            for (let i = 0; i < patients.length; i++) {
                const name = patients[i].querySelector(".name");
                const text = name.textContent || name.innerText;


                if (text.toUpperCase().indexOf(value) > -1) {
                    patients[i].style.display = "";
                } else {
                    patients[i].style.display = "none"
                }
            }
        }

        const container = document.querySelector(".patients_container");
        const list = container.querySelectorAll(".patients_single");

        function sortList(a, b) {
            const A = a.querySelector(".name").textContent;
            const B = b.querySelector(".name").textContent;

            if (A < B) {
                return -1;
            } else if (B < A) {
                return 1;
            } else {
                return 0;
            }
        }

        const listSorted = [...list].sort(sortList);

        container.append(...listSorted);
    </script>
</body>

</html>