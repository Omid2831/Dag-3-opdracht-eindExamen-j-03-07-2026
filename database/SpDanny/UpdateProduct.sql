USE kapsalon_db;

DELIMITER //

DROP PROCEDURE IF EXISTS UpdateProductPrijs //

CREATE PROCEDURE UpdateProductPrijs(
    IN p_ProductId INT UNSIGNED,
    IN p_NieuwePrijs DECIMAL(10,2)
)
BEGIN
    DECLARE v_InkoopPrijs DECIMAL(10,2);

    -- Error handling to ensure database consistency
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;

    START TRANSACTION;

    -- Fetch the current cost price
    SELECT InkoopPrijs INTO v_InkoopPrijs FROM Product WHERE Id = p_ProductId;

    -- Business logic check: Margin must be at least 30%
    IF p_NieuwePrijs < (v_InkoopPrijs * 1.30) THEN
        SELECT 0 AS success, 'Verkoopprijs moet minimaal 30 procent boven de inkoopprijs liggen.' AS message;
        ROLLBACK;
    ELSE
        UPDATE Product SET VerkoopPrijs = p_NieuwePrijs WHERE Id = p_ProductId;
        SELECT 1 AS success, 'Prijs succesvol bijgewerkt.' AS message;
        COMMIT;
    END IF;
END //

DELIMITER ;