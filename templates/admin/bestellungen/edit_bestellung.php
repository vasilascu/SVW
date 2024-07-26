<?php
require __DIR__ . '/../../../vendor/autoload.php'; // Include Composer autoload
include __DIR__ . '/../../../login/auth.php';

use App\Bestellungen;
use App\Produkte;

//if (!isAuthenticated()) {
//    header('Location: ../../login/showLogin.php');
//    exit();
//}

$bestell_id = $_GET['id'];
$bestellung = Bestellungen::findById($bestell_id);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $produkt_id = $_POST['produkt_id'];
    $menge = $_POST['menge'];
    $bestelldatum = new DateTime($_POST['bestelldatum']);
    $status = $_POST['status'];

    $bestellung->setProduktId($produkt_id);
    $bestellung->setMenge($menge);
    $bestellung->setBestelldatum($bestelldatum);
    $bestellung->setStatus($status);
    $bestellung->update();

    header('Location: bestellungen.php');
    exit();
}

$produkte = Produkte::getAll();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestellung bearbeiten</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('https://img.pikbest.com/back_our/20211003/bg/97a7229f4c02f.png!bwr800');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        .container {
            background-color: rgba(255, 254, 254, 0.8);
            padding: 20px;
            border-radius: 10px;
        }
    </style>

</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between mb-4">

        <a href="bestellungen.php" class="btn btn-secondary">Zurück zur Bestellungsverwaltung</a>
        <a href="/login/logout.php" class="btn btn-danger">Abmelden</a>
    </div>
    <h1>Bestellung bearbeiten</h1>
    <form method="post" action="edit_bestellung.php?id=<?= $bestell_id ?>">
        <div class="form-group">
            <label for="produkt_id">Produkt:</label>
            <select id="produkt_id" name="produkt_id" class="form-control" required>
                <?php foreach ($produkte as $produkt): ?>
                    <option value="<?= $produkt->getId(); ?>" <?= $produkt->getId() == $bestellung->getProduktId() ? 'selected' : ''; ?>><?= $produkt->getName(); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="menge">Menge:</label>
            <input type="number" id="menge" name="menge" class="form-control" value="<?= $bestellung->getMenge(); ?>" required>
        </div>
        <div class="form-group">
            <label for="bestelldatum">Bestelldatum:</label>
            <input type="date" id="bestelldatum" name="bestelldatum" class="form-control" value="<?= $bestellung->getBestelldatum()->format('Y-m-d'); ?>" required>
        </div>
        <div class="form-group">
            <label for="status">Status:</label>
            <input type="text" id="status" name="status" class="form-control" value="<?= $bestellung->getStatus(); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Bestellung speichern</button>
    </form>
</div>
</body>
</html>
