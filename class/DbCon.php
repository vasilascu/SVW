<?php



class DbCon
{
    public static function dbcon(): PDO
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "Waffenverwaltungssystem";
        return new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    }

}