USE kapsalon_db;

DELIMITER //

CREATE PROCEDURE GetProductDetail(IN p_ProductId INT UNSIGNED)
BEGIN
    SELECT 
        p.Id AS ProductId,
        p.Naam AS Product,
        p.Merk,
        p.Omschrijving,
        p.EANcode,
        DATE_FORMAT(p.Houdbaarheidsdatum, '%d %m %Y') AS Houdbaarheidsdatum,
        CONCAT('EUR ', FORMAT(p.InkoopPrijs, 2)) AS InkoopPrijs,
        CONCAT('EUR ', FORMAT(p.VerkoopPrijs, 2)) AS VerkoopPrijs,
        v.AantalOpVoorraad,
        l.Naam AS Leverancier,
        l.Postcode AS PostcodeLeverancier,
        l.Plaats AS PlaatsLeverancier,
        l.Email AS EmailLeverancier,
        l.Mobiel AS MobielLeverancier,
        p.Opmerking
    FROM Product p
    -- INNER JOIN omdat een product zonder voorraadrecord niet compleet is
    JOIN Voorraad v ON p.Id = v.ProductId 
    -- LEFT JOIN omdat een product nog niet besteld hoeft te zijn
    LEFT JOIN LeverancierOrder lo ON p.Id = lo.ProductId
    LEFT JOIN Leverancier l ON lo.LeverancierId = l.Id
    WHERE p.Id = p_ProductId
    -- LIMIT 1 voorkomt dubbele rijen als een product meerdere keren besteld is
    LIMIT 1;
END //

DELIMITER ;