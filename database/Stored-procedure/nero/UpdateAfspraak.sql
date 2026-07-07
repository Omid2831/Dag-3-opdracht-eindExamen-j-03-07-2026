DROP PROCEDURE IF EXISTS UpdateAfspraak;

DELIMITER //

CREATE PROCEDURE UpdateAfspraak(
    IN afspraakId INT,
    IN medewerkerId INT,
    IN behandelingId INT,
    IN nieuweDatum DATE,
    IN nieuweStarttijd TIME,
    IN nieuweStatus VARCHAR(50)
)
BEGIN
    DECLARE mpbId INT;
    
    -- Find the pivot ID
    SELECT Id INTO mpbId 
    FROM MedewerkerPerBehandeling 
    WHERE MedewerkerId = medewerkerId AND BehandelingId = behandelingId 
    LIMIT 1;
    
    -- If it does not exist, insert it
    IF mpbId IS NULL THEN
        SELECT COALESCE(MAX(Id), 0) + 1 INTO mpbId FROM MedewerkerPerBehandeling;
        INSERT INTO MedewerkerPerBehandeling (Id, MedewerkerId, BehandelingId, IsActief) 
        VALUES (mpbId, medewerkerId, behandelingId, b'1');
    END IF;
    
    -- Perform the update
    UPDATE Afspraak 
    SET MedewerkerPerBehandelingId = mpbId,
        Datum = nieuweDatum,
        Starttijd = nieuweStarttijd,
        Afspraakstatus = nieuweStatus,
        DatumGewijzigd = NOW()
    WHERE Id = afspraakId;
END //

DELIMITER ;
