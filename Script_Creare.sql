DROP TABLE utilizatori CASCADE CONSTRAINTS;
/
DROP TABLE petitii CASCADE CONSTRAINTS;
/
DROP TABLE semnaturi CASCADE CONSTRAINTS;
/
DROP TABLE mesaje CASCADE CONSTRAINTS;
/
DROP TABLE blacklist CASCADE CONSTRAINTS;
/
DROP INDEX utilizatori_index_email;
/
CREATE TABLE utilizatori(
	username VARCHAR2(30),
	passwd VARCHAR2(30),
	nume VARCHAR2(50),
	email VARCHAR2(40),
	data_nasterii DATE,
	CONSTRAINT utilizarori_pk PRIMARY KEY(username)
);
/
CREATE TABLE petitii(
	id_petitie NUMBER(10) DEFAULT 0,
	categorie VARCHAR2(20),
	titlu VARCHAR2(50),
	data_postarii DATE,
	username VARCHAR2(30),
	vizualizari NUMBER(10),
	continut CLOB,
	destinatar VARCHAR2(20),
	CONSTRAINT petitii_pk PRIMARY KEY (id_petitie),
	CONSTRAINT petitii_fk FOREIGN KEY (username)
	REFERENCES utilizatori (username)
);
/
CREATE TABLE semnaturi(
	id_petitie NUMBER(10),
	username VARCHAR2(30),
	CONSTRAINT semnaturi_fk FOREIGN KEY(id_petitie)
	REFERENCES petitii(id_petitie),
	CONSTRAINT semnaturi_util_fk FOREIGN KEY(username)
	REFERENCES utilizatori (username)
);
/
CREATE TABLE mesaje(
	nume VARCHAR2(50),
	email VARCHAR2(40),
	mesaj CLOB
);
/
CREATE TABLE blacklist(
	email VARCHAR2(40),
	nume VARCHAR2(50)
);
/
CREATE INDEX utilizatori_index_email ON
utilizatori(email);


/
COMMIT;