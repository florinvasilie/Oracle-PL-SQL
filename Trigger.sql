CREATE SEQUENCE petitii_seq START WITH 1 INCREMENT BY 1 NOMAXVALUE; 
/
DROP TRIGGER petitii_increment;
/
CREATE TRIGGER petitii_increment
BEFORE INSERT ON petitii
FOR EACH ROW
BEGIN
 	SELECT	petitii_seq.nextval INTO :new.id_petitie FROM DUAL;
END;
/