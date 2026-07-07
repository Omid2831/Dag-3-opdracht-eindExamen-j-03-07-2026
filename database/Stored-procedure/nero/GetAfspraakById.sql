DROP PROCEDURE IF EXISTS GetAfspraakById;

DELIMITER //

CREATE PROCEDURE GetAfspraakById(IN afspraakId INT)
BEGIN
    -- Query 1: Appointment details
    SELECT 
        A.Id,
        A.Datum,
        A.Starttijd,
        A.Afspraakstatus AS Status,
        A.Opmerking AS AfspraakOpmerking,
        A.KlantId,
        A.MedewerkerPerBehandelingId,
        A.BeschikbaarheidId,
        ADDTIME(A.Starttijd, SEC_TO_TIME(B.Duurminuten * 60)) AS Eindtijd,
        
        -- Klant details
        K.Relatienummer,
        K.Bijzonderheden AS KlantBijzonderheden,
        CASE 
            WHEN K.Tussenvoegsel IS NULL OR K.Tussenvoegsel = '' THEN CONCAT(K.Voornaam, ' ', K.Achternaam)
            ELSE CONCAT(K.Voornaam, ' ', K.Tussenvoegsel, ' ', K.Achternaam)
        END AS KlantNaam,
        CK.Straatnaam AS KlantStraat,
        CK.Huisnummer AS KlantHuisnummer,
        CK.Toevoeging AS KlantToevoeging,
        CK.Postcode AS KlantPostcode,
        CK.Plaats AS KlantPlaats,
        CK.Email AS KlantEmail,
        CK.Mobiel AS KlantMobiel,
        
        -- Medewerker details
        MPB.MedewerkerId,
        CASE 
            WHEN M.Tussenvoegsel IS NULL OR M.Tussenvoegsel = '' THEN CONCAT(M.Voornaam, ' ', M.Achternaam)
            ELSE CONCAT(M.Voornaam, ' ', M.Tussenvoegsel, ' ', M.Achternaam)
        END AS MedewerkerNaam,
        M.Specialisatie AS MedewerkerSpecialisatie,
        
        -- Behandeling details
        MPB.BehandelingId,
        B.Naam AS BehandelingNaam,
        B.Omschrijving AS BehandelingOmschrijving,
        B.Duurminuten AS BehandelingDuur,
        B.Prijs AS BehandelingPrijs
    FROM Afspraak A
    INNER JOIN Klant K ON A.KlantId = K.Id
    LEFT JOIN KlantPerContact KPC ON K.Id = KPC.KlantId AND KPC.IsActief = b'1'
    LEFT JOIN Contact CK ON KPC.ContactId = CK.Id
    INNER JOIN MedewerkerPerBehandeling MPB ON A.MedewerkerPerBehandelingId = MPB.Id
    INNER JOIN Medewerker M ON MPB.MedewerkerId = M.Id
    INNER JOIN Behandeling B ON MPB.BehandelingId = B.Id
    WHERE A.Id = afspraakId AND A.IsActief = b'1'
    LIMIT 1;

    -- Query 2: Active employees
    SELECT Id, 
           CASE 
               WHEN Tussenvoegsel IS NULL OR Tussenvoegsel = '' THEN CONCAT(Voornaam, ' ', Achternaam)
               ELSE CONCAT(Voornaam, ' ', Tussenvoegsel, ' ', Achternaam)
           END AS Naam
    FROM Medewerker 
    WHERE IsActief = b'1';

    -- Query 3: Active treatments
    SELECT Id, Naam, Duurminuten 
    FROM Behandeling 
    WHERE IsActief = b'1';
END //

DELIMITER ;
