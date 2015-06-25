<html>
<head>
	<title>Index SGBD</title>
</head>
<body>
	<a href="paginare.php?Page=1">Paginarea date tabel utilizatori fara join</a>
	<br>
	<a href="paginare_join.php?Page=1">Paginarea date tabel utilizatori cu join petitii</a>
	<br>
	<a href="adaugare.php">Adaugare utilizator</a>
	<br>
	<p>Introduceti numele de utilizator pe care doriti sa-l editati.</p>
	<form action="modificare.php" method="post">
		<label>Nume utilizator:</label>
		<div>
			<input  name="username" type="text" placeholder="Nume utilizator">
		</div>
		<div class="controls">
		    <button  name="Button" type="submit">Modifica</button>
		</div>
	</form>
	<form action="upload.php" method="post" enctype="multipart/form-data">
	    Alegeti fisierul csv.
	    <input type="file" name="fileToUpload" id="fileToUpload">
	    <input type="submit" value="Incarca fisier" name="submit">
	</form>
</body>
</html>