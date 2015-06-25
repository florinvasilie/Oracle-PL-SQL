set serveroutput on

create or replace package manage_utilizatori
is
	
	--Verifica daca un email este in BlackList return true, daca este nu se mai poate inregistra
	function isBlacklist(v_email in utilizatori.email%type) return integer;
	
	--Verifica daca un mesaj e primti de la un utilizator, daca da afiseaza utilizatorul daca nu afiseaza "anonim".
	function isUser(v_email in utilizatori.email%type) return integer;

end manage_utilizatori;
/

create or replace package body manage_utilizatori
is

	function isBlacklist(v_email in utilizatori.email%type) return integer
	is
		
		v_ok number:=0;
	begin
		select count(*) into v_ok
			from blacklist
			where email=v_email;	
		if (v_ok=1)
		THEN 
			return 1;
		end if;
		return 0;
	end isBlacklist;

	function isUser(v_email in utilizatori.email%type) return integer
	is
		v_ok number:=0;
	begin
		select count(*) into v_ok
			from utilizatori
			where email=v_email;
		if (v_ok=1)
		THEN
			return 1;
		END IF;
		return 0;
	end;

end manage_utilizatori;
/





