<?php
if (!isset($_GET["name"])) {
    die("Nije pronađeno ime pacijenta!");
}
if (!isset($_GET["phone"])) {
    die("Nije pronađen broj telefona!");
}
if (!isset($_GET["id"])) {
    die("Nije pronađen id pacijenta!");
}

$name = $_GET["name"];
$phone = $_GET["phone"];
$id = $_GET["id"];
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
        <form class="form" action="controllers/update_patient.php" method="get">
            <input type="hidden" name="id" value="<?= $id ?>">
            <label for="patientName">Ime pacijenta</label>
            <input type="text" name="patient_name" id="patientName" value="<?= $name ?>">
            <input type="hidden" name="old_name" value="<?= $name ?>">
            <label for="phone">Broj telefona</label>
            <input type="text" name="phone" id="phone" value="<?= $phone ?>">
            <button class="btn">Sačuvaj</button>
        </form>
    </div>
</body>

</html>