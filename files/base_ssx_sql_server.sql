CREATE TABLE [ssx_user]
(
	[id] CHAR(36) NOT NULL UNIQUE,
	[created_by] CHAR(36) NOT NULL,
	[date_created] DATETIME NOT NULL,
	[modified_by] CHAR(36) NOT NULL,
	[date_modified] DATETIME NOT NULL,
	[name] VARCHAR(255) NOT NULL,
	[user] VARCHAR(20) NOT NULL,
	[email] VARCHAR(200) NOT NULL,
	[cpf] VARCHAR(11) NOT NULL,
	[status] INT DEFAULT '1',
	[type] INT DEFAULT '0',
	PRIMARY KEY (id),
	FOREIGN KEY (created_by) REFERENCES ssx_user(id),
	FOREIGN KEY (modified_by) REFERENCES ssx_user(id)
);


INSERT INTO dbo.[ssx_user] VALUES('1', '1', GETDATE ( ) , '1', GETDATE ( ) , 'Admin', 'administrator', 'admin@admin.com.br' ,'00000000000' '1', '1');


CREATE TABLE dbo.[ssx_user_pd]
(
	[user_id] CHAR(36) NOT NULL UNIQUE,
	[modified_by] CHAR(36) NOT NULL,
	[date_modified] DATETIME NOT NULL,
	[type] INT DEFAULT '1',
	[password] CHAR(32) NOT NULL,
	[param_add] VARCHAR(255) NULL,
	PRIMARY KEY(user_id),
	FOREIGN KEY (modified_by) REFERENCES ssx_user(id)
);


INSERT INTO dbo.[ssx_user_pd] VALUES('1', '1', GETDATE ( )  , '1', SUBSTRING(sys.fn_sqlvarbasetostr(HASHBYTES('MD5', '123')),3,36), '');


CREATE TABLE dbo.[ssx_user_token]
(
	[id] CHAR(36) NOT NULL UNIQUE,
	[created_by] CHAR(36) NOT NULL,
	[date_created] DATETIME NOT NULL,
	[modified_by] CHAR(36) NOT NULL,
	[date_modified] DATETIME NOT NULL,
	[user_id] CHAR(36) NOT NULL,
	[token] CHAR(36) NOT NULL,
	[used] INT DEFAULT '0',
	PRIMARY KEY(id),
	FOREIGN KEY (user_id) REFERENCES ssx_user(id)
);

CREATE TABLE dbo.[ssx_config]
(
	id CHAR(36) NOT NULL UNIQUE,
	date_created DATETIME NOT NULL,
	created_by CHAR(36) NOT NULL,
	date_modified DATETIME NOT NULL,
	modified_by CHAR(36) NOT NULL,
	[object_name] VARCHAR(255) NOT NULL,
	[object_value] TEXT NOT NULL,
	PRIMARY KEY(id),
	FOREIGN KEY (created_by) REFERENCES ssx_user(id),
	FOREIGN KEY (modified_by) REFERENCES ssx_user(id)
);


CREATE TABLE dbo.[projects]
(
	[user_id] CHAR(36) NOT NULL UNIQUE,
	[type] INT NOT NULL DEFAULT '0',
	[nome] VARCHAR(150) NOT NULL,
	[email]	VARCHAR(255) NOT NULL,
	[doc] VARCHAR(22) NOT NULL,
	[endereco] VARCHAR(200) NOT NULL,
	[endereco_numero] INT NOT NULL,
	[endereco_complemento] VARCHAR(100) NOT NULL,
	[endereco_cep] INT NOT NULL,
	[cidade] VARCHAR(150) NOT NULL,
	[estado] VARCHAR(2) NOT NULL,
	[responsavel] VARCHAR(200) NULL,
	[phone] VARCHAR(25) NULL,
	[razao_social] VARCHAR(200) NULL,
	[nome_fantasia] VARCHAR(200) NULL,
	[ins_municipal] VARCHAR(30) NULL,
	[ins_estadual] VARCHAR(30) NULL,
	[nome_projeto] TEXT NOT NULL,
	[objetivo_projeto] TEXT NOT NULL,
	[resumo] TEXT NOT NULL,
	[status_projeto] VARCHAR(150) NOT NULL,
	[publico_alvo] VARCHAR(200) NOT NULL,
	[cidade_do_projeto] VARCHAR(200) NOT NULL,
	[onde_foi_executado] VARCHAR(200) NOT NULL,
	[parceiros_do_projeto] TEXT NOT NULL,
	[pessoas_imp_qtd] VARCHAR(150) NOT NULL,
	[pessoas_imp_freq] VARCHAR(150) NOT NULL,
	[web_plataforma] VARCHAR(200) NOT NULL,
	[potencial_transformacao] VARCHAR(255) NOT NULL,
	[interacao_politica] TEXT NULL,
	[como_pode_replicado] TEXT NULL,
	[resultados_esperados] TEXT NULL,
	[avaliacao_resultado] TEXT NULL,
	[projeto_inovador] TEXT NULL,
	[como_soube] TEXT NULL,
	[cidade_ideal] TEXT NULL,
	[interesse_em_participar] TEXT NULL,
	[video_url] VARCHAR(255) NULL,
	[image_urls] TEXT NULL,
	PRIMARY KEY (user_id),
	FOREIGN KEY (user_id) REFERENCES dbo.ssx_user(id),
);
