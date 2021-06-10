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
<?=menu_admin("Stocks","panier")?>
<?php
//Code après les submit
if (!isset($_SESSION["id_u"])){ //Empêche les non vendeurs de rentrer dans cette page, lors de la connexion on a déclaré 3 variables de session
	header("location: index.php");
}
 if (isset($_POST['prixproduit']) && $_POST['prixproduit']=="changeprix") {//code pour chager le prix dans la bd
 	$prix=$_POST["prix"];
 	$id=$_POST["id"]; //id du produit
 	$sqlprix="UPDATE produits SET prixp=$prix WHERE id_produit=$id";
 	$con->query($sqlprix);
}

if(isset($_POST['qteproduit']) && $_POST['qteproduit']=="changeqte"){
	$quantite=$_POST["quantite"];
	$id=$_POST["id"]; //id du produit
	$sqlqte="UPDATE produits SET qtep=$quantite WHERE id_produit=$id";
	$con->query($sqlqte);
}

if (isset($_POST['supprimer'])) {
  $id=$_POST["id_prod"];
  $sql="UPDATE produits SET statutprod='supprime' WHERE id_produit=$id";
  $con->query($sql);

}

//Code pour la pagination
$sql="SELECT * from produits WHERE (statutprod<>'supprime' or statutprod is null)";
$result=$con->query($sql);
$result_par_page=20; //Nombre de produits par page
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
$sql="SELECT * FROM produits p, utilisateurs u WHERE (statutprod<>'supprime' or statutprod is null) and p.id_vendeur=u.id_u LIMIT ".$index_limit.','.$result_par_page;
$result=$con->query($sql);
?>

	<div class="product-container">
        <div class="product-header">
            <h2 class="titre">Produit</h2>
            <h2 class="vendeur">Vendeur</h2>
            <h2 class="prix">Prix</h2>
			<h2 class="quantite">Quantité</h2>
      <h2 class="total">         </h2>
        </div>
        <div class="produits">
<?php

while ($ligne=$result->fetch_object()){?>
	<div class="align">
<div class="produit">
<img src='<?php echo "../".$ligne->image; ?>'>
<span><?php echo $ligne->nomp; ?><br></span>
</div>
<div class="vendeur">
	<?php echo $ligne->pseudo;?>
</div>
<div class="prix"><span><?php echo $ligne->prixp.'¥'; ?>
<?php
$minprix=floor($ligne->prixp/2);
$maxprix=$ligne->prixp*2;
?>
<form method="post" action=''><br>
<input type="hidden" name="id" value='<?php echo $ligne->id_produit; ?>'><!--On récupère l'id du produit-->
<input type="hidden" name="prixproduit" value="changeprix">
<input type="number" name="prix" value='<?php echo $ligne->prixp; ?>' max='<?php echo $maxprix; ?>' min='<?php echo $minprix; ?>' >
<br><br>
<button type="submit" onClick="window.location.reload();">Modifier prix</button>
</span>
</form>
</div>
<div class="quantite"><span><?php echo $ligne->qtep; ?>
<form method="post" action=''><br>
<input type="hidden" name="id" value='<?php echo $ligne->id_produit; ?>'> <!--On récupère l'id du produit-->
<input type="hidden" name="qteproduit" value="changeqte">
<input type="number" name="quantite" value='<?php echo $ligne->qtep; ?>' min='0' max='10000'>
<br><br>
<button type="submit">Modifier qté</button>
</span>
</form>
</div>
<div class="total">
  <form method="post" action=''>
    <input type="hidden" name="id_prod" value='<?php echo $ligne->id_produit; ?>'>
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
	echo '<a href=stocks.php?page='.$page.'>'.$page.'</a> ';
}
?>
</div>
</body>
<script>
<!--
function confirmation()
{
var agree=confirm("Voulez-vous vraiment supprimer ce produit?");
if (agree)
 return true ;
else
 return false ;
}
// -->
</script>
</html>

