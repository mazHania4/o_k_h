
CREATE OR REPLACE VIEW getPosts AS 
    SELECT p.*, u.name publisher_name FROM posts p 
    JOIN users u on p.publisher_id = u.user_id
    ORDER BY p.post_id DESC LIMIT 15;


DELIMITER $$
CREATE TRIGGER trigger_increment_attendances
AFTER INSERT ON attendances
FOR EACH ROW
BEGIN
    UPDATE posts
    SET attendances = attendances + 1
    WHERE post_id = NEW.post_id;
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

