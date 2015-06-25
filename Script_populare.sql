declare
  v_usrn varchar2(20);
  v_pswd varchar2(20);
  v_email varchar2(50);
  v_date date;
  v_name VARCHAR2(20);
BEGIN
  for it in 1..500000 loop
    v_usrn:=dbms_random.string('U', 10);
    v_pswd:=dbms_random.string('A', 5);
    v_email:=dbms_random.string('L', 5)||'@'||dbms_random.string('L', 4)||'.com';
    v_name:=dbms_random.string('U', 5);
    SELECT TO_DATE(
              TRUNC(
                   DBMS_RANDOM.VALUE(TO_CHAR(DATE '2000-01-01','J')
                                    ,TO_CHAR(DATE '2015-12-31','J')
                                    )
                    ),'J'
               ) 
    INTO v_date
    FROM DUAL;
    INSERT INTO utilizatori(
      username,
      passwd,
      nume,
      email,
      data_nasterii      
    )
    VALUES (
      v_usrn,
      v_pswd,
      v_name,
      v_email,
      v_date
    );
  END LOOP;
END;
/
commit;

