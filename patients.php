<?php

require_once "models/Patient.php";

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
    <div class="container">
        <div class="subheader">
            <button class="btn">
                <a href="patient_new.php" class="link">Dodaj pacijenta</a>
            </button>
            <div class="searchbar">
                <p class="searchbar_text">Pretraži</p>
                <input type="text" name="filter" id="filter" onkeyup="search()" class="searchbar_input">
            </div>
        </div>
        <ol class="cards">
            <?php foreach ($allPatients as $singlePatient): ?>
                <li class="card--patient">
                    <span>
                        <p class="card--item card--item_main name">
                            <?= $singlePatient["patient_name"] ?>
                        </p>
                        <p class="card--item card--item_main">
                            <?= $singlePatient["phone"] ?>
                        </p>
                        <div class="card--item">
                            <div>
                                <button class="btn">
                                    <a href="patient_view.php?id=<?= $singlePatient["id"] ?>" class="link">Pregled</a>
                                </button>
                            </div>
                            <div class="delete">
                                <span class="popup">
                                    <span class="close">
                                        &times;
                                    </span>
                                    <span>
                                        Obriši pacijenta!
                                    </span>
                                    <button class="btn">
                                        <a href='controllers/delete_patient.php?id=<?= $singlePatient["id"] ?>' class="link">Potvrdi</a>
                                    </button>
                                </span>
                                <button class="btn delete_btn">Obriši</button>
                            </div>
                        </div>
                    </span>
                </li>
            <?php endforeach; ?>
        </ol>
    </div>
    <script>
        function search() {
            const input = document.querySelector("#filter")
            let filter = input.value.toUpperCase();
            const cards = document.querySelectorAll(".card--patient");
            for (let i = 0; i < cards.length; i++) {
                let patient = cards[i].querySelector(".name")
                let text = patient.textContent || patient.innerText;
                if (text.toUpperCase().indexOf(filter) > -1) {
                    cards[i].style.display = "";
                } else {
                    cards[i].style.display = "none";
                }
            }
        }

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

        const cards = document.querySelector(".cards");
        const list = cards.querySelectorAll(".card--patient");

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

        cards.append(...listSorted);
    </script>
</body>

</html>