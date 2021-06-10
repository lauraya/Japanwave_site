<?php
session_start();
if(isset($_SESSION["id_u"])){
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
include("fonctions_client.php");//Contient toutes les fonctions de connexion etc.
$con=connect_sqli(); 
$con->set_charset("utf8");
include("ajout_produitclient.php"); //Permet de rajouter les produits ds le panier (normalement le fichier est appelé a index_client.php lors de la redirection a la connexion mais ici on fait le include surtout pour pouvoir utiliser la variable $msg_out qui indique si un produit du panier est devenu out of stock)
   $msg="";
if (isset($_POST['action']) && $_POST['action']=="retirer"){ //si on clique sur le bouton submit retirer 
if(!empty($_SESSION["panier_client"])) {
    foreach($_SESSION["panier_client"] as $key => $value) {
        if($_POST["id"] == $key){ //lorsqu'on a trouvé l'id envoyé en oist qui correspond a la clé de shopping_cart, on retire le produit du tableau
        unset($_SESSION["panier_client"][$key]);
        }
            }       
        }
}
if (isset($_POST['action']) && $_POST['action']=="change"){ //Permet de changer la quantité de produits (input hidden line 75)

  foreach($_SESSION["panier_client"] as &$value){
    if(($value['id'] === $_POST["id"]) and ($_POST["quantite"]<=$_POST["qtep"])){
        $value['quantite'] = $_POST["quantite"];
        break; 
    }
   else if (($_POST["quantite"]>$_POST["qtep"])){
        break;
    }
}
}
if(!empty($_SESSION["panier_client"])) { //nombre de produits ds le cart
$compteproduit = count(array_keys($_SESSION["panier_client"]));}
else{
   $compteproduit = 0;
}
if(isset($_SESSION["pseudo"])){
$pseudo=$_SESSION["pseudo"];
}
?>

<?=menu("",$compteproduit,$pseudo,"panier")?>
<?php
if(isset($_SESSION["panier_client"])){
    $prixtotal = 0;

?>    
<div class="product-container">
        <div class="product-header">
            <h2 class="titre">Produit</h2>
            <h2 class="prix">Prix</h2>
            <h2 class="quantite">Quantité</h2>
            <h2 class="total">Total</h2>
        </div>
        <div class="produits">
            <?php  
foreach ($_SESSION["panier_client"] as $produit){
?>   

<div class="align">
<div class="produit"> 
<img src='../<?php echo $produit["image"]; ?>'>
<span><?php echo $produit["nom"]; ?><br>
<form method='post' action=''>
<input type='hidden' name='id' value="<?php echo $produit["id"]; ?>" />
<input type='hidden' name='action' value="retirer" />
<button type='submit' class='retirer'>Retirer</button><br><br>
    <?php
if ($produit["qtep"]<=20){
    echo "Restant : ".$produit["qtep"];
}
  ?><br>
<?php 
echo $produit["msg"];
?>
</form></span>

</div>
<div class="prix"><?php echo $produit["prix"].'¥'; ?></div>
<div class="quantite">
<form method='post' action=''>
    <input type='hidden' name='id' value="<?php echo $produit["id"]; ?>" />
    <input type='hidden' name='qtep' value="<?php echo $produit["qtep"]; ?>" />
    <input type="hidden" name="action" value="change">
    <select style="width: auto" name='quantite' class='quantite' onchange="this.form.submit() ">
<option <?php if($produit["quantite"]==1) echo "selected";?> value="1">1</option>
<option <?php if($produit["quantite"]==2) echo "selected";?> value="2">2</option>
<option <?php if($produit["quantite"]==3) echo "selected";?> value="3">3</option>
<option <?php if($produit["quantite"]==4) echo "selected";?> value="4">4</option>
<option <?php if($produit["quantite"]==5) echo "selected";?> value="5">5</option>
<option <?php if($produit["quantite"]==6) echo "selected";?> value="6">6</option>
<option <?php if($produit["quantite"]==7) echo "selected";?> value="7">7</option>
<option <?php if($produit["quantite"]==8) echo "selected";?> value="8">8</option>
<option <?php if($produit["quantite"]==9) echo "selected";?> value="9">9</option>
<option <?php if($produit["quantite"]==10) echo "selected";?> value="10">10</option>
<option <?php if($produit["quantite"]==11) echo "selected";?> value="11">11</option>
<option <?php if($produit["quantite"]==12) echo "selected";?> value="12">12</option>
<option <?php if($produit["quantite"]==13) echo "selected";?> value="13">13</option>
<option <?php if($produit["quantite"]==14) echo "selected";?> value="14">14</option>
<option <?php if($produit["quantite"]==15) echo "selected";?> value="15">15</option>
</select></form>
</div>

<div class="total"><?php echo $produit["prix"]*$produit["quantite"].'¥'; ?></div>
</div>
<?php 
$prixtotal+=($produit["prix"]*$produit["quantite"]);
$_SESSION["prixtotal"]=$prixtotal;
} ?>

<br>
<h3><?php echo "Prix total : ".$prixtotal.'¥'?></h3>
<?php
echo $_SESSION["msg_out"];//Indique les produits dans le panier du client qui sont devenus out of stock, dans ce cas ceux-ci sont ignorés dans l'affichage du panier (code dans ajout_produitclient.php?>
 <div class="bouton">
  <button onclick="location.href='avant_achat.php'" type="button">Passer commande</button>
    </div><?php }
    else{
        echo "<h2>Panier vide!</h1>";
    }
    
    
    ?> 
        </div>
    </div>

   
</body>
</html>


