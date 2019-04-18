CREATE TABLE users (
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	username VARCHAR(50) NOT NULL UNIQUE,
	password VARCHAR(255) NOT NULL,
	fname VARCHAR(25) NULL,
	lname VARCHAR(25) NULL,
	display_name VARCHAR(50) NULL,
	type VARCHAR(25) NULL,
	description VARCHAR(1000) NULL,
	city VARCHAR(25) NULL,
	state VARCHAR(25) NULL,
	price INT NULL,
	profile_image VARCHAR(255) NULL
	email VARCHAR(50) NULL,
	youtube_link VARCHAR(50) NULL,
	instagram_link VARCHAR(50) NULL,
	soundcloud_link VARCHAR(50) NULL
);


CREATE TABLE events (
	event_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	id INT NOT NULL,
	event_name VARCHAR(50) NULL,
	venue_name VARCHAR(50) NULL,
	type VARCHAR(25) NULL,
	description VARCHAR(1000) NULL,
	city VARCHAR(25) NULL,
	state VARCHAR(25) NULL,
	street VARCHAR(25) NULL,
	price INT NULL,
	event_date DATETIME NULL,
	time VARCHAR(50) NULL,
	date_created DATETIME NULL,
	event_image VARCHAR(255) NULL,
	performer_id int(11) NULL,
	FOREIGN KEY id (id)
	REFERENCES users (id)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
);

CREATE TABLE links (
	link_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	id INT NOT NULL,
	link VARCHAR(1000) NULL,
	FOREIGN KEY id (id)
	REFERENCES users (id)
	ON UPDATE CASCADE
	ON DELETE RESTRICT
);

CREATE TABLE invite_apply (
	ia_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	sender_id INT(6) NOT NULL,
	reciever_id INT(6) NOT NULL,
	event_id INT(6) NOT NULL,
	message VARCHAR(500) NULL,
	status BOOLEAN NOT NULL DEFAULT 0,
	FOREIGN KEY (sender_id) REFERENCES users (id),
	FOREIGN KEY (reciever_id) REFERENCES users (id),
	FOREIGN KEY (event_id) REFERENCES events (event_id)
);

CREATE TABLE payment (
	payment_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	sender_id INT(6) NOT NULL,
	reciever_id INT(6) NOT NULL,
	amt INT(6) NULL,
	date_time TIMESTAMP(1) NOT NULL,
	in_app VARCHAR(3), NULL
	FOREIGN KEY (sender_id) REFERENCES users (id),
	FOREIGN KEY (reciever_id) REFERENCES users (id)
);




UPDATE users
SET fname = 'team', lname = 'fortyfive', display_name = 'The Four Five', type = 'cover band', description = 'We are the first band to use GigCity. Its an awesome site!', city = 'Bloomington', state = 'Indiana', price = 100
WHERE username = 'team45';

INSERT INTO events (event_id, id, event_name, venue_name, type, description, city, state, street, price, day, month, year, time)
VALUES (1, 8, 'open mic', 'march open mic', 'open mic', 'we need people for our open mic event', 'bloomington', 'indiana', '100 1st street', 50, '03', '03', '2019', '9pm-2am');

http://cgi.sice.indiana.edu/~team45/register.php
