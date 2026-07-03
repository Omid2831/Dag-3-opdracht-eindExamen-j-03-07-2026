DROP PROCEDURE IF EXISTS SP_Klant_ReadById;

DELIMITER //

-- Stored procedure to retrieve a single active customer's complete details by their Id.
CREATE PROCEDURE SP_Klant_ReadById(
    IN p_Id INT UNSIGNED
)
BEGIN
    SELECT 
        k.Id,
        k.UserId,
        k.Voornaam,
        k.Tussenvoegsel,
        k.Achternaam,
        k.Relatienummer,
        k.Bijzonderheden,
        c.Id AS ContactId,
        c.Straatnaam,
        c.Huisnummer,
        c.Toevoeging,
        c.Postcode,
        c.Plaats,
        c.Email AS ContactEmail,
        c.Mobiel,
        u.email AS AccountEmail
    FROM Klant k
    JOIN users u ON k.UserId = u.id
    LEFT JOIN KlantPerContact kpc ON k.Id = kpc.KlantId AND kpc.IsActief = 1
    LEFT JOIN Contact c ON kpc.ContactId = c.Id AND c.IsActief = 1
    WHERE k.Id = p_Id AND k.IsActief = 1;
END //

DELIMITER ;
