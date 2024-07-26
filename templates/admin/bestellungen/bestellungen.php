<?php

require __DIR__ . '/../../../vendor/autoload.php';

use App\Bestellungen;
use App\Produkte;


//if (!isAuthenticated()) { // Überprüfung der Authentifizierung
//    header("Location: /SVW/login/showLogin.php"); // Weiterleitung zum Login, wenn nicht authentifiziert
//    exit();
//}

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestellungen verwalten</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        <div>
            <a href="add_bestellung.php" class="btn btn-success">Neue Bestellung hinzufügen</a>
            <a href="/view/index.php" class="btn btn-secondary">Hauptseite</a>
        </div>
        <a href="/login/logout.php" class="btn btn-danger">Abmelden</a>
    </div>
    <form method="GET" action="" class="form-inline mb-4">
        <label>
            <input type="text" name="search" class="form-control mr-2" placeholder="Bestellungen suchen...">
        </label>
        <button type="submit" class="btn btn-primary">Suchen</button>
    </form>

    <?php
    //  die aktuelle Seite
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = 10; // Anzahl der Einträge pro Seite
    $offset = ($page - 1) * $limit;

    $search = $_GET['search'] ?? '';

    if ($search) {
        $bestellungen = Bestellungen::search($search);
        $totalBestellungen = count($bestellungen); // Gesamtzahl der gefundenen Ergebnisse
        $bestellungen = array_slice($bestellungen, $offset, $limit); // Manuelle Paginierung des Arrays
    } else {
        $bestellungen = Bestellungen::getPaginated($limit, $offset);
        $totalBestellungen = Bestellungen::countAll(); // Implementiert eine Methode zur Zählung aller Bestellungen
    }
    $totalPages = ceil($totalBestellungen / $limit);
    ?>

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Produkt</th>
            <th>Bestelldatum</th>
            <th>Menge</th>
            <th>Status</th>
            <th>Aktionen</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($bestellungen as $bestellung) { ?>
            <tr>
                <td><?php echo $bestellung->getBestellId(); ?></td>
                <td><?php echo Produkte::findById($bestellung->getProduktId())->getName(); ?></td>
                <td><?php echo $bestellung->getBestelldatum()->format('d M Y'); ?></td>
                <td><?php echo $bestellung->getMenge(); ?></td>
                <td><?php echo $bestellung->getStatus(); ?></td>
                <td>
                    <a href="edit_bestellung.php" class="btn btn-warning btn-sm">Bearbeiten</a>
                    <a href="delete_bestellung.php?id=<?php echo $bestellung->getBestellId(); ?>" class="btn btn-danger btn-sm">Löschen</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <!-- Paginierungskontrollen -->
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>

    <!-- Mengen Diagramm -->
    <canvas id="quantitiesChart" width="400" height="200"></canvas>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let ctx = document.getElementById('quantitiesChart').getContext('2d');
        let quantitiesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [<?php foreach ($bestellungen as $bestellung) { echo '"' . Produkte::findById($bestellung->getProduktId())->getName() . '",'; } ?>],
                datasets: [{
                    label: 'Menge',
                    data: [<?php foreach ($bestellungen as $bestellung) { echo $bestellung->getMenge() . ','; } ?>],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    });
</script>
</body>
</html>
