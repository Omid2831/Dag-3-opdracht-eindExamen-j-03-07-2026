DROP PROCEDURE IF EXISTS GetExistingAppointmentsForCollision;

DELIMITER //

CREATE PROCEDURE GetExistingAppointmentsForCollision(
    IN medewerkerId INT,
    IN datum DATE,
    IN excludeAfspraakId INT
)
BEGIN
    SELECT A.Id, A.Starttijd, B.Duurminuten
    FROM Afspraak A
    INNER JOIN MedewerkerPerBehandeling MPB ON A.MedewerkerPerBehandelingId = MPB.Id
    INNER JOIN Behandeling B ON MPB.BehandelingId = B.Id
    WHERE MPB.MedewerkerId = medewerkerId 
      AND A.Datum = datum 
      AND A.Id != excludeAfspraakId 
      AND A.IsActief = b'1';
END //

DELIMITER ;
