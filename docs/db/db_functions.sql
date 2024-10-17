
CREATE OR REPLACE VIEW getPosts AS 
    SELECT p.*, u.name publisher_name FROM posts p 
    JOIN users u on p.publisher_id = u.user_id
    WHERE p.state = 'active'
    ORDER BY p.post_id DESC LIMIT 15;


DELIMITER $$
CREATE TRIGGER trigger_increment_attendances
AFTER INSERT ON attendances
FOR EACH ROW
BEGIN
    UPDATE posts
    SET attendances = attendances + 1
    WHERE post_id = NEW.post_id;

    INSERT INTO notifications (user_id, post_id, title, type, description)
    VALUES (NEW.user_id, NEW.post_id, 'Asistencia registrada', 4, 'Se ha registrado su asistencia a un evento');
END$$
DELIMITER ;


DELIMITER $$
CREATE TRIGGER trigger_decrement_attendances
AFTER DELETE ON attendances
FOR EACH ROW
BEGIN
    UPDATE posts
    SET attendances = attendances - 1
    WHERE post_id = OLD.post_id;
END$$
DELIMITER ;


DELIMITER $$
CREATE  OR REPLACE TRIGGER after_publisher_insert
AFTER INSERT ON publishers
FOR EACH ROW
BEGIN
    UPDATE users SET type = 'publisher' WHERE user_id = NEW.user_id;
END$$
DELIMITER ;


DELIMITER $$
CREATE TRIGGER after_report_insert
AFTER INSERT ON reports
FOR EACH ROW
BEGIN
    UPDATE posts
    SET reports = reports + 1
    WHERE post_id = NEW.post_id;

    IF (SELECT reports FROM posts WHERE post_id = NEW.post_id) >= 3 THEN
        UPDATE posts
        SET state = 'banned'
        WHERE post_id = NEW.post_id;
    END IF;

    INSERT INTO notifications (user_id, post_id, title, type, description)
    SELECT user_id, NEW.post_id, 'Nuevo Reporte', 2, 'Se ha reportado una publicación'
    FROM users WHERE type = 'admin';
END$$
DELIMITER ;
