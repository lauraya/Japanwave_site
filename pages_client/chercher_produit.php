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
include("fonctions_client.php");
$con=connect_sqli(); 
$con->set_charset("utf8");
include("ajout_produitclient.php");
if(isset($_SESSION["pseudo"])){
$pseudo=$_SESSION["pseudo"];
}
if (isset($_POST["recherche"])) {
	$_SESSION["cherche"]=$_POST["recherche"];
}
if (isset($_SESSION["cherche"])) { //Cela permettra d'éviter les messages d'erreurs si on accède à chercher.php directement
  # code...
$req_cherche="SELECT * FROM  produits WHERE (`nomp` LIKE '%{$_SESSION['cherche']}%')";
     if (isset($msgpanier)){
    echo $msgpanier; //indique si le produit a déjà été ajouté ou non
  } 
  ?>

<?=menu("Recherche",$nbreprod,$pseudo,"produits")?> 
  <article class="container">
<?php
$result = $con->query($req_cherche);
if ( ! $result )
    {
         echo "<p> Probleme </p>" ;
    }
    else{
    	while ($ligne = $result->fetch_object()) {
        echo "
    <section class='image'>
          <form method='post' action='chercher_produit.php'>
            <input type='hidden' name='id' value=".$ligne->id_produit." />
            <img src='../".$ligne->image."' >
            <p>".$ligne->nomp."</p>
            <p>".$ligne->prixp." ¥</p>
            
           <button type='submit' class='ajout produit1' >Ajouter au panier</button>
           </form>
        </section>";
        }
    }
      
 ?>    
    </article>
</body>
</html>
<?php
}
else{
  echo "Vous avez essayé d'accéder directement à la page :p";
}
?>