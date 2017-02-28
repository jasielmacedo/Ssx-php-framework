CREATE TABLE IF NOT EXISTS `dmo_user_info`
(
	`user_id` CHAR(36) NOT NULL UNIQUE,
	`date_modified` DATETIME NOT NULL,
	`news_game_accept` TINYINT(1) DEFAULT 1,
	`news_moview_accept` TINYINT(1) DEFAULT 0,
	`news_series_accept` TINYINT(1) DEFAULT 0,
	PRIMARY KEY(user_id),
	FOREIGN KEY (user_id) REFERENCES ssx_user(id)
)ENGINE=innoDB;

CREATE TABLE IF NOT EXISTS `dmo_localized_title`
(
	`id` INT NOT NULL AUTO_INCREMENT,
	`locale` CHAR(4) NOT NULL,
	`object_table` VARCHAR(100) NOT NULL,
	`object_id` CHAR(36) NOT NULL,
	`content` VARCHAR(130) NOT NULL,
	PRIMARY KEY(id),
	INDEX(object_table,object_id)
)ENGINE=innoDB;

CREATE TABLE IF NOT EXISTS `dmo_localized_content`
(
	`id` INT NOT NULL AUTO_INCREMENT,
	`locale` CHAR(4) NOT NULL,
	`object_table` VARCHAR(100) NOT NULL,
	`object_id` CHAR(36) NOT NULL,
	content TEXT NULL,
	PRIMARY KEY(id)
)ENGINE=innoDB;

CREATE TABLE IF NOT EXISTS `dmo_image_file`
(
	`id` INT NOT NULL AUTO_INCREMENT,
	`url` VARCHAR(255) NOT NULL,
	`type` TINYINT(2) DEFAULT 0,
	PRIMARY KEY(id)
)ENGINE=innoDB;


CREATE TABLE IF NOT EXISTS `dmo_category`
(
	`id` CHAR(36) NOT NULL UNIQUE,
	`date_created` DATETIME NOT NULL,
	`created_by` CHAR(36) NOT NULL,
	`date_modified` DATETIME NOT NULL,
	`modified_by` CHAR(36) NOT NULL,
	`deleted` TINYINT(1) NULL DEFAULT '0',
	`slug` VARCHAR(130) NOT NULL,
	`status` TINYINT(1) DEFAULT 1,
	PRIMARY KEY(id),
	FOREIGN KEY (created_by) REFERENCES ssx_user(id),
	FOREIGN KEY (modified_by) REFERENCES ssx_user(id)
)ENGINE=innoDB;

CREATE TABLE IF NOT EXISTS `dmo_platform`
(
	`id` CHAR(36) NOT NULL UNIQUE,
	`date_created` DATETIME NOT NULL,
	`created_by` CHAR(36) NOT NULL,
	`date_modified` DATETIME NOT NULL,
	`modified_by` CHAR(36) NOT NULL,
	`deleted` TINYINT(1) NULL DEFAULT '0',
	`slug` VARCHAR(130) NOT NULL,
	`status` TINYINT(1) DEFAULT 1,
	`image_id` INT NOT NULL,
	PRIMARY KEY(id),
	FOREIGN KEY (created_by) REFERENCES ssx_user(id),
	FOREIGN KEY (modified_by) REFERENCES ssx_user(id),
	FOREIGN KEY (image_id) REFERENCES dmo_image_file(id)
)ENGINE=innoDB;


CREATE TABLE IF NOT EXISTS `dmo_genre`
(
	`id` CHAR(36) NOT NULL UNIQUE,
	`date_created` DATETIME NOT NULL,
	`created_by` CHAR(36) NOT NULL,
	`date_modified` DATETIME NOT NULL,
	`modified_by` CHAR(36) NOT NULL,
	`deleted` TINYINT(1) NULL DEFAULT '0',
	`slug` VARCHAR(130) NOT NULL,
	`status` TINYINT(1) DEFAULT 1,
	PRIMARY KEY(id),
	FOREIGN KEY (created_by) REFERENCES ssx_user(id),
	FOREIGN KEY (modified_by) REFERENCES ssx_user(id)
)ENGINE=innoDB;


CREATE TABLE IF NOT EXISTS `dmo_publisher`
(
	`id` CHAR(36) NOT NULL UNIQUE,
	`date_created` DATETIME NOT NULL,
	`created_by` CHAR(36) NOT NULL,
	`date_modified` DATETIME NOT NULL,
	`modified_by` CHAR(36) NOT NULL,
	`deleted` TINYINT(1) NULL DEFAULT '0',
	`name` VARCHAR(255) NOT NULL,
	`slug` VARCHAR(130) NOT NULL,
	`reference_url` VARCHAR(255) NOT NULL,
	`status` TINYINT(1) DEFAULT 1,
	PRIMARY KEY(id),
	FOREIGN KEY (created_by) REFERENCES ssx_user(id),
	FOREIGN KEY (modified_by) REFERENCES ssx_user(id)
)ENGINE=innoDB;


CREATE TABLE IF NOT EXISTS `dmo_element`
(
	`id` CHAR(36) NOT NULL UNIQUE,
	`date_created` DATETIME NOT NULL,
	`created_by` CHAR(36) NOT NULL,
	`date_modified` DATETIME NOT NULL,
	`modified_by` CHAR(36) NOT NULL,
	`deleted` TINYINT(1) NULL DEFAULT '0',
	`category_id` CHAR(36) NOT NULL,
	`publisher_id` CHAR(36) NOT NULL,
	`date_release` DATETIME NOT NULL,
	`slug` VARCHAR(130) NOT NULL,
	`source` VARCHAR(255) NOT NULL,
	`relevance` TINYINT(1) DEFAULT 0,
	`video_url` VARCHAR(255) NULL,
	`status` TINYINT(1) DEFAULT 1,
	PRIMARY KEY(id),
	INDEX(date_release,relevance),
	FOREIGN KEY (created_by) REFERENCES ssx_user(id),
	FOREIGN KEY (modified_by) REFERENCES ssx_user(id),
	FOREIGN KEY (category_id) REFERENCES dmo_category(id),
	FOREIGN KEY (publisher_id) REFERENCES dmo_publisher(id)
)ENGINE=innoDB;

CREATE TABLE IF NOT EXISTS `dmo_element_platforms`
(
	`element_id` CHAR(36) NOT NULL,
	`platform_id` CHAR(36) NOT NULL,
	`buy_url` VARCHAR(250) NULL,
	PRIMARY KEY(element_id,platform_id),
	FOREIGN KEY (element_id) REFERENCES dmo_element(id),
	FOREIGN KEY (platform_id) REFERENCES dmo_platform(id)	
)ENGINE=innoDB;

CREATE TABLE IF NOT EXISTS `dmo_element_genre`
(
	`element_id` CHAR(36) NOT NULL,
	`genre_id` CHAR(36) NOT NULL,
	PRIMARY KEY(element_id,platform_id),
	FOREIGN KEY (element_id) REFERENCES dmo_element(id),
	FOREIGN KEY (genre_id) REFERENCES dmo_genre(id)
)ENGINE=innoDB;

CREATE TABLE IF NOT EXISTS `dmo_user_follow`
(
	`user_id` CHAR(36) NOT NULL,
	`element_id` CHAR(36) NOT NULL,
	PRIMARY KEY(user_id,element_id),
	FOREIGN KEY (user_id) REFERENCES ssx_user(id),
	FOREIGN KEY (element_id) REFERENCES dmo_element(id)
)ENGINE=innoDB;
