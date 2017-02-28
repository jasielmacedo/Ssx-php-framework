CREATE TABLE IF NOT EXISTS ssx_user
(
	id CHAR(36) NOT NULL UNIQUE,
	created_by CHAR(36) NOT NULL,
	date_created TIMESTAMP NOT NULL,
	modified_by CHAR(36) NOT NULL,
	date_modified TIMESTAMP NOT NULL,
	deleted SMALLINT NULL CHECK (deleted IN (0,1)) DEFAULT 0,
	name VARCHAR(150) NOT NULL,
	"user" VARCHAR(30) NOT NULL,
	email VARCHAR(200) NOT NULL,
	password CHAR(36) NOT NULL,
	status SMALLINT NULL CHECK (status IN (0,1)) DEFAULT 0,
	PRIMARY KEY(id),
	FOREIGN KEY (created_by) REFERENCES ssx_user(id) ON DELETE RESTRICT,
	FOREIGN KEY (modified_by) REFERENCES ssx_user(id) ON DELETE RESTRICT
);

INSERT INTO ssx_user VALUES('1', '1', NOW( ) , '1', NOW( ) , '0', 'Admin', 'administrator', 'admin@admin.com.br', MD5( '123' ) , '1');
INSERT INTO ssx_user VALUES('2', '1', NOW( ) , '1', NOW( ) , '0', 'Guest', 'guest', 'guest@admin.com.br', MD5( '123' ) , '1');

CREATE TABLE IF NOT EXISTS ssx_user_token
(
	id CHAR(36) NOT NULL UNIQUE,
	created_by CHAR(36) NOT NULL,
	date_created TIMESTAMP NOT NULL,
	modified_by CHAR(36) NOT NULL,
	date_modified TIMESTAMP NOT NULL,
	user_id CHAR(36) NOT NULL,
	token CHAR(36) NOT NULL,
	used SMALLINT NULL CHECK (used IN (0,1)) DEFAULT 0,
	PRIMARY KEY(id),
	FOREIGN KEY (user_id) REFERENCES ssx_user(id) ON DELETE RESTRICT
);

CREATE TABLE IF NOT EXISTS ssx_groups
(
	id CHAR(36) NOT NULL UNIQUE,
	created_by CHAR(36) NOT NULL,
	date_created TIMESTAMP NOT NULL,
	modified_by CHAR(36) NOT NULL,
	date_modified TIMESTAMP NOT NULL,
	deleted SMALLINT NULL CHECK (deleted IN (0,1)) default 0,
	name VARCHAR(100) NOT NULL,
	description TEXT NULL,
	"level" SMALLINT NULL default 1,
	status SMALLINT NULL CHECK (status IN (0,1)) default 1,
	PRIMARY KEY(id),
	FOREIGN KEY (created_by) REFERENCES ssx_user(id)  ON DELETE RESTRICT,
	FOREIGN KEY (modified_by) REFERENCES ssx_user(id)  ON DELETE RESTRICT
);

INSERT INTO ssx_groups VALUES('1', '1', NOW( ), '1', NOW( ), '0', 'admin', 'adminitracao de usuario',0, 1);
INSERT INTO ssx_groups VALUES('2', '1', NOW( ), '1', NOW( ), '0', 'guest', 'visitantes do sistema',2, 1);


CREATE TABLE IF NOT EXISTS ssx_user_groups
(
	user_id CHAR(36) NOT NULL,
	group_id CHAR(36) NOT NULL,
	created_by CHAR(36) NOT NULL,
	date_created TIMESTAMP NOT NULL,
	modified_by CHAR(36) NOT NULL,
	date_modified TIMESTAMP NOT NULL,
	PRIMARY KEY(user_id,group_id),
	FOREIGN KEY (created_by) REFERENCES ssx_user(id)  ON DELETE RESTRICT,
	FOREIGN KEY (modified_by) REFERENCES ssx_user(id) ON DELETE RESTRICT,
	FOREIGN KEY (user_id) REFERENCES ssx_user(id) ON DELETE RESTRICT,
	FOREIGN KEY (group_id) REFERENCES ssx_groups(id) ON DELETE RESTRICT
);

INSERT INTO ssx_user_groups VALUES('1','1', '1', NOW( ), '1', NOW( ));
INSERT INTO ssx_user_groups VALUES('2','2', '1', NOW( ), '1', NOW( ));

CREATE TABLE IF NOT EXISTS ssx_acl_group
(
	id CHAR(36) NOT NULL UNIQUE,
	created_by CHAR(36) NOT NULL,
	date_created TIMESTAMP NOT NULL,
	modified_by CHAR(36) NOT NULL,
	date_modified TIMESTAMP NOT NULL,
	group_id CHAR(36) NOT NULL,
	permissions TEXT NOT NULL,
	PRIMARY KEY(id),
	FOREIGN KEY (created_by) REFERENCES ssx_user(id) ON DELETE RESTRICT,
	FOREIGN KEY (modified_by) REFERENCES ssx_user(id) ON DELETE RESTRICT,
	FOREIGN KEY (group_id) REFERENCES ssx_groups(id) ON DELETE RESTRICT
);

INSERT INTO ssx_acl_group VALUES('1', '1', NOW( ), '1', NOW( ), '1', 'all_access');


CREATE TABLE IF NOT EXISTS ssx_plugins
(
	id CHAR(36) NOT NULL UNIQUE,
	date_created TIMESTAMP NOT NULL,
	created_by CHAR(36) NOT NULL,
	date_modified TIMESTAMP NOT NULL,
	modified_by CHAR(36) NOT NULL,
	reference_name VARCHAR(255) NOT NULL,
	real_name VARCHAR(255) NOT NULL,
	description TEXT NULL,
	file_reference VARCHAR(255) NOT NULL,
	active SMALLINT NULL CHECK (active IN (0,1)) DEFAULT 0,
	PRIMARY KEY(id),
	FOREIGN KEY (created_by) REFERENCES ssx_user(id) ON DELETE RESTRICT,
	FOREIGN KEY (modified_by) REFERENCES ssx_user(id) ON DELETE RESTRICT
);

CREATE TABLE IF NOT EXISTS ssx_config
(
	id CHAR(36) NOT NULL UNIQUE,
	date_created TIMESTAMP NOT NULL,
	created_by CHAR(36) NOT NULL,
	date_modified TIMESTAMP NOT NULL,
	modified_by CHAR(36) NOT NULL,
	"object_name" VARCHAR(255) NOT NULL,
	object_value TEXT NOT NULL,
	PRIMARY KEY(id),
	FOREIGN KEY (created_by) REFERENCES ssx_user(id) ON DELETE RESTRICT,
	FOREIGN KEY (modified_by) REFERENCES ssx_user(id) ON DELETE RESTRICT
);

CREATE TABLE IF NOT EXISTS ssx_pages
(
	id CHAR(36) NOT NULL UNIQUE,
	date_created TIMESTAMP NOT NULL,
	created_by CHAR(36) NOT NULL,
	date_modified TIMESTAMP NOT NULL,
	modified_by CHAR(36) NOT NULL,
	title VARCHAR(255) NOT NULL,
	slug VARCHAR(255) NOT NULL,
	content TEXT NOT NULL,
	seo_title VARCHAR(255) NULL,
	seo_keywords VARCHAR(255) NULL,
	seo_description TEXT NULL,
	featured_image VARCHAR(255) NULL,
	status SMALLINT NULL CHECK (status IN (0,1)) DEFAULT 0,
	PRIMARY KEY(id),
	FOREIGN KEY (created_by) REFERENCES ssx_user(id) ON DELETE RESTRICT,
	FOREIGN KEY (modified_by) REFERENCES ssx_user(id) ON DELETE RESTRICT
);

CREATE TABLE IF NOT EXISTS ssx_tags
(
	id CHAR(36) NOT NULL UNIQUE,
	date_created TIMESTAMP NOT NULL,
	created_by CHAR(36) NOT NULL,
	date_modified TIMESTAMP NOT NULL,
	modified_by CHAR(36) NOT NULL,
	name VARCHAR(150) NOT NULL,
	PRIMARY KEY(id),
	FOREIGN KEY (created_by) REFERENCES ssx_user(id),
	FOREIGN KEY (modified_by) REFERENCES ssx_user(id)
);

CREATE TABLE IF NOT EXISTS ssx_tags_object
(
	tag_id CHAR(36) NOT NULL,
	"object_id" CHAR(36) NOT NULL,
	object_table VARCHAR(60) NOT NULL,
	PRIMARY KEY(tag_id,"object_id")
);

