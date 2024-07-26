<?php
session_start();

require '../vendor/autoload.php';
include '../function/functions.php';

spl_autoload_register(function ($className) {
    include '../class/' . $className . '.php';
});

// Variablenempfang
$name = ($_POST['name']) ?? '';
$kategorie = ($_POST['kategorien']) ?? '';
$menge = ($_POST['menge']) ?? '';
$lieferant_id = ($_POST['lieferant_id']) ?? '';

$action = ($_REQUEST['action']) ?? '';
$email = ($_POST['email']) ?? '';
$password = ($_POST['password']) ?? '';

if ($action === '') {
    $view = 'showLogin';
    $message = '';
} else if ($action === 'checkLogin') {
    if (login($email, $password)) {
        $view = 'dashboard';

    } else {
        $view = 'showLogin';
        $message = "Ungültige Anmeldeinformationen.";
    }


} elseif ($action === 'teamplates/produkte/add_produkt') {
    //$lieferanten = Lieferanten::getAll();
    $kategorie = Kategorien::getAll();

    print_r($kategorie);
    $view = 'teamplates/produkte/add_produkt';
}


include $view . '.php';
die();
?>


<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Waffenverwaltungssystem</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Waffenverwaltungssystem</a>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="/view/teamplates/produkte/produkte.php">Produkte verwalten</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/view/teamplates/lieferanten/lieferanten.php">Lieferanten verwalten</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/view/teamplates/bestellungen/bestellungen.php">Bestellungen verwalten</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/login/logout.php">Abmelden</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Produkte</h5>
                    <p class="card-text">Verwalten Sie Ihre Waffenbestände.</p>
                    <a href="/view/teamplates/produkte/add_produkt.php" class="btn btn-primary">Neues Produkt
                        hinzufügen</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Lieferanten</h5>
                    <p class="card-text">Verwalten Sie Ihre Lieferanten.</p>
                    <a href="/view/teamplates/lieferanten/add_lieferant.php" class="btn btn-primary">Neuen Lieferanten
                        hinzufügen</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Bestellungen</h5>
                    <p class="card-text">Verwalten Sie Ihre Bestellungen.</p>
                    <a href="/view/teamplates/bestellungen/add_bestellung.php" class="btn btn-primary">Neue Bestellung
                        hinzufügen</a>
                </div>
            </div>
        </div>
    </div>
</div>
<footer class="bg-dark text-white text-center py-3 mt-5">
    <p>&copy; 2024 Waffenverwaltungssystem. Alle Rechte vorbehalten.</p>
</footer>
</body>
</html>


