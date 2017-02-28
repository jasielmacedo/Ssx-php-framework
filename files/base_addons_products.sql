CREATE TABLE IF NOT EXISTS `shop_categories`
(
	id INT NOT NULL AUTO_INCREMENT,
	date_created DATETIME NOT NULL,
	created_by CHAR(36) NOT NULL,
	date_modified DATETIME NOT NULL,
	modified_by CHAR(36) NOT NULL,
	object_name VARCHAR(255) NOT NULL,
	object_parent CHAR(36) NULL DEFAULT "",
	PRIMARY KEY(id),
	FOREIGN KEY (created_by) REFERENCES ssx_user(id),
	FOREIGN KEY (modified_by) REFERENCES ssx_user(id)
)ENGINE=innoDB;

CREATE TABLE IF NOT EXISTS `shop_products`
(
	id INT NOT NULL AUTO_INCREMENT,
	date_created DATETIME NOT NULL,
	created_by CHAR(36) NOT NULL,
	date_modified DATETIME NOT NULL,
	modified_by CHAR(36) NOT NULL,
	name VARCHAR(200) NOT NULL,
	name_cut VARCHAR(120) NOT NULL,
	price_start DECIMAL(5,2) NULL DEFAULT 0.00,
	price_now DECIMAL(5,2) NOT NULL,
	short_description TEXT NULL,
	category_id INT NOT NULL,
	check_stock TINYINT(1) DEFAULT 1,
	status TINYINT(1) DEFAULT 1,
	PRIMARY KEY(id),
	FOREIGN KEY (created_by) REFERENCES ssx_user(id),
	FOREIGN KEY (modified_by) REFERENCES ssx_user(id),
	FOREIGN KEY (category_id) REFERENCES shop_categories(id)
)ENGINE=innoDB;

ALTER TABLE `shop_products` AUTO_INCREMENT = 1000;

CREATE TABLE IF NOT EXISTS `shop_products_variation`
(
    id INT NOT NULL AUTO_INCREMENT,
	product_id INT NOT NULL,
	date_created DATETIME NOT NULL,
	date_modified DATETIME NOT NULL,
	sku VARCHAR(150) NOT NULL UNIQUE,
	name VARCHAR(200) NULL,
	barcode INT NULL DEFAULT 0,
	width INT NOT NULL DEFAULT 0,
	height INT NOT NULL DEFAULT 0,
	length INT NOT NULL DEFAULT 0,
	price_start NUMERIC(5,2) NULL DEFAULT 0.00,
	price_now NUMERIC(5,2) NULL DEFAULT 0.00,
	weight INT NULL DEFAULT 0,
	cfop INT NULL DEFAULT 0,
	ncm INT NULL DEFAULT 0,
	is_default TINYINT(1) DEFAULT 0,
	status TINYINT(1) DEFAULT 1,
	PRIMARY KEY(id),
	FOREIGN KEY (product_id) REFERENCES shop_products(id)
);

ALTER TABLE `shop_products_variation` AUTO_INCREMENT = 1000;

CREATE TABLE IF NOT EXISTS `shop_products_info`
(
	product_var_id INT NOT NULL,
	info_params TEXT NOT NULL,
	PRIMARY KEY(product_var_id),
	FOREIGN KEY (product_var_id) REFERENCES shop_products_variation(id) ON DELETE RESTRICT
);