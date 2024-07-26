<?php
require __DIR__ . '/../vendor/autoload.php'; // Composer Autoloader einbinden
//include __DIR__ . '/../../../login/auth.php'; // Authentifizierungsdatei einbinden
//

function dbcon(): PDO {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Waffenverwaltung";
    return new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
}
?>
