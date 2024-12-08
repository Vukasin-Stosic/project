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
        <form class="form" action="controllers/create_patient.php" method="post">
            <label for="patientName">Ime pacijenta</label>
            <input type="text" name="patientName" id="patientName" placeholder="Petrovic Petar...">
            <label for="phone">Broj telefona</label>
            <input type="text" name="phone" id="phone" placeholder="065123...">
            <button class="btn">Dodaj</button>
        </form>
    </div>
</body>

</html>