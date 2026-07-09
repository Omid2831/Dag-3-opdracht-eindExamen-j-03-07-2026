USE kapsalon_db;


DELIMITER //

CREATE PROCEDURE GetProductenByBehandeling(IN p_BehandelingId INT UNSIGNED)
BEGIN
    SELECT 
        p.Id AS ProductId,
        p.Naam AS Product,
        p.Merk,
        p.Omschrijving,
        p.EANcode,
        v.AantalOpVoorraad,
        CONCAT('EUR ', FORMAT(p.VerkoopPrijs, 2)) AS VerkoopPrijs
    FROM 
        Product p
    JOIN 
        Voorraad v ON p.Id = v.ProductId
    JOIN 
        BehandelingPerVoorraad bpv ON v.Id = bpv.VoorraadId
    WHERE 
        bpv.BehandelingId = p_BehandelingId 
        AND bpv.IsActief = 1
        AND p.IsActief = 1;
END //

DELIMITER ;