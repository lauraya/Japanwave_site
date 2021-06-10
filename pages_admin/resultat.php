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
include("../fonctions.php");
$con=connect_sqli();
$con->set_charset("utf8");
menu_admin("Résultat","panier");
?>
	<div class="product-container">
        <div class="product-header">
            <h2 class="titre">Catégories</h2>
            <h2 class="mail">Résultat</h2>
        </div>
        <div class="produits">
<div class="align">
<div class="produit">
	<p>Chiffre d'affaire</p>
</div>
<div class="mail">
	<?php 
		$sql="SELECT sum(prixtotal) as ca from commande";
		$result=$con->query($sql);
		$ligne=mysqli_fetch_array($result);
		echo $ligne["ca"]."¥";
	?>
</div>
</div>
<div class="align">
<div class="produit">
	<p>Nombre de commandes</p>
</div>
<div class="mail">
	<?php 
		$sql="SELECT COUNT(*) as nbrecom from commande where etatcommande='fini'";
		$result=$con->query($sql);
		$ligne=mysqli_fetch_array($result);
		echo $ligne["nbrecom"];
	?>
</div>
</div>
<div class="align">
<div class="produit">
	<p>Nombre de clients</p>
</div>
<div class="mail">
	<?php 
		$sql="SELECT COUNT(*) as nbreclient from utilisateurs where statut=1";
		$result=$con->query($sql);
		$ligne=mysqli_fetch_array($result);
		echo $ligne["nbreclient"];
	?>
</div>
</div>
<div class="align">
<div class="produit">
	<p>Nombre de vendeurs</p>
</div>
<div class="mail">
	<?php 
		$sql="SELECT COUNT(*) as nbreclient from utilisateurs where statut=2";
		$result=$con->query($sql);
		$ligne=mysqli_fetch_array($result);
		echo $ligne["nbreclient"];
	?>
</div>
</div>

<div class="align">
<div class="produit">
	<p>Nombre de produits</p>
</div>
<div class="mail">
	<?php 
		$sql="SELECT COUNT(*) as nbreclient from produits";
		$result=$con->query($sql);
		$ligne=mysqli_fetch_array($result);
		echo $ligne["nbreclient"];
	?>
</div>
</div>
</div>
</div>
</body>
</html>