<?php
	function extragerePagina($conn,$offset, $nr_rez){
		$sql= "SELECT f.*
				FROM (
    				SELECT t.*, rownum r
    				FROM (
       					SELECT *
       					FROM utilizatori
        				ORDER BY username) t
    				WHERE rownum <= :rezt) f
				WHERE r >= :offs";
		$pid = ociparse($conn,$sql);
		oci_bind_by_name($pid, ":offs", $offset);
		oci_bind_by_name($pid, ":rezt", $nr_rez);
		if(ociexecute($pid))
	    {
	        oci_fetch_all($pid, $Res);
	    }
	    else
	    {
		$e = oci_error($pid); 
	        echo htmlentities($e['message']);
	    }
	    return($Res);
	}
?>

<html>
<head>
	<title>Pagianare</title>
</head>
<body>
<?php



	$conn = oci_connect("c##fac","fac","localhost/orcl");

	If (!$conn)
		echo 'Failed to connect to Oracle';
	else 
		echo 'Succesfully connected with Oracle DB';
	echo "<p><a href=index.php>Home</a></p>";
	$s = ociparse($conn, "SELECT COUNT(*) FROM utilizatori");
    echo '<br />';
    if(ociexecute($s))
    {
        if (ocifetch($s)) 
        { 
           $Nr_linii=ociresult($s,"COUNT(*)"); 
        }
    }
    else
    {
	$e = oci_error($s); 
        echo htmlentities($e['message']);
    }
    echo "<p>Numarul de linii din tabel este: ".$Nr_linii."</p>";

    $Per_page=30;
    
	if(!$_GET["Page"])
	{
		$Page=1;
	}
	else $Page = $_GET["Page"];


	$Prev_Page = $Page-1;
	$Next_Page = $Page+1;
	if($Nr_linii<=$Per_page)
	{
		$Num_Pages =1;
	}
	else if(($Nr_linii % $Per_page)==0)
	{
		$Num_Pages =($Nr_linii/$Per_page) ;
	}
	else
	{
		$Num_Pages =($Nr_linii/$Per_page)+1;
		$Num_Pages = (int)$Num_Pages;
	}
	echo "<p>Numarul de pagini: ".$Num_Pages."</p>";
	if($Page>$Num_Pages){
		$Page=$Num_Pages;
	}
	if($Page<1){
		$Page=1;
	}
?>
	<table width="600" border="1">
	  <tr>
	    <th width="198"> <div align="center">USERNAME </div></th>
	    <th width="98"> <div align="center">PASSWD</div></th>
	    <th width="98"> <div align="center">EMAIL </div></th>
	    <th width="98"> <div align="center">NUME </div></th>
	    <th width="98"> <div align="center">DATA_NASTERII </div></th>
	  </tr>
<?php
	$offset=30*($Page-1)+1; $nrez=30+($Page-1)*30;
	$Rezult_pag=extragerePagina($conn,$offset,$nrez);
	if ($Page==$Num_Pages){
		if ($Num_Pages % $Per_page!=0){
			$limit=$Nr_linii-($Num_Pages-1)*$Per_page;
		}
	}
	else $limit=30;
	for($i=0; $i<$limit; $i++) {
		?>
		<tr>
		    <td><div align="center"><?=$Rezult_pag["USERNAME"][$i];?></div></td>
		    <td><?=$Rezult_pag["PASSWD"][$i];?></td>
		    <td><?=$Rezult_pag["EMAIL"][$i];?></td>
		    <td><?=$Rezult_pag["NUME"][$i];?></td>
		    <td><?=$Rezult_pag["DATA_NASTERII"][$i];?></td>
		  </tr>
		<?php
	}
	?>
	</table>
	<br/>
Pagina:
	<?php
	if($Prev_Page)
	{
		echo " <a href='$_SERVER[SCRIPT_NAME]?Page=1'><< First</a> ";
		echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page'><< Back</a> ";
	}
	if($Page!=$Num_Pages)
	{
		echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page'>Next>></a> ";
		echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Num_Pages'>Last>></a> ";
	}
	oci_close($conn);
?>
</body>
</html>
