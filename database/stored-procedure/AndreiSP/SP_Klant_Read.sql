DROP PROCEDURE IF EXISTS SP_Klant_Read;

DELIMITER //

-- Stored procedure to retrieve all active customers (with contact details).
-- If a postcode is specified, it filters results by matching postal codes.
CREATE PROCEDURE SP_Klant_Read(
    IN p_Postcode VARCHAR(10)
)
BEGIN
    SELECT 
        k.Id,
        k.Relatienummer,
        TRIM(CONCAT_WS(' ', k.Voornaam, k.Tussenvoegsel, k.Achternaam)) AS Naam,
        TRIM(CONCAT_WS(' ', c.Straatnaam, c.Huisnummer, c.Toevoeging)) AS Adres,
        c.Postcode,
        c.Plaats AS Woonplaats,
        c.Mobiel,
        c.Email AS ContactEmail,
        u.email AS AccountEmail
    FROM Klant k
    JOIN users u ON k.UserId = u.id
    LEFT JOIN KlantPerContact kpc ON k.Id = kpc.KlantId AND kpc.IsActief = 1
    LEFT JOIN Contact c ON kpc.ContactId = c.Id AND c.IsActief = 1
    WHERE k.IsActief = 1
      AND (p_Postcode IS NULL OR p_Postcode = '' OR REPLACE(c.Postcode, ' ', '') LIKE CONCAT('%', REPLACE(p_Postcode, ' ', ''), '%'));
END //

DELIMITER ;
