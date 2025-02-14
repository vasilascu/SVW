<?php
// Klasse Produkte
namespace App;
use PDO;

class Produkte
{
    // Eigenschaften
    private int $produkt_id;
    private string $name;
    private string $kategorien;
    private int $menge;
    private int $lieferant_id;

    // Konstruktor
    public function __construct(int $produkt_id, string $name, string $kategorien, int $menge)
    {
        $this->produkt_id = $produkt_id;
        $this->name = $name;
        $this->kategorien = $kategorien;
        $this->menge = $menge;


    }

    // Verbindung zur Datenbank herstellen
    public static function dbcon(): PDO
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "Waffenverwaltung";
        return new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    }

    // Methode zum Erstellen eines neuen Produkts
    public static function create(string $name, string $kategorien, int $menge, int $lieferant_id): Produkte
    {
        $con = self::dbcon();
        $sql = 'INSERT INTO produkte (name, kategorien, menge) VALUES (:name, :kategorien, :menge)';
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':kategorien', $kategorien);
        $stmt->bindParam(':menge', $menge);
        $stmt->bindParam(':lieferant_id', $lieferant_id);
        $stmt->execute();
        return new Produkte($con->lastInsertId(), $name, $kategorien, $menge, $lieferant_id);
    }

    // Methode zum Aktualisieren eines Produkts
    public function update(string $name, string $kategorien, int $menge, int $lieferant_id): bool
    {
        $con = self::dbcon();
        $sql = 'UPDATE produkte SET name = :name, kategorien = :kategorien, menge = :menge WHERE produkt_id = :produkt_id';
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':kategorien', $kategorien);
        $stmt->bindParam(':menge', $menge);
        $stmt->bindParam(':lieferant_id', $lieferant_id);
        $stmt->bindParam(':produkt_id', $this->produkt_id);
        return $stmt->execute();
    }

    // Methode zum Löschen eines Produkts
    public static function delete(int $produkt_id): bool
    {
        $con = self::dbcon();
        $sql = 'DELETE FROM produkte WHERE produkt_id = :produkt_id';
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':produkt_id', $produkt_id);
        return $stmt->execute();
    }

    // Methode zum Abrufen eines Produkts nach id
    public static function findById(int $produkt_id): Produkte
    {
        $con = self::dbcon();
        $sql = 'SELECT * FROM produkte WHERE produkt_id= :produkt_id';
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':produkt_id', $produkt_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Produkte($result['produkt_id'], $result['name'], $result['kategorien'], $result['menge']);
    }

    // Methode zum Abrufen aller Produkte
    public static function getAll(): array
    {
        $con = self::dbcon();
        $sql = 'SELECT * FROM produkte';
        $stmt = $con->query($sql);
        $produkte = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $produkte[] = new Produkte($row['produkt_id'], $row['name'], $row['kategorien'], $row['menge']);
        }
        return $produkte;
    }
########################################
    public static function search($keyword): array
    {
        $con = self::dbcon();
        $sql = 'SELECT * FROM produkte WHERE name LIKE :keyword OR kategorien LIKE :keyword';
        $stmt = $con->prepare($sql);
        $keyword = '%' . $keyword . '%';
        $stmt->bindParam(':keyword', $keyword);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $produkte = [];
        foreach ($results as $result) {
            $produkte[] = new Produkte($result['produkt_id'], $result['name'], $result['kategorien'], $result['menge'], $result['lieferant_id']);
        }
        return $produkte;
    }

    public static function getPaginated($limit, $offset): array
    {
        $con = self::dbcon();
        $sql = 'SELECT * FROM produkte LIMIT :limit OFFSET :offset';
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $produkte = [];
        foreach ($results as $result) {
            $produkte[] = new Produkte($result['produkt_id'], $result['name'], $result['kategorien'], $result['menge']);
        }
        return $produkte;
    }
    public static function countAll(): int
    {
        $con = self::dbcon();
        $sql = 'SELECT COUNT(*) as total FROM produkte';
        $stmt = $con->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$result['total'];
    }


###########################################

    public function getId(): int
    {
        return $this->produkt_id;
    }

    public function getName(): string
    {
        return $this->name;
    }


    public function getMenge(): int
    {
        return $this->menge;
    }

//    public function getLieferantId(): int
//    {
//        return $this->lieferant_id;
//    }

    public function getKategorie(): int
    {
        return $this->produkt_id;
    }

}
?>
