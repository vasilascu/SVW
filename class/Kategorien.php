<?php

class Kategorien
{
    private int $kategorie_id;
    private string $name;

    public function __construct(int $kategorie_id, string $name ){
        $this->kategorie_id = $kategorie_id;
        $this->name = $name;

    }

    public function getKategorieId(): int
    {
        return $this->kategorie_id;
    }

    public function getName(): string
    {
        return $this->name;
    }


    public static function getAll(): array {
        $con = DbCon::dbcon();
        $sql = 'SELECT * FROM kategorien';
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $results = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $results[] = new Kategorien($row['kategorie_id'],$row['name']);
                (int)$row['kategorie_id'];
                $row['name'];

        }
        return $results;
    }


}
