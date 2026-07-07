USE kapsalon_db;

-- ============================================
-- FULL SCHEMA + SEED DATA
-- ============================================

SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci;
SET collation_connection = utf8mb4_unicode_ci;
ALTER DATABASE `kapsalon_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Drop tabellen in de juiste volgorde (vanwege foreign keys)
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS LeverancierOrder;
DROP TABLE IF EXISTS BehandelingPerVoorraad;
DROP TABLE IF EXISTS Afspraak;
DROP TABLE IF EXISTS KlantPerContact;
DROP TABLE IF EXISTS MedewerkerPerContact;
DROP TABLE IF EXISTS MedewerkerPerBehandeling;
DROP TABLE IF EXISTS Beschikbaarheid;
DROP TABLE IF EXISTS Klant;
DROP TABLE IF EXISTS Medewerker;
DROP TABLE IF EXISTS Voorraad;
DROP TABLE IF EXISTS Product;
DROP TABLE IF EXISTS Leverancier;
DROP TABLE IF EXISTS Behandeling;
DROP TABLE IF EXISTS Contact;
DROP TABLE IF EXISTS Categorie;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE Contact (
    Id INT UNSIGNED PRIMARY KEY,
    Straatnaam VARCHAR(100),
    Huisnummer INT,
    Toevoeging VARCHAR(10),
    Postcode VARCHAR(10),
    Plaats VARCHAR(50),
    Email VARCHAR(100),
    Mobiel VARCHAR(20),
    IsActief BIT NOT NULL DEFAULT b'1',
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
);

INSERT INTO Contact (Id, Straatnaam, Huisnummer, Toevoeging, Postcode, Plaats, Email, Mobiel) VALUES
(1, 'Kanaalstraat', 12, NULL, '3511AB', 'Utrecht', 'fatima@kniplokettiko.nl', '0612345678'),
(2, 'Croeselaan', 101, NULL, '3521BJ', 'Utrecht', 'sanne.devries@kniplokettiko.nl', '0611111111'),
(3, 'Amsterdamsestraatweg', 223, NULL, '3551CG', 'Utrecht', 'mohamed.elidrissi@kniplokettiko.nl', '0611111112'),
(4, 'Maliebaan', 17, NULL, '3581CC', 'Utrecht', 'lisa.vandijk@kniplokettiko.nl', '0611111113'),
(5, 'Balijelaan', 63, NULL, '3521GM', 'Utrecht', 'youssef.benali@kniplokettiko.nl', '0611111114'),
(6, 'Nachtegaalstraat', 95, NULL, '3581AE', 'Utrecht', 'noor.bakker@kniplokettiko.nl', '0611111115'),
(7, 'Bernardlaan', 7, NULL, '3527GA', 'Utrecht', 'kevin.smit@kniplokettiko.nl', '0611111116'),
(8, 'Laan van Nieuw-Guinea', 141, NULL, '3531JE', 'Utrecht', 'aylin.demir@kniplokettiko.nl', '0611111117'),
(9, 'Marnixlaan', 205, NULL, '3552HD', 'Utrecht', 'tom.verhoeven@kniplokettiko.nl', '0611111118'),
(10, 'Haroekoeplein', 29, NULL, '3531WK', 'Utrecht', 'romy.jacobs@kniplokettiko.nl', '0611111119'),
(11, 'Oudegracht', 88, 'A', '3512AB', 'Utrecht', 'piet.van.loenen@gmail.com', '+31 6 1234 61 71'),
(12, 'Biltstraat', 44, NULL, '3572BC', 'Utrecht', 'jan.jansen@outlook.com', '+31 6 1234 61 72'),
(13, 'Merelstraat', 12, NULL, '3514CN', 'Utrecht', 'saskia.deboer@yahoo.com', '+31 6 1234 61 73'),
(14, 'Winkel van Sinkelstraat', 4, NULL, '3511KV', 'Utrecht', 'ahmed.mansouri@icloud.com', '+31 6 1234 61 74'),
(15, 'Adelaarstraat', 50, NULL, '3514CH', 'Utrecht', 'marieke.vandenberg@ziggo.nl', '+31 6 1234 61 75'),
(16, 'Vleutenseweg', 73, NULL, '3532HA', 'Utrecht', 'daan.visser@live.nl', '+31 6 1234 61 76');

CREATE TABLE Behandeling (
    Id INT UNSIGNED PRIMARY KEY,
    Naam VARCHAR(100),
    Omschrijving VARCHAR(255),
    Duurminuten INT,
    Prijs DECIMAL(10, 2),
    IsActief BIT NOT NULL DEFAULT b'1',
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
);

INSERT INTO Behandeling (Id, Naam, Omschrijving, Duurminuten, Prijs) VALUES
(1, 'Knippen', 'Haar knippen en eventueel stylen.', 30, 30.00),
(2, 'Combi behandelingen', 'Combinatie van knippen, kleuren en stylen.', 90, 90.00),
(3, 'Kleuren', 'Haar kleuren (diverse technieken).', 60, 60.00),
(4, 'Permanent', 'Permanente omvorming van het haar.', 120, 110.00),
(5, 'Extensions', 'Plaatsen en verzorgen van extensions.', 180, 250.00); 

CREATE TABLE Medewerker (
    Id INT UNSIGNED PRIMARY KEY,
    UserId BIGINT UNSIGNED NOT NULL,
    Voornaam VARCHAR(50) NOT NULL,
    Tussenvoegsel VARCHAR(20) NULL,
    Achternaam VARCHAR(50) NOT NULL,
    Specialisatie VARCHAR(50) NOT NULL,
    Geboortedatum DATE NOT NULL,
    IsActief BIT NOT NULL DEFAULT b'1',
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    CONSTRAINT fk_user FOREIGN KEY (UserId) REFERENCES users(id)
);

INSERT INTO Medewerker (Id, UserId, Voornaam, Tussenvoegsel, Achternaam, Specialisatie, Geboortedatum) VALUES
(1, 2, 'Fatima', NULL, 'El Amrani', 'Knippen', '1988-04-12'),
(2, 3, 'Sanne', 'de', 'Vries', 'Kleuren', '1996-09-25'),
(3, 4, 'Mohamed', NULL, 'El Idrissi', 'Extensions', '1992-02-14'),
(4, 5, 'Lisa', 'van', 'Dijk', 'Stylen', '1998-07-08'),
(5, 6, 'Youssef', NULL, 'Benali', 'Knippen', '1990-11-30'),
(6, 7, 'Noor', NULL, 'Bakker', 'Kleuren', '1997-05-21'),
(7, 8, 'Kevin', NULL, 'Smit', 'Extensions', '2001-03-17'),
(8, 9, 'Aylin', NULL, 'Demir', 'Stylen', '1999-12-04'),
(9, 10, 'Tom', NULL, 'Verhoeven', 'Knippen', '1995-08-19'),
(10, 11, 'Romy', NULL, 'Jacobs', 'Knippen', '2010-01-15');

CREATE TABLE Beschikbaarheid (
    Id INT UNSIGNED PRIMARY KEY,
    MedewerkerId INT UNSIGNED NOT NULL,
    Dagnaam VARCHAR(20) NOT NULL,
    Datum DATE NOT NULL,
    Starttijd TIME NOT NULL,
    Eindtijd TIME NOT NULL,
    BeschStatus VARCHAR(50) NOT NULL,
    IsActief BIT NOT NULL DEFAULT b'1',
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    CONSTRAINT fk_medewerker FOREIGN KEY (MedewerkerId) REFERENCES Medewerker(Id)
);

INSERT INTO Beschikbaarheid (Id, MedewerkerId, Dagnaam, Datum, Starttijd, Eindtijd, BeschStatus) VALUES
(1, 1, 'Woensdag', '2026-07-15', '09:00:00', '17:00:00', 'Beschikbaar'),
(2, 1, 'Vrijdag', '2026-07-10', '09:00:00', '17:00:00', 'Beschikbaar'),
(3, 2, 'Woensdag', '2026-07-15', '09:00:00', '17:00:00', 'Beschikbaar'),
(4, 2, 'Vrijdag', '2026-07-10', '09:00:00', '17:00:00', 'Beschikbaar'),
(5, 3, 'Woensdag', '2026-07-15', '09:00:00', '17:00:00', 'Beschikbaar'),
(6, 3, 'Vrijdag', '2026-07-10', '09:00:00', '17:00:00', 'Beschikbaar'),
(7, 4, 'Woensdag', '2026-07-15', '09:00:00', '17:00:00', 'Beschikbaar'),
(8, 4, 'Vrijdag', '2026-07-10', '09:00:00', '17:00:00', 'Beschikbaar'),
(9, 5, 'Woensdag', '2026-07-15', '09:00:00', '17:00:00', 'Beschikbaar'),
(10, 5, 'Vrijdag', '2026-07-10', '09:00:00', '17:00:00', 'Beschikbaar'),
(11, 6, 'Woensdag', '2026-07-15', '09:00:00', '17:00:00', 'Beschikbaar'),
(12, 6, 'Vrijdag', '2026-07-10', '09:00:00', '17:00:00', 'Beschikbaar'),
(13, 7, 'Woensdag', '2026-07-15', '09:00:00', '17:00:00', 'Beschikbaar'),
(14, 7, 'Vrijdag', '2026-07-10', '09:00:00', '17:00:00', 'Beschikbaar'),
(15, 8, 'Woensdag', '2026-07-15', '09:00:00', '17:00:00', 'Beschikbaar'),
(16, 8, 'Vrijdag', '2026-07-10', '09:00:00', '17:00:00', 'Beschikbaar'),
(17, 9, 'Woensdag', '2026-07-15', '09:00:00', '17:00:00', 'Beschikbaar'),
(18, 9, 'Vrijdag', '2026-07-10', '09:00:00', '17:00:00', 'Beschikbaar'),
(19, 10, 'Woensdag', '2026-07-15', '09:00:00', '17:00:00', 'Beschikbaar'),
(20, 10, 'Vrijdag', '2026-07-10', '09:00:00', '17:00:00', 'Beschikbaar');

CREATE TABLE MedewerkerPerContact (
    Id INT UNSIGNED PRIMARY KEY,
    MedewerkerId INT UNSIGNED NULL, 
    ContactId INT UNSIGNED NOT NULL,
    IsActief BIT NOT NULL DEFAULT b'1',
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    CONSTRAINT fk_medewerker_contact FOREIGN KEY (MedewerkerId) REFERENCES Medewerker(Id),
    CONSTRAINT fk_contact_ref FOREIGN KEY (ContactId) REFERENCES Contact(Id)
);

INSERT INTO MedewerkerPerContact (Id, MedewerkerId, ContactId) VALUES
(1, 1, 1), (2, 2, 2), (3, 3, 3), (4, 4, 4), (5, 5, 5),
(6, 6, 6), (7, 7, 7), (8, 8, 8), (9, 9, 9), (10, 10, 10);   

CREATE TABLE MedewerkerPerBehandeling (
    Id INT UNSIGNED PRIMARY KEY,
    MedewerkerId INT UNSIGNED NOT NULL,
    BehandelingId INT UNSIGNED NOT NULL,
    IsActief BIT NOT NULL DEFAULT b'1',
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    CONSTRAINT fk_medewerker_bh FOREIGN KEY (MedewerkerId) REFERENCES Medewerker(Id),
    CONSTRAINT fk_behandeling_ref FOREIGN KEY (BehandelingId) REFERENCES Behandeling(Id)
);

INSERT INTO MedewerkerPerBehandeling (Id, MedewerkerId, BehandelingId) VALUES
(1, 1, 1), (2, 1, 3), (3, 1, 2), (4, 2, 1), (5, 2, 3),
(6, 3, 1), (7, 3, 3), (8, 4, 1), (9, 4, 3), (10, 4, 2), (11, 5, 4);    

CREATE TABLE Klant (
    Id INT UNSIGNED PRIMARY KEY,
    UserId BIGINT UNSIGNED NOT NULL,
    Voornaam VARCHAR(50),
    Tussenvoegsel VARCHAR(20) NULL,
    Achternaam VARCHAR(50) NOT NULL,
    Relatienummer VARCHAR(20) NOT NULL,
    Bijzonderheden VARCHAR(255) NOT NULL,
    IsActief BIT NOT NULL DEFAULT b'1',
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    CONSTRAINT fk_klant_user FOREIGN KEY (UserId) REFERENCES users(id)
);

INSERT INTO Klant (Id, UserId, Voornaam, Tussenvoegsel, Achternaam, Relatienummer, Bijzonderheden) VALUES
(1, 12, 'Piet', 'van', 'Loenen', 'KL-2026-001', 'Voorkeur voor ochtendafspraken.'),
(2, 13, 'Jan', NULL, 'Jansen', 'KL-2026-002', 'Allergie voor sterk geparfumeerde producten.'),
(3, 14, 'Saskia', 'de', 'Boer', 'KL-2026-003', 'Komt elke zes weken.'),
(4, 15, 'Ahmed', NULL, 'Mansouri', 'KL-2026-004', 'Wil strakke fade.'),
(5, 16, 'Marieke', 'van den', 'Berg', 'KL-2026-005', 'Gevoelige hoofdhuid.'),
(6, 17, 'Daan', NULL, 'Visser', 'KL-2026-006', 'Liefst einde middag.');

CREATE TABLE Categorie (
    Id INT UNSIGNED PRIMARY KEY,
    Naam VARCHAR(100) NOT NULL,
    Omschrijving VARCHAR(255) NOT NULL,
    IsActief BIT NOT NULL DEFAULT b'1',
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
);

INSERT INTO Categorie (Id, Naam, Omschrijving) VALUES
(1, 'Haarverzorging', 'Producten voor wassen en verzorgen.'),
(2, 'Kleurproducten', 'Producten voor kleurbehandelingen.'),
(3, 'Styling', 'Producten voor afwerking en styling.'),
(4, 'Accessoires', 'Accessoires voor verkoop in de salon.');

CREATE TABLE Product (
    Id INT UNSIGNED PRIMARY KEY,
    CategorieId INT UNSIGNED NOT NULL,
    Naam VARCHAR(100) NOT NULL,
    Omschrijving VARCHAR(255) NOT NULL,
    Merk VARCHAR(100) NOT NULL,
    EANcode VARCHAR(13) NOT NULL,
    Houdbaarheidsdatum DATE NOT NULL,
    InkoopPrijs DECIMAL(10,2) NOT NULL,
    VerkoopPrijs DECIMAL(10,2) NOT NULL,
    IsActief BIT NOT NULL DEFAULT b'1',
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    CONSTRAINT fk_product_categorie FOREIGN KEY (CategorieId) REFERENCES Categorie(Id)
);

INSERT INTO Product (Id, CategorieId, Naam, Omschrijving, Merk, EANcode, Houdbaarheidsdatum, InkoopPrijs, VerkoopPrijs) VALUES
(1, 1, 'Hydrating Shampoo', 'Milde salonshampoo voor dagelijks gebruik.', 'Tiko Care', '0871234500001', '2027-07-01', 6.50, 14.95),
(2, 1, 'Repair Conditioner', 'Voedende conditioner voor beschadigd haar.', 'Tiko Care', '0871234500002', '2027-10-15', 7.25, 16.95),
(3, 1, 'Scalp Balance Masker', 'Kalmerend haarmasker voor gevoelige hoofdhuid.', 'Tiko Care', '0871234500003', '2027-05-20', 8.75, 19.95),
(4, 1, 'Baardolie Cedar', 'Verzorgende olie voor baardbehandelingen.', 'Tiko Beard', '0871234500004', '2027-09-30', 5.75, 12.95),
(5, 2, 'Color Creme 6.1', 'Professionele asdonkerblonde kleurcreme.', 'Tiko Color', '0871234500005', '2026-12-31', 12.50, 24.95),
(6, 2, 'Color Creme 7.43', 'Koperblonde salonkleur met warme ondertoon.', 'Tiko Color', '0871234500006', '2027-01-31', 12.75, 25.95),
(7, 2, 'Developer 6 Procent', 'Oxidatiecreme voor kleurbehandelingen.', 'Tiko Color', '0871234500007', '2027-03-31', 5.95, 11.95),
(8, 3, 'Matte Styling Clay', 'Matte clay met flexibele hold.', 'Tiko Style', '0871234500008', '2027-08-31', 4.95, 12.95),
(9, 3, 'Strong Hold Gel', 'Sterke hold styling gel.', 'Tiko Style', '0871234500009', '2027-03-31', 4.25, 9.95),
(10, 3, 'Heat Protect Spray', 'Beschermende spray voor fohnen en stylen.', 'Tiko Style', '0871234500010', '2027-11-30', 6.10, 15.95);

CREATE TABLE Voorraad (
    Id INT UNSIGNED PRIMARY KEY,
    ProductId INT UNSIGNED NOT NULL,
    AantalOpVoorraad INT UNSIGNED,
    AantalUitgegeven INT UNSIGNED,
    AantalBijgekomen INT UNSIGNED,
    IsActief BIT NOT NULL DEFAULT b'1',
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    CONSTRAINT fk_voorraad_product FOREIGN KEY (ProductId) REFERENCES Product(Id)
);

INSERT INTO Voorraad (Id, ProductId, AantalOpVoorraad, AantalUitgegeven, AantalBijgekomen) VALUES
(1, 1, 40, 0, 40), (2, 2, 28, 2, 30), (3, 3, 18, 0, 18), (4, 4, 20, 0, 20), (5, 5, 25, 0, 25),
(6, 6, 16, 1, 17), (7, 7, 32, 3, 35), (8, 8, 22, 0, 22), (9, 9, 35, 0, 35), (10, 10, 24, 1, 25);

CREATE TABLE BehandelingPerVoorraad (
    Id INT UNSIGNED PRIMARY KEY,
    BehandelingId INT UNSIGNED NOT NULL,
    VoorraadId INT UNSIGNED NOT NULL,
    IsActief BIT NOT NULL DEFAULT b'1',
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    CONSTRAINT fk_bh_ref FOREIGN KEY (BehandelingId) REFERENCES Behandeling(Id),
    CONSTRAINT fk_vr_ref FOREIGN KEY (VoorraadId) REFERENCES Voorraad(Id)
);

INSERT INTO BehandelingPerVoorraad (Id, BehandelingId, VoorraadId) VALUES
(1, 1, 1), (2, 1, 3), (3, 2, 1), (4, 2, 2), (5, 2, 3), (6, 3, 2), (7, 4, 3), (8, 5, 4);

CREATE TABLE Leverancier (
    Id INT PRIMARY KEY,
    Naam VARCHAR(100),
    Straatnaam VARCHAR(100),
    Huisnummer INT,
    Toevoeging VARCHAR(10),
    Postcode VARCHAR(10),
    Plaats VARCHAR(50),
    Email VARCHAR(100),
    Mobiel VARCHAR(20),
    IsActief BIT NOT NULL DEFAULT b'1',
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
);

INSERT INTO Leverancier (Id, Naam, Straatnaam, Huisnummer, Toevoeging, Postcode, Plaats, Email, Mobiel) VALUES
(1, 'Van Duuren Haircosmetics', 'Prinses Irenestraat', 12, 'A', '3584AN', 'Utrecht', 'inkoop@vanduurenhaircosmetics.nl', '+31 623456121'),
(2, 'ColorPro Benelux', 'Gibraltarstraat', 234, NULL, '5611AA', 'Eindhoven', 'orders@colorpro-benelux.nl', '+31 623456122'),
(3, 'SalonStyle Supplies', 'Der Kinderenstraat', 456, 'Bis', '3011AB', 'Rotterdam', 'service@salonstylesupplies.nl', '+31 623456123'),
(4, 'BarberCare Nederland', 'Nachtegaalstraat', 233, 'A', '4811AA', 'Breda', 'bestellingen@barbercare-nederland.nl', '+31 623456124'),
(5, 'HairTools Groothandel', 'Bertram Russellstraat', 45, NULL, '8011AB', 'Zwolle', 'contact@hairtools-groothandel.nl', '+31 623456125');

CREATE TABLE LeverancierOrder (
    Id INT UNSIGNED PRIMARY KEY,
    Ordernummer VARCHAR(20) NOT NULL,
    ProductId INT UNSIGNED NOT NULL,
    LeverancierId INT NOT NULL,
    Aantal INT,
    Orderdatum DATE NOT NULL,
    Leverdatum DATE NULL,
    Leverstatus VARCHAR(50),
    IsActief BIT NOT NULL DEFAULT b'1',
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    CONSTRAINT fk_ord_prod FOREIGN KEY (ProductId) REFERENCES Product(Id),
    CONSTRAINT fk_ord_lev FOREIGN KEY (LeverancierId) REFERENCES Leverancier(Id)
);

INSERT INTO LeverancierOrder (Id, Ordernummer, ProductId, LeverancierId, Aantal, Orderdatum, Leverdatum, Leverstatus) VALUES
(1, 'ORD-2026-1001', 1, 1, 12, '2026-05-04', NULL, 'Inbehandeling'),
(2, 'ORD-2026-1002', 5, 2, 8, '2026-05-05', NULL, 'Inbehandeling'),
(3, 'ORD-2026-1003', 9, 3, 10, '2026-05-06', '2026-05-08', 'Geleverd'),
(4, 'ORD-2026-1004', 7, 2, 6, '2026-05-07', NULL, 'Nietleverbaar'),
(5, 'ORD-2026-1005', 10, 4, 9, '2026-05-08', NULL, 'Inbehandeling'),
(6, 'ORD-2026-1006', 2, 1, 7, '2026-05-09', NULL, 'Inbehandeling'),
(7, 'ORD-2026-1007', 3, 1, 6, '2026-05-10', NULL, 'Inbehandeling'),
(8, 'ORD-2026-1008', 4, 4, 5, '2026-05-10', NULL, 'Inbehandeling'),
(9, 'ORD-2026-1009', 6, 2, 6, '2026-05-11', NULL, 'Inbehandeling'),
(10, 'ORD-2026-1010', 8, 3, 8, '2026-05-11', NULL, 'Inbehandeling');

CREATE TABLE KlantPerContact (
    Id INT UNSIGNED PRIMARY KEY,
    KlantId INT UNSIGNED NOT NULL,
    ContactId INT UNSIGNED NOT NULL,
    IsActief BIT NOT NULL DEFAULT b'1',
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    CONSTRAINT fk_kp_klant FOREIGN KEY (KlantId) REFERENCES Klant(Id),
    CONSTRAINT fk_kp_contact FOREIGN KEY (ContactId) REFERENCES Contact(Id)
);

INSERT INTO KlantPerContact (Id, KlantId, ContactId) VALUES
(1, 1, 11), (2, 2, 12), (3, 3, 13), (4, 4, 14), (5, 5, 15), (6, 6, 16);

CREATE TABLE Afspraak (
    Id INT UNSIGNED NOT NULL PRIMARY KEY,
    KlantId INT UNSIGNED NOT NULL,
    MedewerkerPerBehandelingId INT UNSIGNED NOT NULL,
    BeschikbaarheidId INT UNSIGNED NOT NULL,
    Datum DATE NOT NULL,
    Starttijd TIME NOT NULL,
    Afspraakstatus VARCHAR(50),
    IsActief BIT NOT NULL DEFAULT b'1',
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    CONSTRAINT fk_afsp_klant FOREIGN KEY (KlantId) REFERENCES Klant(Id),
    CONSTRAINT fk_afsp_mbh FOREIGN KEY (MedewerkerPerBehandelingId) REFERENCES MedewerkerPerBehandeling(Id),
    CONSTRAINT fk_afsp_besch FOREIGN KEY (BeschikbaarheidId) REFERENCES Beschikbaarheid(Id)
);

INSERT INTO Afspraak (Id, KlantId, MedewerkerPerBehandelingId, BeschikbaarheidId, Datum, Starttijd, Afspraakstatus) VALUES
(1, 1, 1, 2, '2026-07-10', '10:00:00', 'Inbehandeling'),
(2, 2, 2, 7, '2026-07-15', '11:30:00', 'Behandeld'),
(3, 5, 8, 8, '2026-07-10', '14:00:00', 'Geannuleerd'),
(4, 6, 11, 4, '2026-07-10', '13:30:00', 'Behandeld'),
(5, 3, 6, 6, '2026-07-10', '15:00:00', 'Inbehandeling'),
(6, 4, 10, 9, '2026-07-15', '12:30:00', 'Geannuleerd');