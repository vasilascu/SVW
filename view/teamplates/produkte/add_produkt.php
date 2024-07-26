<?php
//
//require 'class/DbCon.php';
//require 'class/Lieferanten.php';
//
//
//$lieferanten = Lieferanten::getAll();
//?>





<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neue Bestellung hinzufügen</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('https://img.pikbest.com/back_our/20211003/bg/97a7229f4c02f.png!bwr800');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
        }
    </style>

</head>

<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between mb-4">
        <a href="produkte.php" class="btn btn-secondary">Zurück zum Produkte verwaltung</a>
        <a href="/login/logout.php" class="btn btn-danger">Abmelden</a>
    </div>
    <h1>Neues Produkt hinzufügen</h1>
    <form method="post" action="add_produkt.php">
        <div class="form-group">
            <label for="produkt_id">Produkt:</label>
            <select id="lieferant_id" name="lieferant_id" class="form-control" required>
                <?php foreach ($lieferanten as $lieferant): ?>
                    <option value="<?= $lieferant->getLieferantId(); ?>"><?= $lieferant->getName(); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="kategorien">Kategorien:</label>
            <input type="text" id="kategorien" name="kategorien" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="menge">Menge:</label>
            <input type="number" id="menge" name="menge" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Produkt hinzufügen</button>
    </form>

</body>
</html>
