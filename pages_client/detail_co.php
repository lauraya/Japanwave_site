<?php 
session_start();

if(isset($_SESSION["pseudo"])){
	$pseudo=$_SESSION["pseudo"];
	$idu=$_SESSION["id_u"];
}

if(isset($_SESSION["id_u"])){
if ($_SESSION["statut"]==2) {
	header("location:../page_vendeur.php");
}

if ($_SESSION["statut"]==3 && !isset($_GET['id_admin'])){
	header("location:../pages_admin/page_admin.php");
}

	if($_SESSION["statut"]==1){
include("fonctions_client.php");
$con=connect_sqli(); 
$con->set_charset("utf8");
if(!empty($_SESSION["panier_client"])) { //nombre de produits ds le cart
	$compteproduit = count(array_keys($_SESSION["panier_client"]));}
	else{
		$compteproduit = 0;
	}



	?>

	<?=menu("",$compteproduit,$pseudo,"panier")?>
	<div class="product-container">
		<div class="product-header">
			<h2 class="titre">Produit</h2>
			<h2 class="prix">Prix</h2>
			<h2 class="quantite">Quantité</h2>
			<h2 class="total">Total</h2>
		</div>
		<div class="produits">
			<?php
			if(isset($_GET['id_com'])){
				$idcom=$_GET['id_com'];
				$sql="SELECT c.id_com, c.prixtotal,pr.nomp,pr.image,pr.prixp,p.qtecom FROM commande c, panier p, produits pr WHERE c.id_com=$idcom and c.id_com=p.id_com and p.id_produit=pr.id_produit";
				$result=$con->query($sql);
				while ($ligne = $result->fetch_object()) {
					?>
					<div class="align">
						<div class="produit"> 
							<img src="<?php echo '../'.$ligne->image; ?>">
							<span><?php echo $ligne->nomp; ?></span>
						</div>
						<div class=prix>
							<?php echo $ligne->prixp.'¥'; ?>
						</div>
						<div class="quantite">
							<?php echo $ligne->qtecom; ?>
						</div>
						<div class="total">
							<?php
							$prix= $ligne->prixp*$ligne->qtecom;
							echo $prix."¥";
							$prixtotal=$ligne->prixtotal;
							?>
						</div>
					</div>
					<?php
				}
			}

			?>
		</div>
		<?php
		echo "<h2>Prix total: ".$prixtotal."¥</h2>";
		?>
	</div>




</body>
</html>

<?php
}
//Code pour permettre a l'admin d'accéder aux commandes du client
if ($_SESSION["statut"]==3 && isset($_GET['id_admin'])){
	define('MyConst', TRUE);
		include("../fonctions.php");
		$con=connect_sqli(); 
		$con->set_charset("utf8");
		menu_admin_histo("Commande","panier"); ?>
			<div class="product-container">
		<div class="product-header">
			<h2 class="titre">Produit</h2>
			<h2 class="prix">Prix</h2>
			<h2 class="quantite">Quantité</h2>
			<h2 class="total">Total</h2>
		</div>
		<div class="produits">
			<?php
			if(isset($_GET['id_com'])){
				$idcom=$_GET['id_com'];
				$sql="SELECT c.id_com, c.prixtotal,pr.nomp,pr.image,pr.prixp,p.qtecom FROM commande c, panier p, produits pr WHERE c.id_com=$idcom and c.id_com=p.id_com and p.id_produit=pr.id_produit";
				$result=$con->query($sql);
				while ($ligne = $result->fetch_object()) {
					?>
					<div class="align">
						<div class="produit"> 
							<img src="<?php echo '../'.$ligne->image; ?>">
							<span><?php echo $ligne->nomp; ?></span>
						</div>
						<div class=prix>
							<?php echo $ligne->prixp.'¥'; ?>
						</div>
						<div class="quantite">
							<?php echo $ligne->qtecom; ?>
						</div>
						<div class="total">
							<?php
							$prix= $ligne->prixp*$ligne->qtecom;
							echo $prix."¥";
							$prixtotal=$ligne->prixtotal;
							?>
						</div>
					</div>
					<?php
				}
			}

			?>
		</div>
		<?php
		echo "<h2>Prix total: ".$prixtotal."¥</h2>";
		?>
	</div>




</body>
</html>


<?php
}

}
else{
	header("location:../index.php");
}
?>

