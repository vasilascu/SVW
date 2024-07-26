<?php
require '../vendor/autoload.php';

use Faker\Factory;

// Conectare la baza de date
$pdo = new PDO('mysql:host=localhost;dbname=Waffenverwaltungssystem', 'root', '');

// Creare instanță Faker
$faker = Factory::create('de_DE');

// Funcție pentru a insera date în tabela Administratoren
function populateAdministratoren($pdo, $faker, $numRecords = 10): void
{
    $sql = 'INSERT INTO Administratoren (name, email, kontakt, adresse, pwhash) VALUES (:name, :email, :kontakt, :adresse, :pwhash)';
    $stmt = $pdo->prepare($sql);

    for ($i = 0; $i < $numRecords; $i++) {
        $stmt->execute([
            ':name' => $faker->name,
            ':email' => $faker->email,
            ':kontakt' => $faker->phoneNumber,
            ':adresse' => $faker->address,
            ':pwhash' => password_hash($faker->password, PASSWORD_DEFAULT)
        ]);
    }
}

// Funcție pentru a insera date în tabela Lieferanten
function populateLieferanten($pdo, $faker, $numRecords = 10)
{
    $sql = 'INSERT INTO Lieferanten (name, kontakt, adresse) VALUES (:name, :kontakt, :adresse)';
    $stmt = $pdo->prepare($sql);

    for ($i = 0; $i < $numRecords; $i++) {
        $stmt->execute([
            ':name' => $faker->company,
            ':kontakt' => $faker->phoneNumber,
            ':adresse' => $faker->address
        ]);
    }
}

// Funcție pentru a insera date în tabela Produkte
function populateProdukte($pdo, $faker, $numRecords = 10)
{
    $sql = 'INSERT INTO Produkte (name, kategorien, menge) VALUES (:name, :kategorien, :menge)';
    $stmt = $pdo->prepare($sql);

    for ($i = 0; $i < $numRecords; $i++) {
        $stmt->execute([
            ':name' => $faker->word,
            ':kategorien' => $faker->word,
            ':menge' => $faker->numberBetween(1, 30)
        ]);
    }
}

// Funcție pentru a insera date în tabela Bestellungen
function populateBestellungen($pdo, $faker, $numRecords = 5)
{
    // Recuperare Produkt_ID
    $produkt_ids = $pdo->query('SELECT produkt_id FROM Produkte')->fetchAll(PDO::FETCH_COLUMN);

    $sql = 'INSERT INTO Bestellungen (produkt_id, bestelldatum, menge, status) VALUES (:produkt_id, :bestelldatum, :menge, :status)';
    $stmt = $pdo->prepare($sql);

    for ($i = 0; $i < $numRecords; $i++) {
        $stmt->execute([
            ':produkt_id' => $faker->randomElement($produkt_ids),
            ':bestelldatum' => $faker->date,
            ':menge' => $faker->numberBetween(1, 100),
            ':status' => $faker->randomElement(['Anhängig', 'Erledigt', 'Abgebrochen'])
        ]);
    }
}

// Funcție pentru a insera date în tabela Produkt_Lieferant
function populateProduktLieferant($pdo, $faker, $numRecords = 10)
{
    // Recuperare Produkt_ID și Lieferant_ID
    $produkt_ids = $pdo->query('SELECT produkt_id FROM Produkte')->fetchAll(PDO::FETCH_COLUMN);
    $lieferant_ids = $pdo->query('SELECT lieferant_id FROM Lieferanten')->fetchAll(PDO::FETCH_COLUMN);

    $sql = 'INSERT INTO Produkt_Lieferant (produkt_id, lieferant_id) VALUES (:produkt_id, :lieferant_id)';
    $stmt = $pdo->prepare($sql);

    for ($i = 0; $i < $numRecords; $i++) {
        // Verificare duplicat
        $produkt_id = $faker->randomElement($produkt_ids);
        $lieferant_id = $faker->randomElement($lieferant_ids);

        // Verificare dacă perechea există deja în baza de date
        $check_sql = 'SELECT COUNT(*) FROM Produkt_Lieferant WHERE produkt_id = :produkt_id AND lieferant_id = :lieferant_id';
        $check_stmt = $pdo->prepare($check_sql);
        $check_stmt->execute([':produkt_id' => $produkt_id, ':lieferant_id' => $lieferant_id]);

        if ($check_stmt->fetchColumn() == 0) {
            $stmt->execute([
                ':produkt_id' => $produkt_id,
                ':lieferant_id' => $lieferant_id
            ]);
        }
    }
}

// Funcție pentru a insera date în tabela Bestellung_Produkt
function populateBestellungProdukt($pdo, $faker, $numRecords = 10)
{
    // Recuperare Bestell_ID și Produkt_ID
    $bestell_ids = $pdo->query('SELECT bestell_id FROM Bestellungen')->fetchAll(PDO::FETCH_COLUMN);
    $produkt_ids = $pdo->query('SELECT produkt_id FROM Produkte')->fetchAll(PDO::FETCH_COLUMN);

    $sql = 'INSERT INTO Bestellung_Produkt (bestell_id, produkt_id, menge) VALUES (:bestell_id, :produkt_id, :menge)';
    $stmt = $pdo->prepare($sql);

    for ($i = 0; $i < $numRecords; $i++) {
        // Verificare duplicat
        $bestell_id = $faker->randomElement($bestell_ids);
        $produkt_id = $faker->randomElement($produkt_ids);

        // Verificare dacă perechea există deja în baza de date
        $check_sql = 'SELECT COUNT(*) FROM Bestellung_Produkt WHERE bestell_id = :bestell_id AND produkt_id = :produkt_id';
        $check_stmt = $pdo->prepare($check_sql);
        $check_stmt->execute([':bestell_id' => $bestell_id, ':produkt_id' => $produkt_id]);

        if ($check_stmt->fetchColumn() == 0) {
            $stmt->execute([
                ':bestell_id' => $bestell_id,
                ':produkt_id' => $produkt_id,
                ':menge' => $faker->numberBetween(1, 100)
            ]);
        }
    }
}

// Populare tabele kaliber
populateAdministratoren($pdo, $faker, 5);
populateLieferanten($pdo, $faker, 5);
populateProdukte($pdo, $faker, 5);
populateBestellungen($pdo, $faker, 10);
populateProduktLieferant($pdo, $faker, 10);
populateBestellungProdukt($pdo, $faker, 10);
function pupulateKategorie($pdo, $faker, $numRecords = 3)
{
    $sql = 'INSERT INTO Kategorien (name) VALUES (:name)';
    $stmt = $pdo->prepare($sql);

    for ($i = 0; $i < $numRecords; $i++) {
        $kategorien = ['7,62', '9mm', '13mm'];
        $stmt->execute([
            ':name' => $kategorien[$i]

        ]);
    }
}

pupulateKategorie($pdo, $faker, 3);

//INSERT INTO kategorien (id, name) values (NULL, '7.62');
//INSERT INTO kategorien (id, name) values (NULL, '9');
//INSERT INTO kategorie (id, name) values (NULL, '13');
echo "Datenbank erfolgreich gefüllt!";
?>
