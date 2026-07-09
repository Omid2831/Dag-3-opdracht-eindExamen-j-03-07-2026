USE kapsalon_db;

DROP PROCEDURE IF EXISTS GetBehandelingenOverzicht;

DELIMITER //

CREATE PROCEDURE GetBehandelingenOverzicht()
BEGIN
    SELECT 
        b.Id AS behandelingId,
        b.Naam AS Soort,
        b.Omschrijving,
        CONCAT(b.Duurminuten, ' min') AS Duur,
        CONCAT('EUR ', FORMAT(b.Prijs, 2)) AS Prijs,
        COUNT(bpv.VoorraadId) AS AantalProducten
    FROM 
        Behandeling b
    LEFT JOIN 
        BehandelingPerVoorraad bpv ON b.Id = bpv.BehandelingId AND bpv.IsActief = 1
    WHERE 
        b.IsActief = 1
    GROUP BY 
        b.Id, b.Naam, b.Omschrijving, b.Duurminuten, b.Prijs;
END //

DELIMITER ;
