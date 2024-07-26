<?php

require __DIR__ . '/../../../vendor/autoload.php';

use App\Lieferanten;

include __DIR__ . '/../../../login/auth.php'; // Authentifizierungsdatei einbinden

if (!isAuthenticated()) { // Überprüfung der Authentifizierung
    header("Location: /SVW/login/showLogin.php"); // Weiterleitung zum Login, wenn nicht authentifiziert
    exit();
}

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lieferanten verwalten</title>
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
            <a href="add_lieferant.php" class="btn btn-success">Neuen Lieferanten hinzufügen</a>
            <a href="/view/index.php" class="btn btn-secondary">Hauptseite</a>
        </div>
        <a href="/login/logout.php" class="btn btn-danger">Abmelden</a>
    </div>
    <form method="GET" action="" class="form-inline mb-4">
        <label>
            <input type="text" name="search" class="form-control mr-2" placeholder="Lieferanten suchen...">
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
        $lieferanten = Lieferanten::search($search);
        $totalLieferanten = count($lieferanten); // Gesamtzahl der gefundenen Ergebnisse
        $lieferanten = array_slice($lieferanten, $offset, $limit); // Manuelle Paginierung des Arrays
    } else {
        $lieferanten = Lieferanten::getPaginated($limit, $offset);
        $totalLieferanten = Lieferanten::countAll(); // Implementiert eine Methode zur Zählung aller Lieferanten
    }
    $totalPages = ceil($totalLieferanten / $limit);
    ?>

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Kontakt</th>
            <th>Adresse</th>
            <th>Aktionen</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($lieferanten as $lieferant) { ?>
            <tr>
                <td><?php echo $lieferant->getLieferantId(); ?></td>
                <td><?php echo $lieferant->getName(); ?></td>
                <td><?php echo $lieferant->getKontakt(); ?></td>
                <td><?php echo $lieferant->getAdresse(); ?></td>
                <td>
                    <a href="edit_lieferant.php?id=<?php echo $lieferant->getLieferantId(); ?>" class="btn btn-warning btn-sm">Bearbeiten</a>
                    <a href="delete_lieferant.php?id=<?php echo $lieferant->getLieferantId(); ?>" class="btn btn-danger btn-sm">Löschen</a>
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

    <!-- Kontakt Diagramm -->
    <canvas id="contactsChart" width="400" height="200"></canvas>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let ctx = document.getElementById('contactsChart').getContext('2d');
        let contactsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [<?php foreach ($lieferanten as $lieferant) { echo '"' . $lieferant->getName() . '",'; } ?>],
                datasets: [{
                    label: 'Kontakt',
                    data: [<?php foreach ($lieferanten as $lieferant) { echo '"' . $lieferant->getKontakt() . '",'; } ?>],
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
