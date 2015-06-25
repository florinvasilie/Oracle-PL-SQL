<html>
<head>
	<title>Modificare date</title>
</head>
<body>
<?php
	if (!$_REQUEST["username"]){
		echo "<p>Nu ati introdus numele de utilizator!</p>";
		die();
	}
	$conn=oci_connect("c##fac","fac","localhost/orcl");
	$s = ociparse($conn, "SELECT username,passwd,nume,to_char(data_nasterii,'YYYY-MM-DD') as data_nasterii,email FROM utilizatori where username='".$_REQUEST["username"]."'");
	if(ociexecute($s))
    {
        if (ocifetch($s)) 
        {
            ?>
            <form class="form-horizontal" action="update.php" method="post">
			<fieldset>

			<!-- Form Name -->
			<legend>Modificare date</legend>

			<!-- Text input-->
			<div class="control-group">
			  <label class="control-label" for="username">Nume utilizator</label>
			  <div class="controls">
			    <input id="username" name="username" type="text" placeholder="Nume utilizator" class="input-medium" value=<?=ociresult($s,"USERNAME") ?> readonly>
			    <p>Acest camp nu este editabil.</p>
			  </div>
			</div>

			<!-- Password input-->
			<div class="control-group">
			  <label class="control-label" for="passwordinput">Parola</label>
			  <div class="controls">
			    <input id="passwordinput" name="passwordinput" type="password" placeholder="Parola" class="input-medium"  value=<?=ociresult($s,"PASSWD") ?>>
			    
			  </div>
			</div>

			<!-- Text input-->
			<div class="control-group">
			  <label class="control-label" for="Numeinput">Nume</label>
			  <div class="controls">
			    <input id="Numeinput" name="numeinput" type="text" placeholder="Nume" class="input-medium"  value=<?=ociresult($s,"NUME") ?>>
			    
			  </div>
			</div>

			<!-- Text input-->
			<div class="control-group">
			  <label class="control-label" for="dataninput">Data nasterii</label>
			  <div class="controls">
			    <input id="dataninput" name="dataninput" type="date" placeholder="Data Nasterii" class="input-medium"  value=<?=ociresult($s,"DATA_NASTERII") ?>>
			  </div>
			</div>

			<!-- Text input-->
			<div class="control-group">
			  <label class="control-label" for="emailinput">Adresa email</label>
			  <div class="controls">
			    <input id="emailinput" name="emailinput" type="email" placeholder="Email" class="input-medium"  value=<?=ociresult($s,"EMAIL") ?>>
			    
			  </div>
			</div>

			<!-- Button -->
			<div class="control-group">
			  <label class="control-label" for="Button">Submit</label>
			  <div class="controls">
			    <button id="Button" name="Button" class="btn btn-default" type="submit">Register</button>
			  </div>
			</div>

			</fieldset>
			</form>
       		<?php            
        }
        else{
        	echo "<p> Utilizatorul cu numele specificat nu exista! </p>";
        	echo "<a href=\"index.php\">Acasa</a> ";
        }
    }
    else
    {
	$e = oci_error($s); 
        echo htmlentities($e['message']);
    }
?>
</body>
</html>