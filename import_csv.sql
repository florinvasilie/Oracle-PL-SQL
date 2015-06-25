--Am folosit situl https://slobaexpert.wordpress.com/2014/05/28/loading-csv-files-into-oracle-tables-using-plsql/ pentru ajutor

CREATE OR REPLACE FUNCTION INCARCARE_CSV(
	P_TABLE IN VARCHAR2,
	P_DIR IN VARCHAR2 DEFAULT 'SGBD',
	P_FILENAME IN VARCHAR2,
	P_IGNORA_HEADER IN INTEGER DEFAULT 1,
	P_DELIMITATOR IN VARCHAR2 DEFAULT ',',
	P_ESCAPE IN VARCHAR2 DEFAULT '"')
RETURN NUMBER IS 
	V_FD UTL_FILE.FILE_TYPE;
	V_CD INTEGER DEFAULT DBMS_SQL.OPEN_CURSOR;
	V_LINIE VARCHAR2(4000);
	V_NUMEC VARCHAR2(4000);
	V_VAL_BIND VARCHAR2(4000);
	V_STATUS INTEGER;
	V_CONT NUMBER DEFAULT 0;
	V_NRLINII NUMBER DEFAULT 0;
	V_SEP CHAR(1) DEFAULT NULL;
	L_ERRMSG VARCHAR2(4000);
	V_EOF BOOLEAN := FALSE;
BEGIN
	V_CONT:=1;
	--se preia structura tabelului
	FOR CONTOR IN(SELECT COLUMN_NAME,DATA_TYPE FROM USER_TAB_COLUMNS WHERE TABLE_NAME=P_TABLE ORDER BY COLUMN_ID) LOOP
		V_NUMEC:=V_NUMEC||CONTOR.COLUMN_NAME||',';
		V_VAL_BIND:=V_VAL_BIND||CASE WHEN contor.data_type IN ('DATE','TIMESTAMP(6)') THEN 'TO_DATE(:B'||V_CONT||',"YYYY-MM-DD"),' ELSE ':B'||V_CONT||','END;
		V_CONT:=V_CONT+1;
	END LOOP;

	V_NUMEC:=RTRIM(V_NUMEC,',');
	V_VAL_BIND:=RTRIM(V_VAL_BIND,',');
	V_FD:= UTL_FILE.FOPEN(P_DIR,P_FILENAME,'r');
	IF P_IGNORA_HEADER>0 THEN
		BEGIN
			FOR I IN 1..P_IGNORA_HEADER LOOP
				UTL_FILE.GET_LINE(V_FD,V_LINIE);
			END LOOP;
		EXCEPTION
			WHEN NO_DATA_FOUND THEN
				V_EOF:=TRUE;
		END;	
	END IF;

	IF NOT V_EOF THEN
		DBMS_SQL.PARSE(V_CD,'INSERT INTO '||P_TABLE||'('||V_NUMEC||') VALUES ('||V_VAL_BIND||')', DBMS_SQL.NATIVE);
		LOOP
			BEGIN
				UTL_FILE.GET_LINE(V_FD,V_LINIE);
				EXCEPTION
				WHEN NO_DATA_FOUND THEN EXIT;
			END;
			IF LENGTH(V_LINIE)>0 THEN
				FOR I IN 1..V_CONT-1 LOOP
					DBMS_SQL.BIND_VARIABLE(V_CD,':B'||I,rtrim(rtrim(ltrim(ltrim(
				    REGEXP_SUBSTR(V_LINIE,'(^|,)("[^"]*"|[^",]*)',1,I),P_DELIMITATOR),P_ESCAPE),P_DELIMITATOR),P_ESCAPE));
				END LOOP;
				BEGIN
					V_STATUS:=DBMS_SQL.EXECUTE(V_CD);
					V_NRLINII:=V_NRLINII+1;
					EXCEPTION
						WHEN OTHERS THEN
              V_NRLINII:=V_NRLINII+1;
				 			RAISE_APPLICATION_ERROR(-20101, 'A APARUT O EROARE LA LINIA '||V_NRLINII);
				 			ROLLBACK;
              EXIT;
				END;
			END IF;
		END LOOP;
		DBMS_SQL.CLOSE_CURSOR(V_CD);
		UTL_FILE.FCLOSE(V_FD);
		COMMIT;
    ELSE
    	RAISE_APPLICATION_ERROR(-20102,'FISIERUL NU CONTINE DATE DE IMPORTAT');
	END IF;
	COMMIT;
	RETURN V_NRLINII;

END INCARCARE_CSV;
/