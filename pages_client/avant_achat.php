<?php
session_start();
if(isset($_SESSION["id_u"])){
  if($_SESSION["statut"]==1 &&(empty($_SESSION["panier_client"]) || !isset($_SESSION["panier_client"]))){
      header("location: panier_client.php");
  }
  if($_SESSION["statut"]==2){
    header("location:../page_vendeur.php");
  }
  if($_SESSION["statut"]==3){
    header("location:../pages_admin/page_admin.php");
  }
}
else{
  header("location:../index.php");
}

 ?> 

<!DOCTYPE html>
<html>
<head>
	<title>Choix paiement</title>
	<link rel="stylesheet" type="text/css" href="styleCss_client/achat.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<body>
<p style="text-align: center;">Sélectionnez une des deux options:</p>
 <div id="hover-area">
			<h1>Livraison</h1>
		</div>	
		<div id="reveal">
			<p><form method="post" action="achat.php">
					La livraison coûte 530¥ (4 euros).<br><br>
					Adresse de livraison: <input type="text" name="livraison" id="adresse" required><br><br>
					Choisir un moyen de paiement:<br>
					<input type="radio" id="carte" name="paiement" value="carte" checked>
  					<label for="carte"> Carte bancaire <img src="../images/visa.png"></label><br>
  					<input type="radio" id="paypal" name="paiement" value="paypal">
  					<label for="paypal"> Paypal <img src="../images/paypal.png"></label><br>
  					<input type="radio" id="gamachan" name="paiement" value="gamachan">
  					<label for="gamachan"> Gama-chan <img src="../images/gamachan.png"></label><br><br>
  					<?php
  					if (isset($_SESSION["prixtotal"])) {
  						# code...
  					$_SESSION["prix_final"]=$_SESSION["prixtotal"]+530;
  					echo "Prix total: ". $_SESSION["prix_final"]."¥"; }
  					 ?>
  					<br><br><br>

  					<button onclick="location.href='panier_client.php'">Modifier panier</button>
  					<button type="submit">Payer</button>
				</form>

			</p>
		</div>
      
      	<br><br><br>
<div id="hover-area2">

			<h1>Click&Collect</h1>
			</div>
		<div id="reveal2">
			<p>
				Venez chercher nos produits du lundi au samedi dans un de nos entrepôts.<br><br>
				<form method="post" action="achat.php">
				Choisir un moyen de paiement:<br>
					<input type="hidden" name="livraison" value="Non">
					<input type="radio" id="carte" name="paiement" value="carte" checked>
  					<label for="carte"> Carte bancaire <img src="../images/visa.png"></label><br>
  					<input type="radio" id="paypal" name="paiement" value="paypal">
  					<label for="paypal"> Paypal <img src="../images/paypal.png"></label><br>
  					<input type="radio" id="gamachan" name="paiement" value="gamachan">
  					<label for="gamachan"> Gama-chan <img src="../images/gamachan.png"></label><br><br>
  					<?php
  					if (isset($_SESSION["prixtotal"])) {
  						# code...
  					$_SESSION["prix_final"]=$_SESSION["prixtotal"];
  					echo "Prix total: ". $_SESSION["prix_final"]."¥"; }
  					 ?>
  					<br><br><br>

  					<button onclick="location.href='panier_client.php' ">Modifier panier</button>
  					<button type="submit">Payer</button>
				</form>


			</p>
		</div>
      
</body>
<script type="text/javascript">
	$(document).ready(function(){
  $("#hover-area").click(function(){
    $("#reveal").slideToggle(300);
  });
});

$(document).ready(function(){
  $("#hover-area2").click(function(){
    $("#reveal2").slideToggle(300);
  });
});
</script>
</html>
