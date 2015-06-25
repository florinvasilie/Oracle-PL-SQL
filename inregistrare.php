<html>
<head>
	<title></title>
</head>
<body>
<?php
	if (!$_REQUEST["username"]){
		echo "<p>Nu ati introdus numele de utilizator!</p>";
		die();
	}
	if(!$_REQUEST["passwordinput"]){
		echo "<p>Nu ati specificat parola!</p>";
		die();
	}
	if(!$_REQUEST["numeinput"]){
		echo "<p>Nu ati introdus numele dvs!</p>";
		die();
	}
	if(!$_REQUEST["dataninput"]){
		echo "<p>Nu ati specificat data nasterii!</p>";
		die();
	}
	if(!$_REQUEST["emailinput"]){
		echo "<p>Nu ati introdus adresa de email!</p>";
		die();
	}
	$conn=oci_connect("c##fac","fac","localhost/orcl");
	$s = ociparse($conn, "SELECT manage_utilizatori.isBlacklist('".$_REQUEST["emailinput"]."') AS TEST FROM DUAL");
	if(ociexecute($s))
    {
        if (ocifetch($s)) 
        {
            $test=ociresult($s, "TEST");          
            
        }
    }
    else
    {
	$e = oci_error($s); 
        echo htmlentities($e['message']);
    }
    if($test){
    	echo "<p>Ne pare rau dar nu va puteti crea cont deoarece emailul este in blacklist.</p>";
    	die();
    }
    $s=ociparse($conn, "SELECT manage_utilizatori.isUser('".$_REQUEST["emailinput"]."') AS TEST FROM DUAL");
    if(ociexecute($s))
    {
        if (ocifetch($s)) 
        {
            $test=ociresult($s, "TEST");          
            
        }
    }
    else
    {
	$e = oci_error($s); 
        echo htmlentities($e['message']);
    }
    if($test){
    	echo "<p>Ne pare rau dar adresa de email este in uz.</p>";
    	die();
    }
    $s=ociparse($conn, "SELECT COUNT(*) FROM utilizatori where username='".$_REQUEST["username"]."'");
    if(ociexecute($s))
    {
        if (ocifetch($s)) 
        {
            $test=ociresult($s, "COUNT(*)");          
            
        }
    }
    else
    {
	$e = oci_error($s); 
        echo htmlentities($e['message']);
    }
    if($test){
    	echo "<p>Ne pare rau dar numele de utilizator este deja folosit.</p>";
    	die();
    }
    $s=ociparse($conn, "INSERT INTO utilizatori(username,passwd,nume,email,data_nasterii) VALUES ('".$_REQUEST["username"]."','".$_REQUEST["passwordinput"]."
    	','".$_REQUEST["numeinput"]."','".$_REQUEST["emailinput"]."',TO_DATE('".$_REQUEST["dataninput"]."','YYYY-MM-DD'))");
    $r = oci_execute($s, OCI_NO_AUTO_COMMIT);
	if (!$r) {    
	    $e = oci_error($s);
	    oci_rollback($conn);  
	}
	$r = oci_commit($conn);
	if (!$r) {
	    $e = oci_error($conn);
	    trigger_error(htmlentities($e['message']), E_USER_ERROR);
	}

	$s=ociparse($conn,"SELECT username,nume FROM utilizatori WHERE username='".$_REQUEST["username"]."'");
	
	if(ociexecute($s))
    {
        while (ocifetch($s)) 
        {
             
            echo "<p>".ociresult($s, "USERNAME")."</p>";
            echo "<p>".ociresult($s, "NUME")."</p>";
             
            
        }
    }
    else
    {
	$e = oci_error($s); 
        echo htmlentities($e['message']);
    }

	oci_close($conn);
	echo "<p>Utilizatorul a fost creat!</p>"
?>
</body>
</html>