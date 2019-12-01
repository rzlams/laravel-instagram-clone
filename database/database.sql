CREATE DATABASE IF NOT EXISTS instagram_clone;
USE instagram_clone;

CREATE TABLE IF NOT EXISTS users(
	id int(255) AUTO_INCREMENT NOT NULL,
	role varchar(20),
	name varchar(100),
	surname varchar(200),
	nick varchar(100),
	email varchar(255),
	password varchar(255),
	image varchar(255),
	created_at datetime,
	updated_at datetime,
	remember_token varchar(255),
	CONSTRAINT users_pk PRIMARY KEY (id)
)ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS images(
	id int(255) AUTO_INCREMENT NOT NULL,
	user_id int(255),
	image_path varchar(255),
	description text,
	created_at datetime,
	updated_at datetime,
	CONSTRAINT images_pk PRIMARY KEY (id),
	CONSTRAINT images_users_fk FOREIGN KEY (user_id)
	REFERENCES users(id)
	MATCH FULL
	ON UPDATE CASCADE ON DELETE CASCADE 
)ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS comments(
	id int(255) AUTO_INCREMENT NOT NULL,
	user_id int(255),
	image_id int(255),
	content text,
	created_at datetime,
	updated_at datetime,
	CONSTRAINT comments_pk PRIMARY KEY (id),
	CONSTRAINT comments_users_fk FOREIGN KEY (user_id)
	REFERENCES users(id)
	MATCH FULL
	ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT comments_images_fk FOREIGN KEY (image_id)
	REFERENCES images(id)
	MATCH FULL
	ON UPDATE CASCADE ON DELETE CASCADE 
)ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS likes(
	id int(255) AUTO_INCREMENT NOT NULL,
	user_id int(255),
	image_id int(255),
	created_at datetime,
	updated_at datetime,
	CONSTRAINT likes_pk PRIMARY KEY (id),
	CONSTRAINT likes_users_fk FOREIGN KEY (user_id)
	REFERENCES users(id)
	MATCH FULL
	ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT likes_images_fk FOREIGN KEY (image_id)
	REFERENCES images(id)
	MATCH FULL
	ON UPDATE CASCADE ON DELETE CASCADE 
)ENGINE=InnoDB;

INSERT INTO users VALUES(null, 'user', 'Victor', 'Robles', 'victorroblesweb', 'pass', 'victor@victor.com', null, CURTIME(), CURTIME(), null);
INSERT INTO users VALUES(null, 'user', 'Luis', 'Moreno', 'LamManhunt', 'pass', 'lams@lams.com', null, CURTIME(), CURTIME(), null);
INSERT INTO users VALUES(null, 'user', 'Juan', 'Lopez', 'juanlopezweb', 'pass', 'juan@lopez.com', null, CURTIME(), CURTIME(), null);

INSERT INTO images VALUES(null, 1, 'test.jpg', 'descripcion de prueba 1', CURTIME(), CURTIME());
INSERT INTO images VALUES(null, 1, 'playa.jpg', 'descripcion de prueba 2', CURTIME(), CURTIME());
INSERT INTO images VALUES(null, 1, 'arena.jpg', 'descripcion de prueba 3', CURTIME(), CURTIME());
INSERT INTO images VALUES(null, 3, 'familia.jpg', 'descripcion de prueba 4', CURTIME(), CURTIME());

INSERT INTO comments VALUES(null, 1, 4, 'Buena foto de familia', CURTIME(), CURTIME());
INSERT INTO comments VALUES(null, 2, 1, 'Buena foto de playa', CURTIME(), CURTIME());
INSERT INTO comments VALUES(null, 2, 4, 'Que bueno!!', CURTIME(), CURTIME());

INSERT INTO likes VALUES(null, 1, 1, CURTIME(), CURTIME());
INSERT INTO likes VALUES(null, 1, 2, CURTIME(), CURTIME());
INSERT INTO likes VALUES(null, 1, 2, CURTIME(), CURTIME());
