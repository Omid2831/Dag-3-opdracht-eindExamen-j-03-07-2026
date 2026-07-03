DELIMITER //

CREATE PROCEDURE GetAllAfspraken()
BEGIN
    SELECT 
        A.Id,
        CASE 
            WHEN K.Tussenvoegsel IS NULL OR K.Tussenvoegsel = '' THEN CONCAT(K.Voornaam, ' ', K.Achternaam)
            ELSE CONCAT(K.Voornaam, ' ', K.Tussenvoegsel, ' ', K.Achternaam)
        END AS KlantNaam,
        CASE 
            WHEN M.Tussenvoegsel IS NULL OR M.Tussenvoegsel = '' THEN CONCAT(M.Voornaam, ' ', M.Achternaam)
            ELSE CONCAT(M.Voornaam, ' ', M.Tussenvoegsel, ' ', M.Achternaam)
        END AS MedewerkerNaam,
        B.Naam AS BehandelingNaam,
        A.Datum,
        A.Starttijd,
        B.Duurminuten AS Duur,
        ADDTIME(A.Starttijd, SEC_TO_TIME(B.Duurminuten * 60)) AS Eindtijd,
        A.Afspraakstatus AS Status
    FROM Afspraak A
    INNER JOIN Klant K ON A.KlantId = K.Id
    INNER JOIN MedewerkerPerBehandeling MPB ON A.MedewerkerPerBehandelingId = MPB.Id
    INNER JOIN Medewerker M ON MPB.MedewerkerId = M.Id
    INNER JOIN Behandeling B ON MPB.BehandelingId = B.Id
    WHERE A.IsActief = b'1'
    ORDER BY A.Datum ASC, A.Starttijd ASC;
END //

DELIMITER ;
