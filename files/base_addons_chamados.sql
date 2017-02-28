CREATE TABLE IF NOT EXISTS `ssx_ticket_type`
(
	id INT NOT NULL AUTO_INCREMENT,
	project_id INT NOT NULL,
	date_created DATETIME NOT NULL,
	created_by CHAR(36) NOT NULL,
	date_modified DATETIME NOT NULL,
	modified_by CHAR(36) NOT NULL,
	object_name VARCHAR(255) NOT NULL,
	PRIMARY KEY(id),
	FOREIGN KEY (project_id) REFERENCES ssx_project(id),
	FOREIGN KEY (created_by) REFERENCES ssx_user(id),
	FOREIGN KEY (modified_by) REFERENCES ssx_user(id)
)ENGINE=innoDB AUTO_INCREMENT=100;

CREATE TABLE IF NOT EXISTS `ssx_ticket`
(
	id INT NOT NULL AUTO_INCREMENT,
	project_id INT NOT NULL,
	date_created DATETIME NOT NULL,
	created_by CHAR(36) NOT NULL,
	date_modified DATETIME NOT NULL,
	modified_by CHAR(36) NOT NULL,
	deleted TINYINT(1) DEFAULT '0',
	ticket_type INT NOT NULL,
	title VARCHAR(200) NOT NULL,
	priority TINYINT(1) DEFAULT '1',
	status TINYINT(1) DEFAULT '0',
	PRIMARY KEY(id),
	FOREIGN KEY (project_id) REFERENCES ssx_project(id),
	FOREIGN KEY (created_by) REFERENCES ssx_user(id),
	FOREIGN KEY (modified_by) REFERENCES ssx_user(id),
	FOREIGN KEY (ticket_type) REFERENCES ssx_ticket_type(id)
)ENGINE=innoDB AUTO_INCREMENT=15035;

CREATE TABLE IF NOT EXISTS `ssx_ticket_replies`
(
	id INT NOT NULL AUTO_INCREMENT,
	ticket_id INT NOT NULL,
	created_by CHAR(36) NOT NULL,
	date_created DATETIME NOT NULL,
	modified_by CHAR(36) NOT NULL,
	date_modified DATETIME NOT NULL,
	deleted TINYINT(1) DEFAULT '0',
	content TEXT NOT NULL,
	PRIMARY KEY(id),
	FOREIGN KEY (created_by) REFERENCES ssx_user(id),
	FOREIGN KEY (modified_by) REFERENCES ssx_user(id),
	FOREIGN KEY (ticket_id) REFERENCES ssx_ticket(id)
)ENGINE=innoDB AUTO_INCREMENT=1000;

