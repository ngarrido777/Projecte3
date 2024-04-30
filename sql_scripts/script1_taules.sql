DROP TABLE if exists registres;
DROP TABLE if exists inscripcions;
DROP TABLE if exists participants;
DROP TABLE if exists beacons;
DROP TABLE if exists checkponts;
DROP TABLE if exists circuits_categories;
DROP TABLE if exists circuits;
DROP TABLE if exists categories;
DROP TABLE if exists curses;
DROP TABLE if exists esports;
DROP TABLE if exists estats_cursa;
DROP TABLE if exists usuaris;

-- taula 'usuaris'
CREATE TABLE usuaris (
	usr_id INT AUTO_INCREMENT,
	usr_login VARCHAR(20) NOT NULL,
	usr_password VARCHAR(20) NOT NULL,
	usr_admin TINYINT(1) NOT NULL,

	PRIMARY KEY (usr_id),

	CONSTRAINT SK_Usuaris UNIQUE (
		usr_id
	)
);

-- taula 'estats_cursa'
CREATE TABLE estats_cursa (
	est_id INT AUTO_INCREMENT,
	est_nom VARCHAR(20) NOT NULL,

	PRIMARY KEY (est_id)
);

-- taula 'esports'
CREATE TABLE esports (
	esp_id INT AUTO_INCREMENT,
	esp_nom VARCHAR(20) NOT NULL,

	PRIMARY KEY (esp_id)
);

-- taula 'curses'
CREATE TABLE curses (
	cur_id INT AUTO_INCREMENT,
	cur_nom VARCHAR(20),
	cur_data_inici DATE NOT NULL,
	cur_data_fi DATE NOT NULL,
	cur_lloc VARCHAR(20) NOT NULL,
	cur_esp_id INT NOT NULL,
	cur_est_id INT NOT NULL,
	cur_desc VARCHAR(20),
	cur_limit_inscr VARCHAR(20) NOT NULL,
	cur_foto BLOB NOT NULL,
	cur_web VARCHAR(20),
	

	PRIMARY KEY (cur_id),
	CONSTRAINT FK_Curses_EspId FOREIGN KEY (cur_esp_id) REFERENCES esports (esp_id),
	CONSTRAINT FK_Curses_EstId FOREIGN KEY (cur_est_id) REFERENCES estats_cursa (est_id)
);

-- taula 'categories'
CREATE TABLE categories (
	cat_id INT AUTO_INCREMENT,
	cat_esp_id INT NOT NULL,
	cat_nom	VARCHAR(20) NOT NULL,

	PRIMARY KEY (cat_id),
	CONSTRAINT FK_Categories_EspId FOREIGN KEY (cat_esp_id) REFERENCES esports (esp_id)
);

-- taula 'circuits'
CREATE TABLE circuits (
	cir_id INT AUTO_INCREMENT,
	cir_cur_id INT NOT NULL,
	cir_num INT,
	cir_distancia DECIMAL(10,2) NOT NULL,
	cir_nom VARCHAR(200) NOT NULL,
	cir_preu DECIMAL(19,4) NOT NULL,
	cir_temps_estimat DATE,

	PRIMARY KEY (cir_id),
	CONSTRAINT FK_Circuits_CirId FOREIGN KEY (cir_cur_id) REFERENCES curses (cur_id),

	CONSTRAINT SK_Circuits UNIQUE (
		cir_cur_id,
		cir_num
	)
);

-- taula 'circuits categories'
CREATE TABLE circuits_categories (
	ccc_id INT AUTO_INCREMENT,
	ccc_cat_id INT,
	ccc_cir_id INT,

	PRIMARY KEY (ccc_id),
	CONSTRAINT FK_CirCat_CirId FOREIGN KEY (ccc_cir_id) REFERENCES circuits (cir_id),
	CONSTRAINT FK_CirCat_CatId FOREIGN KEY (ccc_cat_id) REFERENCES categories (cat_id),

	CONSTRAINT SK_CirCat UNIQUE (
		ccc_cat_id,
		ccc_cir_id
	)
);

-- Taula 'checkponts'
CREATE TABLE checkponts (
	chk_id INT AUTO_INCREMENT,
	chk_cir_id INT NOT NULL,
	chk_pk DECIMAL(10,2),

	PRIMARY KEY (chk_id),
	CONSTRAINT FK_Checkpoints_CirId FOREIGN KEY (chk_cir_id) REFERENCES circuits (cir_id)
);

-- Taula 'beacons'
CREATE TABLE beacons (
	bea_id INT AUTO_INCREMENT,
	bea_code VARCHAR(200) NOT NULL,

	PRIMARY KEY (bea_id),
	CONSTRAINT SK_Beacon UNIQUE (bea_code)
);

-- taula 'participants'
CREATE TABLE participants (
	par_id INT AUTO_INCREMENT,
	par_nif VARCHAR(9) NOT NULL,
	par_nom VARCHAR(50) NOT NULL,
	par_cognoms VARCHAR(50) NOT NULL,
	par_data_naixement DATE NOT NULL,
	par_telefon VARCHAR(20) NOT NULL,
	par_email VARCHAR(200) NOT NULL,
	par_es_federat TINYINT(1) NOT NULL,

	PRIMARY KEY (par_id)
);

-- taula 'inscripcions'
CREATE TABLE inscripcions (
	ins_id INT AUTO_INCREMENT,
	ins_par_id INT NOT NULL,
	ins_data DATE NOT NULL,
	ins_dorsal INT NOT NULL,
	ins_rtirat TINYINT NOT NULL,
	ins_bea_id INT,
	ins_ccc_id INT,
	

	PRIMARY KEY (ins_id),
	CONSTRAINT FK_Inscripcions_ParId FOREIGN KEY (ins_par_id) REFERENCES participants (par_id),
	CONSTRAINT FK_Inscripcions_BeaId FOREIGN KEY (ins_bea_id) REFERENCES beacons (bea_id),
	CONSTRAINT FK_Inscripcions_CccId FOREIGN KEY (ins_ccc_id) REFERENCES circuits_categories (ccc_id)
);

-- taula 'registres'
CREATE TABLE registres (
	reg_id INT AUTO_INCREMENT,
	reg_ins_id INT NOT NULL,
	reg_chk_id INT NOT NULL,
	reg_temps TIMESTAMP NOT NULL,

	PRIMARY KEY (reg_id),
	CONSTRAINT FK_Registres_InsId FOREIGN KEY (reg_ins_id) REFERENCES registres (reg_id),
	CONSTRAINT FK_Registres_ChkId FOREIGN KEY (reg_chk_id) REFERENCES checkponts (chk_id),

	CONSTRAINT SK_Beacon UNIQUE (
		reg_ins_id,
		reg_chk_id
	)	
);