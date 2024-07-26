<?php

require __DIR__ . '/../../../vendor/autoload.php';

use App\Produkte;




?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produkte</title>
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
            <a href="add_produkt.php" class="btn btn-success">Neuen Produkt hinzufügen</a>
            <a href="/view/index.php" class="btn btn-secondary">Hauptseite</a>
        </div>
        <a href="/login/logout.php" class="btn btn-danger">Abmelden</a>
    </div>
    <form method="GET" action="" class="form-inline mb-4">
        <label>
            <input type="text" name="search" class="form-control mr-2" placeholder="Produkte suchen...">
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
        $produkte = Produkte::search($search);
        $totalProdukte = count($produkte); // Gesamtzahl der gefundenen Ergebnisse
        $produse = array_slice($produkte, $offset, $limit); // Manuelle Paginierung des Arrays
    } else {
        $produkte = Produkte::getPaginated($limit, $offset);
        $totalProdukte = Produkte::countAll(); // Implementiert eine Methode zur Zählung aller Produkte
    }
    $totalPages = ceil($totalProdukte / $limit);
    ?>

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Kategorie</th>
            <th>Menge</th>
            <th>Lieferant ID</th>
            <th>Aktionen</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($produkte as $produkt) { ?>
            <tr>
                <td><?php echo $produkt->getId(); ?></td>
                <td><?php echo $produkt->getName(); ?></td>
                <td><?php echo $produkt->getKategorie(); ?></td>
                <td><?php echo $produkt->getMenge(); ?></td>
<!--                <td>--><?php //echo $produkt->getLieferantId(); ?><!--</td>-->
                <td>
                    <a href="edit_produkt.php?id=<?php echo $produkt->getId(); ?>" class="btn btn-warning btn-sm">Bearbeiten</a>
                    <a href="delete_produkt.php?id=<?php echo $produkt->getId(); ?>" class="btn btn-danger btn-sm">Löschen</a>
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
        var ctx = document.getElementById('quantitiesChart').getContext('2d');
        var quantitiesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [<?php foreach ($produkte as $produkt) { echo '"' . $produkt->getName() . '",'; } ?>],
                datasets: [{
                    label: 'Menge',
                    data: [<?php foreach ($produkte as $produkt) { echo $produkt->getMenge() . ','; } ?>],
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
