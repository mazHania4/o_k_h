
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

    INSERT INTO notifications (user_id, post_id, title, type_id, description)
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

    INSERT INTO notifications (user_id, post_id, title, type_id, description)
    SELECT user_id, NEW.post_id, 'Nuevo Reporte', 2, 'Se ha reportado una publicación'
    FROM users WHERE type = 'admin';
END$$
DELIMITER ;


DELIMITER $$
CREATE TRIGGER before_post_insert
BEFORE INSERT ON posts
FOR EACH ROW
BEGIN
    DECLARE publisher_state ENUM('active', 'on_test', 'banned');
    SELECT state INTO publisher_state
    FROM publishers
    WHERE user_id = NEW.publisher_id;

    IF publisher_state = 'banned' THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El publicador está bloqueado, no se puede insertar el post.';
    ELSEIF publisher_state = 'on_test' THEN
        SET NEW.state = 'pending';        
    ELSEIF publisher_state = 'active' THEN
        SET NEW.state = 'active';
    END IF;
END$$
DELIMITER ;


DELIMITER $$
CREATE TRIGGER after_post_insert
AFTER INSERT ON posts
FOR EACH ROW
BEGIN
    IF NEW.state = 'pending' THEN
        INSERT INTO notifications (user_id, post_id, title, type_id, description) 
        SELECT user_id, NEW.post_id, 'Revisar publicacion', 1, 'Un nuevo post requiere aprobación'
        FROM users WHERE type = 'admin';
    END IF;
END$$
DELIMITER ;



DELIMITER $$
CREATE TRIGGER after_post_update
AFTER UPDATE ON posts
FOR EACH ROW
BEGIN
    -- Un administrador lo aprobó
    IF NEW.state = 'active' AND OLD.state = 'pending' THEN
        UPDATE publishers SET approved_posts = approved_posts + 1 WHERE user_id = NEW.publisher_id;

        IF (SELECT approved_posts FROM publishers WHERE user_id = NEW.publisher_id) >= 2 THEN
            UPDATE publishers SET state = 'active' WHERE user_id = NEW.publisher_id;
        END IF;

    ELSEIF NEW.state = 'banned' AND OLD.state = 'pending' THEN
        UPDATE publishers SET approved_posts = 0 WHERE user_id = NEW.publisher_id;
    END IF;
END$$
DELIMITER ;
