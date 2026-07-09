USE kapsalon_db;


DELIMITER //

CREATE PROCEDURE UpdateProductVerkoopprijs(
    IN p_ProductId INT UNSIGNED,
    IN p_NieuwePrijs DECIMAL(10,2)
)
BEGIN
    DECLARE v_InkoopPrijs DECIMAL(10,2);
    
    -- Haal de huidige inkoopprijs op
    SELECT InkoopPrijs INTO v_InkoopPrijs FROM Product WHERE Id = p_ProductId;
    
    -- Controleer of de prijs minimaal 30% boven inkoopprijs ligt
    -- Formule: Inkoop * 1.30
    IF p_NieuwePrijs < (v_InkoopPrijs * 1.30) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Verkoopprijs moet minimaal 30 procent boven de inkoopprijs liggen.';
    ELSE
        -- Voer de update uit
        UPDATE Product 
        SET VerkoopPrijs = p_NieuwePrijs 
        WHERE Id = p_ProductId;
    END IF;
END //

DELIMITER ;