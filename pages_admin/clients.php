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
?>
<?=menu_admin("Clients","panier")?>
<?php
$id_admin=$_SESSION["id_u"];
//Code pour supprimer l'utilisateur
if (isset($_POST["supprimer"])){
	$idu=$_POST["id_u"];
	$sql="UPDATE commande SET id_client=NULL WHERE id_client=$idu and etatcommande='fini'"; //Avec cette requête on evite le msg d'erreur dut à la jointure et on garde les commandes terminées ds la base de données
	$con->query($sql);
	$sql="DELETE FROM commande WHERE id_client=$idu and etatcommande='en cours'";//On supprime le panier temportaire
	if ($con->query($sql) === TRUE) {
  			echo "Vous avez supprimé un utilisateur avec une commande en cours<br>";
		} 	else {
 			echo "Error: " . $sql . "<br>" . $con->error;
		}
	$sql2="DELETE FROM utilisateurs WHERE id_u=$idu";
	$con->query($sql2);
}


if (isset($_POST["vendeur"])) {
	$idclient=$_POST['id_client'];
	$sql="SELECT * from commande where id_client=$idclient";
	$result=$con->query($sql);
	if(mysqli_num_rows($result)>0){
		$sql="UPDATE commande SET id_client=NULL WHERE id_client=$idclient and etatcommande='fini'"; //Avec cette requête on evite le msg d'erreur dut à la jointure et on garde les commandes terminées ds la base de données
	$con->query($sql);
	$sql="DELETE FROM commande WHERE id_client=$idclient and etatcommande='en cours'";//On supprime le panier temportaire
	if ($con->query($sql) === TRUE) {
  			echo "Ce client a déjà effectué des commandes<br>";
		} 	else {
 			echo "Error: " . $sql . "<br>" . $con->error;
		}
		$sql="UPDATE utilisateurs SET statut=2 WHERE id_u=$idclient";
		if ($con->query($sql) === TRUE) {
  			echo "Ce client est devenu vendeur";
		} else {
 			echo "Error: " . $sql . "<br>" . $con->error;
 		}
	}
	else{
		$sql="UPDATE utilisateurs SET statut=2 WHERE id_u=$idclient";
		if ($con->query($sql) === TRUE) {
  			echo "Ce client est devenu vendeur";
		} else {
 			echo "Error: " . $sql . "<br>" . $con->error;
 		}
	}
}
//Code pour la pagination
$sql="SELECT * from utilisateurs WHERE statut=1";
$result=$con->query($sql);
$result_par_page=10; //Nombre de vendeurs par page
$nombre_result=mysqli_num_rows($result); 

$nombre_page= ceil($nombre_result/$result_par_page);//Nombre total de pages
//Détermine la page actuelle
if(!isset($_GET['page'])){
	$page=1;
}else{
	$page=$_GET['page'];
}

//Donne le premier résultat pour le LIMIT
$index_limit=($page-1)*$result_par_page; 
$sql="SELECT * FROM utilisateurs WHERE statut=1 LIMIT ".$index_limit.','.$result_par_page;
$result=$con->query($sql);

?>

	<div class="product-containerclient">
        <div class="product-headerclient">
            <h2 class="titre">Client</h2>
            <h2 class="mail">Mail</h2>
            <h2 class="commande">Commandes</h2>
            <h2 class="statut">Statut</h2>
      		<h2 class="suppression">    </h2>
        </div>
        <div class="produits">

<?php

while ($ligne=$result->fetch_object()){?>
	<div class="align">
<div class="produit">
<span><?php echo $ligne->pseudo; ?><br><br>
<?php echo $ligne->nomu; ?><br>
<?php echo $ligne->prenom; ?></span>
</div>

<div class="mail">
<span><?php echo $ligne->mailu; ?></span>
</div>
<div class="commande">
<a href="../pages_client/historique.php?id_u=<?=$ligne->id_u?>&id_admin=<?=$id_admin?>">Voir commandes</a>
</div>
<div class="statut">
	<form method="post" action="">
	<input type="hidden" name="id_client" value="<?=$ligne->id_u?>">
	<button type="submit" name="vendeur">Devenir vendeur</button>
	</form>
</div>

<div class="suppression">
  <form method="post" action=''>
    <input type="hidden" name="id_u" value='<?php echo $ligne->id_u; ?>'>
    <button type="submit" name="supprimer" onclick="return confirmation()">Supprimer</button>
  </form>
</div>
</div>

<?php
}

?>
</div>

<div class="pagination" id="pagination">
<?php
for ($page=1;$page<=$nombre_page;$page++){
	echo '<a href=clients.php?page='.$page.'>'.$page.'</a> ';
}
?>
</div>
</body>
<script>
<!--
function confirmation()
{
var agree=confirm("Voulez-vous vraiment supprimer cet utilisateur?");
if (agree)
 return true ;
else
 return false ;
}
// -->
</script>
</html>