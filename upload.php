<html>
<head>
	<title>Upload & execute</title>
</head>
<body>
<?php
	$target_dir = "uploads/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$csvFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	$mimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');
	if(in_array($_FILES["fileToUpload"]['type'],$mimes))
	{
		if (file_exists($target_file)) 
		{
	    	echo "Fisierul incarcat exista!";
	    	$uploadOk = 0;
		}
		if ($uploadOk == 0) 
		{
	    	echo "Fisierul nu a fost incarcat!";
			// if everything is ok, try to upload file
		} 
		else 
		{
	    		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
	    		{
	        		echo "Fisierul ". basename( $_FILES["fileToUpload"]["name"]). " a fost incarcat cu succes!.";
	        		$conn = oci_connect("c##fac","fac","localhost/orcl");
	        		If (!$conn)
						echo '<p>Failed to connect to Oracle</p>';
					else 
						echo '<p>Succesfully connected with Oracle DB</p>';
					$s = ociparse($conn, "
					BEGIN
					  :rez:=INCARCARE_CSV('BLACKLIST','SGBD','fisier.csv',1,',','\"');
					END;");
					$rowsIns=0;
					oci_bind_by_name($s, ':rez', $rowsIns,SQLT_INT);
					if(ociexecute($s))
				    {
				     	echo "<p>Au fost introduse ".$rowsIns." linii in tabel</p>";
				    }
				    else
				    {
					$e = oci_error($s); 
				        echo htmlentities($e['message']);
				        echo "<p>Au fost introduse ".$rowsIns." linii in tabel</p>";
    				}
	    		} 
	    		else 
	    		{
	        		echo "A aparut o eroare la incarcarea fisierului!.";
	    		}
		}
	} 
	else
	{
	  die("Fisierul nu este csv!");
	}


?>
</body>
</html>