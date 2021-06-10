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
<?=menu_admin("Vendeurs","panier")?>
<?php 
//Code pour supprimer le vendeur
if (isset($_POST["supprimer"])){
	$idv=$_POST["id_u"];
	$sql="SELECT COUNT(*) as cpmtproduit FROM produits WHERE id_vendeur=$idv";//On compte le nombre de produits vendu par le vendeur
	$result=$con->query($sql);
	$ligne=mysqli_fetch_array($result);
	if($ligne['cpmtproduit']<5){
		$sql="UPDATE produits SET id_vendeur=NULL, statutprod='supprime' WHERE id_vendeur=$idv"; //Avec cette requête on evite le msg d'erreur dut à la jointure et on garde le produit ds la base de données
		$con->query($sql);
		$sql2="DELETE FROM utilisateurs WHERE id_u=$idv";
		$con->query($sql2);
	}
	else {
		echo "<br>Ce vendeur vend plus de 5 produits, il n'est pas conseillé de le supprimer";
	}

}

//Code pour la pagination
$sql="SELECT * from utilisateurs WHERE statut=2";
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
$sql="SELECT * FROM utilisateurs WHERE statut=2 LIMIT ".$index_limit.','.$result_par_page;
$result=$con->query($sql);

?>

	<div class="product-container">
        <div class="product-header">
            <h2 class="titre">Vendeur</h2>
            <h2 class="mail">Mail</h2>
            <h2 class="entreprise">Entreprise</h2>

      		<h2 class="total">     </h2>
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
<div class="entreprise">
<?php echo $ligne->nomEntreprise; ?>
</div>

<div class="total">
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
	echo '<a href=vendeurs.php?page='.$page.'>'.$page.'</a> ';
}
?>
</div>
</body>
<script>
<!--
function confirmation()
{
var agree=confirm("Voulez-vous vraiment supprimer ce vendeurs?");
if (agree)
 return true ;
else
 return false ;
}
// -->
</script>
</html>