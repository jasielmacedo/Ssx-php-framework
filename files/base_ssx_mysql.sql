CREATE TABLE IF NOT EXISTS `ssx_project`
(
	id INT NOT NULL AUTO_INCREMENT,
	status TINYINT(1) DEFAULT '1',
	PRIMARY KEY(id)
)ENGINE=innoDB;

CREATE TABLE IF NOT EXISTS `ssx_user`
(
	id CHAR(36) NOT NULL UNIQUE,
	project_id INT NOT NULL,
	created_by CHAR(36) NOT NULL,
	date_created DATETIME NOT NULL,
	modified_by CHAR(36) NOT NULL,
	date_modified DATETIME NOT NULL,
	deleted TINYINT(1) NOT NULL DEFAULT '0',
	name VARCHAR(255) NOT NULL,
	user VARCHAR(36) NOT NULL,
	email VARCHAR(200) NOT NULL,
	doc VARCHAR(20) NULL,
	status TINYINT(1) DEFAULT '1',
	PRIMARY KEY(id),
	FOREIGN KEY (project_id) REFERENCES ssx_project(id),
	FOREIGN KEY (created_by) REFERENCES ssx_user(id),
	FOREIGN KEY (modified_by) REFERENCES ssx_user(id)
)ENGINE=innoDB;

CREATE TABLE IF NOT EXISTS `ssx_user_pd`
(
	user_id CHAR(36) NOT NULL UNIQUE,
	modified_by CHAR(36) NOT NULL,
	date_modified DATETIME NOT NULL,
	type TINYINT(1) DEFAULT '1',
	password VARCHAR(60) NOT NULL,
	param_add VARCHAR(255) NULL,
	PRIMARY KEY(user_id),
	FOREIGN KEY (modified_by) REFERENCES ssx_user(id)
)ENGINE=innoDB;


CREATE TABLE IF NOT EXISTS `ssx_session_log`
(
	id INT NOT NULL AUTO_INCREMENT,
	project_id INT NOT NULL,
	date_created DATETIME NOT NULL,
	created_by CHAR(36) NOT NULL,
	session_id VARCHAR(60) NOT NULL,
	user_ip VARCHAR(45) NOT NULL,
	user_agent VARCHAR(180) NOT NULL,
	status VARCHAR(150) NOT NULL,
	PRIMARY KEY(id),
	FOREIGN KEY (created_by) REFERENCES ssx_user(id)
)ENGINE=innoDB;

CREATE TABLE IF NOT EXISTS `ssx_user_token`
(
	id CHAR(36) NOT NULL UNIQUE,
	created_by CHAR(36) NOT NULL,
	date_created DATETIME NOT NULL,
	modified_by CHAR(36) NOT NULL,
	date_modified DATETIME NOT NULL,
	user_id CHAR(36) NOT NULL,
	token CHAR(36) NOT NULL,
	used TINYINT(1) DEFAULT '0',
	PRIMARY KEY(id),
	FOREIGN KEY (user_id) REFERENCES ssx_user(id)
)ENGINE=innoDB;

CREATE TABLE IF NOT EXISTS `ssx_groups`
(
	id CHAR(36) NOT NULL UNIQUE,
	project_id INT NOT NULL,
	created_by CHAR(36) NOT NULL,
	date_created DATETIME NOT NULL,
	modified_by CHAR(36) NOT NULL,
	date_modified DATETIME NOT NULL,
	deleted TINYINT(1) NOT NULL DEFAULT '0',
	name VARCHAR(255) NOT NULL,
	description TEXT NULL,
	`level` INT NOT NULL DEFAULT '1',
	status TINYINT(1) DEFAULT '1',
	PRIMARY KEY(id),
	FOREIGN KEY (project_id) REFERENCES ssx_project(id),
	FOREIGN KEY (created_by) REFERENCES ssx_user(id),
	FOREIGN KEY (modified_by) REFERENCES ssx_user(id)
)ENGINE=innoDB;


CREATE TABLE IF NOT EXISTS `ssx_user_groups`
(
	user_id CHAR(36) NOT NULL,
	group_id CHAR(36) NOT NULL,
	created_by CHAR(36) NOT NULL,
	date_created DATETIME NOT NULL,
	modified_by CHAR(36) NOT NULL,
	date_modified DATETIME NOT NULL,
	PRIMARY KEY(user_id,group_id),
	FOREIGN KEY (created_by) REFERENCES ssx_user(id),
	FOREIGN KEY (modified_by) REFERENCES ssx_user(id),
	FOREIGN KEY (user_id) REFERENCES ssx_user(id),
	FOREIGN KEY (group_id) REFERENCES ssx_groups(id)
)ENGINE=innoDB;

CREATE TABLE IF NOT EXISTS `ssx_acl_group`
(
	id CHAR(36) NOT NULL UNIQUE,
	created_by CHAR(36) NOT NULL,
	date_created DATETIME NOT NULL,
	modified_by CHAR(36) NOT NULL,
	date_modified DATETIME NOT NULL,
	group_id CHAR(36) NOT NULL,
	permissions LONGTEXT NOT NULL,
	PRIMARY KEY(id),
	FOREIGN KEY (created_by) REFERENCES ssx_user(id),
	FOREIGN KEY (modified_by) REFERENCES ssx_user(id),
	FOREIGN KEY (group_id) REFERENCES ssx_groups(id)
)ENGINE=innoDB;

CREATE TABLE IF NOT EXISTS `ssx_plugins`
(
	id CHAR(36) NOT NULL UNIQUE,
	project_id INT NOT NULL,
	date_created DATETIME NOT NULL,
	created_by CHAR(36) NOT NULL,
	date_modified DATETIME NOT NULL,
	modified_by CHAR(36) NOT NULL,
	reference_name VARCHAR(255) NOT NULL,
	real_name VARCHAR(255) NOT NULL,
	description TEXT NULL,
	file_reference VARCHAR(255) NOT NULL,
	`active` TINYINT(1) DEFAULT '0',
	PRIMARY KEY(id),
	FOREIGN KEY (project_id) REFERENCES ssx_project(id),
	FOREIGN KEY (created_by) REFERENCES ssx_user(id),
	FOREIGN KEY (modified_by) REFERENCES ssx_user(id)
)ENGINE=innoDB;


CREATE TABLE IF NOT EXISTS `ssx_config`
(
	id CHAR(36) NOT NULL UNIQUE,
	project_id INT NOT NULL,
	date_created DATETIME NOT NULL,
	created_by CHAR(36) NOT NULL,
	date_modified DATETIME NOT NULL,
	modified_by CHAR(36) NOT NULL,
	object_name VARCHAR(255) NOT NULL,
	object_value LONGTEXT NOT NULL,
	PRIMARY KEY(id),
	FOREIGN KEY (project_id) REFERENCES ssx_project(id),
	FOREIGN KEY (created_by) REFERENCES ssx_user(id),
	FOREIGN KEY (modified_by) REFERENCES ssx_user(id)
)ENGINE=innoDB;

CREATE TABLE IF NOT EXISTS `ssx_pages`
(
	id CHAR(36) NOT NULL UNIQUE,
	project_id INT NOT NULL,
	date_created DATETIME NOT NULL,
	created_by CHAR(36) NOT NULL,
	date_modified DATETIME NOT NULL,
	modified_by CHAR(36) NOT NULL,
	title VARCHAR(255) NOT NULL,
	slug VARCHAR(255) NOT NULL,
	content LONGTEXT NOT NULL,
	seo_title VARCHAR(255) NULL,
	seo_keywords VARCHAR(255) NULL,
	seo_description TEXT NULL,
	featured_image VARCHAR(255) NULL,
	status TINYINT(1) NULL DEFAULT '1',
	PRIMARY KEY(id),
	FOREIGN KEY (project_id) REFERENCES ssx_project(id),
	FOREIGN KEY (created_by) REFERENCES ssx_user(id),
	FOREIGN KEY (modified_by) REFERENCES ssx_user(id)
)ENGINE=innoDB;

CREATE TABLE IF NOT EXISTS `ssx_tags`
(
	id CHAR(36) NOT NULL UNIQUE,
	project_id INT NOT NULL,
	date_created DATETIME NOT NULL,
	created_by CHAR(36) NOT NULL,
	date_modified DATETIME NOT NULL,
	modified_by CHAR(36) NOT NULL,
	name VARCHAR(150) NOT NULL,
	PRIMARY KEY(id),
	FOREIGN KEY (project_id) REFERENCES ssx_project(id),
	FOREIGN KEY (created_by) REFERENCES ssx_user(id),
	FOREIGN KEY (modified_by) REFERENCES ssx_user(id)
)ENGINE=innoDB;


CREATE TABLE IF NOT EXISTS `ssx_tags_object`
(
	tag_id CHAR(36) NOT NULL,
	object_id CHAR(36) NOT NULL,
	object_table VARCHAR(60) NOT NULL,
	PRIMARY KEY(tag_id,object_id)
)ENGINE=innoDB;

