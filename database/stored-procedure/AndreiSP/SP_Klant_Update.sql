DROP PROCEDURE IF EXISTS SP_Klant_Update;

DELIMITER //

-- Stored procedure to update customer details and linked contact details in a transaction.
CREATE PROCEDURE SP_Klant_Update(
    IN p_Id INT UNSIGNED,
    IN p_Voornaam VARCHAR(50),
    IN p_Tussenvoegsel VARCHAR(20),
    IN p_Achternaam VARCHAR(50),
    IN p_Bijzonderheden VARCHAR(255),
    IN p_Straatnaam VARCHAR(100),
    IN p_Huisnummer INT,
    IN p_Toevoeging VARCHAR(10),
    IN p_Postcode VARCHAR(10),
    IN p_Plaats VARCHAR(50),
    IN p_Email VARCHAR(100),
    IN p_Mobiel VARCHAR(20)
)
BEGIN
    DECLARE v_ContactId INT UNSIGNED;

    -- Handles sql exceptions: rollback and pass the error along
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;

    START TRANSACTION;

    -- 1. Update client basic details
    UPDATE Klant
    SET Voornaam = p_Voornaam,
        Tussenvoegsel = p_Tussenvoegsel,
        Achternaam = p_Achternaam,
        Bijzonderheden = p_Bijzonderheden,
        DatumGewijzigd = NOW(6)
    WHERE Id = p_Id;

    -- 2. Retrieve linked ContactId
    SELECT ContactId INTO v_ContactId
    FROM KlantPerContact
    WHERE KlantId = p_Id AND IsActief = 1
    LIMIT 1;

    -- 3. Update contact details if a valid ID was found
    IF v_ContactId IS NOT NULL THEN
        UPDATE Contact
        SET Straatnaam = p_Straatnaam,
            Huisnummer = p_Huisnummer,
            Toevoeging = p_Toevoeging,
            Postcode = p_Postcode,
            Plaats = p_Plaats,
            Email = p_Email,
            Mobiel = p_Mobiel,
            DatumGewijzigd = NOW(6)
        WHERE Id = v_ContactId;
    END IF;

    COMMIT;
END //

DELIMITER ;
