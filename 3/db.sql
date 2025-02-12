CREATE TABLE applications (
  id_app int(10) unsigned NOT NULL AUTO_INCREMENT,
  FIO varchar(150) NOT NULL,
  tel int(10) NOT NULL,
  email varchar(80) NOT NULL,
  DR DATE NOT NULL,
  sex int(1) NOT NULL DEFAULT 0,
  bio varchar(200),
  PRIMARY KEY (id_app)
) ENGINE = InnoDB;

CREATE TABLE languages (
	id_lang int(2) unsigned NOT NULL AUTO_INCREMENT,
	lang varchar(10) NOT NULL,
	PRIMARY KEY (id_lang)
) ENGINE = InnoDB;

INSERT INTO languages VALUES(0, 'Pascal');
INSERT INTO languages VALUES(0, 'C');
INSERT INTO languages VALUES(0, 'C++');
INSERT INTO languages VALUES(0, 'JavaScript');
INSERT INTO languages VALUES(0, 'PHP');
INSERT INTO languages VALUES(0, 'Python');
INSERT INTO languages VALUES(0, 'Java');
INSERT INTO languages VALUES(0, 'Haskel');
INSERT INTO languages VALUES(0, 'Clojure');
INSERT INTO languages VALUES(0, 'Prolog');
INSERT INTO languages VALUES(0, 'Scala');

CREATE TABLE app_langs (
	id_app int(10) unsigned NOT NULL,
	id_lang int(2) unsigned NOT NULL,
	FOREIGN KEY (id_app) REFERENCES applications (id_app),
	FOREIGN KEY (id_lang) REFERENCES languages (id_lang)
) ENGINE = InnoDB;