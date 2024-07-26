drop database if exists Waffenverwaltungssystem;


CREATE DATABASE Waffenverwaltungssystem;
USE Waffenverwaltungssystem;


CREATE TABLE Administratoren (
                                 id INT AUTO_INCREMENT PRIMARY KEY,
                                 name VARCHAR(100),
                                 email VARCHAR(100),
                                 kontakt VARCHAR(100),
                                 adresse VARCHAR(255),
                                 pwhash VARCHAR(255)
);


CREATE TABLE Lieferanten (
                             lieferant_id INT AUTO_INCREMENT PRIMARY KEY,
                             name VARCHAR(100),
                             kontakt VARCHAR(100),
                             adresse VARCHAR(100)
);

CREATE TABLE Produkte (
                          produkt_id INT AUTO_INCREMENT PRIMARY KEY,
                          name VARCHAR(100),
                          kategorien VARCHAR(100),
                          menge INT
                          #lieferant_id INT,
                          #FOREIGN KEY (lieferant_id) REFERENCES Lieferanten(lieferant_id)
);


CREATE TABLE Bestellungen (
                              bestell_id INT AUTO_INCREMENT PRIMARY KEY,
                              produkt_id INT,
                              bestelldatum DATE,
                              menge INT,
                              status VARCHAR(50),
                              FOREIGN KEY (produkt_id) REFERENCES Produkte(produkt_id)
);
CREATE TABLE Produkt_Lieferant (
                                   produkt_id INT,
                                   lieferant_id INT,
                                   PRIMARY KEY (produkt_id, lieferant_id),
                                   FOREIGN KEY (produkt_id) REFERENCES Produkte(produkt_id),
                                   FOREIGN KEY (lieferant_id) REFERENCES Lieferanten(lieferant_id)
);

CREATE TABLE Bestellung_Produkt (
                                    bestell_id INT,
                                    produkt_id INT,
                                    menge INT,
                                    PRIMARY KEY (bestell_id, produkt_id),
                                    FOREIGN KEY (bestell_id) REFERENCES Bestellungen(bestell_id),
                                    FOREIGN KEY (produkt_id) REFERENCES Produkte(produkt_id)
);

CREATE TABLE Kategorien (
                            kategorie_id INT AUTO_INCREMENT PRIMARY KEY,
                            name VARCHAR(100)
);

