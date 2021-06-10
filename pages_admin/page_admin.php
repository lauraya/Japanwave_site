<?php 
session_start();
if(isset($_SESSION["id_u"])){
	if($_SESSION["statut"]==1){
		header("location:../pages_client/index_client.php");
	}
	if($_SESSION["statut"]==2){
		header("location:page_vendeur.php");
	}

}
else{
	header("location:../index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Administrateur</title>
	<link rel="stylesheet" type="text/css" href="Admincss/admin.css">
</head>
<body>
 <h2 style="text-align:center; padding-top: 50px; color: #FFF; 
    font-family: Courier;">Options</h2>
  <ul>
    <li><a href="clients.php" class="btn1">Liste clients</a></li>
    <li><a href="vendeurs.php" class="btn1">Liste vendeurs</a></li>
    <li><a href="stocks.php" class="btn1">Stocks</a></li>
    <li><a href="../deconnexion.php" class="btn1">Déconnexion</a></li>
 	<li><a href="../profils.php" class="btn1">Profil</a>

  </ul>
</body>
</html>