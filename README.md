upload.php + import_csv :
        Incarcarea de date dintr-un fisier CSV prin intermediul unei
        proceduri PL/SQL (ce va incarca un numar mare de date din fisierul CSV).
        Daca fisierul contine date eronate atunci nici o inregistrare nu va fi adaugata in
        baza de date si se va afisa utilizatorului pe ce linie apare eroarea.
        
adaugare.php + inregistare.php + modificare.php :
        preluarea de date dintr-un formular al aplicatiei. precum si
        modificarea acestora (tot in cadrul unui formular).

paginare.php + paginare_join.php :
        paginarea datelor din tabelul continand 500.000 de inregistrari
        dupa ce a fost facut join cu unul din celelalte tabele (prima pagina nu va avea
        buton previous si ultima nu va avea buton pentru next).
Trigger.sql :
      trigger pt autoincrement.

Package.sql:
      pachet care contine doua functii, una pentru a verifica daca un tilizator este in blacklist, 
      cealalta pentru a vedea daca un mesaj primit este de la un utilizator.
