<html>
<head>
  <title>Adaugare utilizator</title>
</head>
<body>
 <form class="form-horizontal" action="inregistrare.php" method="post">
<fieldset>

<!-- Form Name -->
<legend>Inregistrare</legend>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="username">Nume utilizator</label>
  <div class="controls">
    <input id="username" name="username" type="text" placeholder="Nume utilizator" class="input-medium">
    
  </div>
</div>

<!-- Password input-->
<div class="control-group">
  <label class="control-label" for="passwordinput">Parola</label>
  <div class="controls">
    <input id="passwordinput" name="passwordinput" type="password" placeholder="Parola" class="input-medium">
    
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="Numeinput">Nume</label>
  <div class="controls">
    <input id="Numeinput" name="numeinput" type="text" placeholder="Nume" class="input-medium">
    
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="dataninput">Data nasterii</label>
  <div class="controls">
    <input id="dataninput" name="dataninput" type="date" placeholder="Data Nasterii" class="input-medium">
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="emailinput">Adresa email</label>
  <div class="controls">
    <input id="emailinput" name="emailinput" type="email" placeholder="Email" class="input-medium">
    
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

</body>
</html>