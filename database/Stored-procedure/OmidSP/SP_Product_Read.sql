
DROP PROCEDURE IF EXISTS SP_Product_Read;

CREATE PROCEDURE SP_Product_Read(
    IN p_ProductId INT,
    IN p_CategorieId INT
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;

    START TRANSACTION;
    IF p_ProductId IS NOT NULL THEN
        SELECT 
            p.Id,
            p.CategorieId,
            c.Naam AS CategorieNaam,
            p.Naam,
            p.Omschrijving,
            p.Merk,
            p.EANcode,
            p.Houdbaarheidsdatum,
            p.InkoopPrijs,
            p.VerkoopPrijs,
            p.Opmerking,
            IFNULL(v.AantalOpVoorraad, 0) AS AantalOpVoorraad,
            l.Naam AS LeverancierNaam,
            l.Postcode AS LeverancierPostcode,
            l.Plaats AS LeverancierPlaats,
            l.Email AS LeverancierEmail,
            l.Mobiel AS LeverancierMobiel
        FROM Product p
        INNER JOIN Categorie c ON p.CategorieId = c.Id
        LEFT JOIN Voorraad v ON p.Id = v.ProductId
        LEFT JOIN (
            SELECT ProductId, MIN(LeverancierId) AS LeverancierId
            FROM LeverancierOrder
            GROUP BY ProductId
        ) lo ON p.Id = lo.ProductId
        LEFT JOIN Leverancier l ON lo.LeverancierId = l.Id
        WHERE p.Id = p_ProductId;
    ELSE
        SELECT 
            p.Id,
            p.Naam,
            c.Naam AS Categorie,
            p.Merk,
            p.EANcode,
            p.VerkoopPrijs,
            IFNULL(v.AantalOpVoorraad, 0) AS Voorraad
        FROM Product p
        INNER JOIN Categorie c ON p.CategorieId = c.Id
        LEFT JOIN Voorraad v ON p.Id = v.ProductId
        WHERE (p_CategorieId IS NULL OR p.CategorieId = p_CategorieId)
        ORDER BY p.Naam ASC;
    END IF;
    COMMIT;
END;
