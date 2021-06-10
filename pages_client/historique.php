<?php
session_start();

if(isset($_SESSION["pseudo"])){
	$pseudo=$_SESSION["pseudo"];
	$idu=$_SESSION["id_u"];
}
if(isset($_SESSION["id_u"])){
	if($_SESSION["statut"]==1) {
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
			<h2 class="titre">Commande</h2>
			<h2 class="prix">Total</h2>
			<h2 class="quantite">Paiement</h2>
			<h2 class="total">Date</h2>

		</div>
		<div class="produits">
			<?php
			$sql="SELECT * from commande WHERE etatcommande='fini' and id_client=$idu";
			$result=$con->query($sql);		
			if(mysqli_num_rows($result)>0){
				while($ligne = $result->fetch_object()) {?>
					<?php 
					$idcom=$ligne->id_com; 
					$sql2="SELECT * from commande c, panier p, produits pr WHERE c.etatcommande='fini' and c.id_client=$idu and c.id_com=$idcom and c.id_com=p.id_com and p.id_produit=pr.id_produit";
					$result2=$con->query($sql2);
	/*	if ($con->query($sql2) === TRUE) {
  			echo "Insertion panier ok";
		} else {
 			echo "Error: " . $sql2 . "<br>" . $con->error;
 		}*/
 		if(mysqli_num_rows($result2)>0){
 			$row=mysqli_fetch_assoc($result2);
 			?>
 			<a href="detail_co.php?page=produit&id_com=<?=$row['id_com']?>">
 				<div class="align">
 					<div class="produit">

 						<img src='<?php echo '../'.$row['image']; ?>'>
 						<span>
 							<?php echo 'Commande: #'.$row['id_com']; ?></span>
 						</div>
 						<div class="prix"><?php echo $row["prixtotal"].'¥'; ?></div>
 						<div class="quantite">
 							<?php echo $row["typepaiement"]; ?>
 						</div>
 						<div class="total">
 							<?php echo $row['datecom'];?>
 						</div>
 					</div>
 				</a>	


 				<?php
 			}
 		}
 	}



 	?>
 </div>
</div>

</body>
</html>
<?php
}
	if($_SESSION['statut']==2){
		header("location:../page_vendeur.php");
	}
	if($_SESSION['statut']==3 && !isset($_GET['id_u'])){
		header("location: ../pages_admin/page_admin.php");
	}
	//Permet a l'administrateur de voir les commandes du client en question
	if($_SESSION['statut']==3 && isset($_GET['id_u']) && isset($_GET["id_admin"])){
		define('MyConst', TRUE);
		include("../fonctions.php");
		$idu=$_GET['id_u'];
		$con=connect_sqli(); 
		$con->set_charset("utf8");
		menu_admin_histo("Commandes client","panier");
		?>
		<div class="product-container">
		<div class="product-header">
			<h2 class="titre">Commande</h2>
			<h2 class="prix">Total</h2>
			<h2 class="quantite">Paiement</h2>
			<h2 class="total">Date</h2>

		</div>
		<div class="produits">
			<?php
			$sql="SELECT * from commande WHERE etatcommande='fini' and id_client=$idu";
			$result=$con->query($sql);

			if(mysqli_num_rows($result)>0){
				while($ligne = $result->fetch_object()) { ?>
					<?php 
					$idcom=$ligne->id_com; 
					$sql2="SELECT * from commande c, panier p, produits pr WHERE c.etatcommande='fini' and c.id_client=$idu and c.id_com=$idcom and c.id_com=p.id_com and p.id_produit=pr.id_produit";
					$result2=$con->query($sql2);
	/*if ($con->query($sql2) === TRUE) {
  			echo "Insertion panier ok";
		} else {
 			echo "Error: " . $sql2 . "<br>" . $con->error;
 		}*/
 		if(mysqli_num_rows($result2)>0){
 			$row=mysqli_fetch_assoc($result2);
 			?>
 			<a href="detail_co.php?page=produit&id_com=<?=$row['id_com']?>&id_admin=<?=$_GET['id_admin']?>">
 				<div class="align">
 					<div class="produit">

 						<img src='<?php echo '../'.$row['image']; ?>'>
 						<span>
 							<?php echo 'Commande: #'.$row['id_com']; ?></span>
 						</div>
 						<div class="prix"><?php echo $row["prixtotal"].'¥'; ?></div>
 						<div class="quantite">
 							<?php echo $row["typepaiement"]; ?>
 						</div>
 						<div class="total">
 							<?php echo $row['datecom'];?>
 						</div>
 					</div>
 				</a>	

	<?php
 			}
 		}
 		//Code pour regarder si un utilisateur a une commande en cours ou pas
 		//Avec cette requête on obtient aussi les utilisateurs n'ayant jamais effectué de commandes
 		$sql="SELECT * from commande c, panier p, produits pr, utilisateurs u WHERE c.etatcommande='en cours' and c.id_client=$idu";
 		$result=$con->query($sql);
 		if(mysqli_num_rows($result)>0){
 			echo "<br>Une commande en cours";
 		}
 		else{
 			echo "<br>Pas de commande en cours";
 		}
 	}



 	?>

<?php	
	}
}
else{
	header("location:../index.php");
}
?>

