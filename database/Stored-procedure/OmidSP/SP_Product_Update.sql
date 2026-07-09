DROP PROCEDURE IF EXISTS SP_Product_Update;

CREATE PROCEDURE SP_Product_Update(IN p_ProductId INT, IN p_Houdbaarheidsdatum DATE)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;

    START TRANSACTION;
    UPDATE Product
    SET Houdbaarheidsdatum = p_Houdbaarheidsdatum
    WHERE Id = p_ProductId;
    COMMIT;
END;
