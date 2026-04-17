-- -------------------------------------------------------
-- ShopFrame Database Schema
-- -------------------------------------------------------

CREATE DATABASE IF NOT EXISTS shop_db
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE shop_db;

-- -------------------------------------------------------
-- Tables
-- -------------------------------------------------------

CREATE TABLE IF NOT EXISTS category (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100) NOT NULL,
    description TEXT         NULL
);

CREATE TABLE IF NOT EXISTS product (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100) NOT NULL,
    description TEXT         NULL,
    size        INT UNSIGNED NULL,
    category_id INT          NULL,
    CONSTRAINT fk_product_category
        FOREIGN KEY (category_id) REFERENCES category(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS users (
    id       INT AUTO_INCREMENT PRIMARY KEY,
    email    VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- -------------------------------------------------------
-- Sample data
-- -------------------------------------------------------

INSERT INTO category (name, description) VALUES
    ('Electronics',  'Gadgets and electronic devices'),
    ('Tools',        'Hand tools and power tools'),
    ('Accessories',  'Add-ons and extras');

INSERT INTO product (name, description, size, category_id) VALUES
    ('Gizmo',        'A thing for a purpose',    32, 1),
    ('Thingamajig',  'Something useful',          38, 2),
    ('Widget',       'Thing that does something', 14, 3);

-- Sample user — password is: secret123
-- Replace this hash with one generated via: password_hash('yourpassword', PASSWORD_BCRYPT)
INSERT INTO users (email, password) VALUES
    ('admin@shop.com', '$2y$12$replacethiswitharealhashedpassword000000000000000000000');

-- -------------------------------------------------------
-- Stored Procedures — Products
-- -------------------------------------------------------

DROP PROCEDURE IF EXISTS sp_get_all_products;
DELIMITER $$
CREATE PROCEDURE sp_get_all_products()
BEGIN
    SELECT p.id, p.name, p.description, p.size, p.category_id,
           c.name AS category_name
    FROM product p
    LEFT JOIN category c ON p.category_id = c.id;
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_get_product_by_id;
DELIMITER $$
CREATE PROCEDURE sp_get_product_by_id(IN p_id INT)
BEGIN
    SELECT p.id, p.name, p.description, p.size, p.category_id,
           c.name AS category_name
    FROM product p
    LEFT JOIN category c ON p.category_id = c.id
    WHERE p.id = p_id LIMIT 1;
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_create_product;
DELIMITER $$
CREATE PROCEDURE sp_create_product(
    IN p_name        VARCHAR(100),
    IN p_description TEXT,
    IN p_size        INT,
    IN p_category_id INT
)
BEGIN
    INSERT INTO product (name, description, size, category_id)
    VALUES (p_name, p_description, p_size, p_category_id);
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_update_product;
DELIMITER $$
CREATE PROCEDURE sp_update_product(
    IN p_id          INT,
    IN p_name        VARCHAR(100),
    IN p_description TEXT,
    IN p_size        INT,
    IN p_category_id INT
)
BEGIN
    UPDATE product
    SET name = p_name, description = p_description,
        size = p_size, category_id = p_category_id
    WHERE id = p_id;
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_delete_product;
DELIMITER $$
CREATE PROCEDURE sp_delete_product(IN p_id INT)
BEGIN
    DELETE FROM product WHERE id = p_id;
END$$
DELIMITER ;

-- -------------------------------------------------------
-- Stored Procedures — Categories
-- -------------------------------------------------------

DROP PROCEDURE IF EXISTS sp_get_all_categories;
DELIMITER $$
CREATE PROCEDURE sp_get_all_categories()
BEGIN
    SELECT id, name, description FROM category;
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_get_category_by_id;
DELIMITER $$
CREATE PROCEDURE sp_get_category_by_id(IN p_id INT)
BEGIN
    SELECT id, name, description FROM category WHERE id = p_id LIMIT 1;
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_create_category;
DELIMITER $$
CREATE PROCEDURE sp_create_category(
    IN p_name        VARCHAR(100),
    IN p_description TEXT
)
BEGIN
    INSERT INTO category (name, description) VALUES (p_name, p_description);
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_update_category;
DELIMITER $$
CREATE PROCEDURE sp_update_category(
    IN p_id          INT,
    IN p_name        VARCHAR(100),
    IN p_description TEXT
)
BEGIN
    UPDATE category SET name = p_name, description = p_description WHERE id = p_id;
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_delete_category;
DELIMITER $$
CREATE PROCEDURE sp_delete_category(IN p_id INT)
BEGIN
    DELETE FROM category WHERE id = p_id;
END$$
DELIMITER ;

-- -------------------------------------------------------
-- Stored Procedures — Users
-- -------------------------------------------------------

DROP PROCEDURE IF EXISTS sp_get_user_by_email;
DELIMITER $$
CREATE PROCEDURE sp_get_user_by_email(IN p_email VARCHAR(150))
BEGIN
    SELECT id, email, password FROM users WHERE email = p_email LIMIT 1;
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_get_user_by_id;
DELIMITER $$
CREATE PROCEDURE sp_get_user_by_id(IN p_id INT)
BEGIN
    SELECT id, email, password FROM users WHERE id = p_id LIMIT 1;
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_create_user;
DELIMITER $$
CREATE PROCEDURE sp_create_user(
    IN p_email    VARCHAR(150),
    IN p_password VARCHAR(255)
)
BEGIN
    INSERT INTO users (email, password) VALUES (p_email, p_password);
END$$
DELIMITER ;
