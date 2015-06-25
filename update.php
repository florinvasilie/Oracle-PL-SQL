<html>
<head>
	<title>Confirmare update</title>
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
    	echo "<p>Emailul pe care l-ati introdus nu este valid(BLACKLISTED).</p>";
    	die();
    }
    $s=ociparse($conn, "SELECT COUNT(*) FROM utilizatori where email='".$_REQUEST["emailinput"]."' and username!='".$_REQUEST["username"]."'");
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
    	echo "<p>Ne pare rau dar adresa de email introdusa este in uz.</p>";
    	die();
    }
    $s=ociparse($conn, "UPDATE utilizatori SET passwd='".$_REQUEST["passwordinput"]."',
    	nume='".$_REQUEST["numeinput"]."',
    	email='".$_REQUEST["emailinput"]."',
    	data_nasterii=TO_DATE('".$_REQUEST["dataninput"]."','YYYY-MM-DD')
    	WHERE username='".$_REQUEST["username"]."'");
    $r = oci_execute($s, OCI_NO_AUTO_COMMIT);
	if (!$r) {    
	    $e = oci_error($s);
	    oci_rollback($conn);  // rollback changes to both tables
	}
	$r = oci_commit($conn);
	if (!$r) {
	    $e = oci_error($conn);
	    trigger_error(htmlentities($e['message']), E_USER_ERROR);
	}
	oci_close($conn);
	echo "<p>Datele au fost modificate!</p>"
?>
</body>
</html>