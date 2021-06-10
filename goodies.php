<?php 
session_start();
if(isset($_SESSION['id_u']) and isset($_SESSION["statut"])){
  if($_SESSION["statut"]==1){
    header("location: pages_client/index_client.php");
  }
  if($_SESSION["statut"]==2){
    header("location: page_vendeur.php");
  }
  if($_SESSION["statut"]==3){
    header("location: pages_admin/page_admin.php");
  }
}
define('MyConst', TRUE);
include("fonctions.php");
    $con=connect_sqli(); 
$con->set_charset("utf8");
    include("ajout_produit.php");
    if (isset($msgpanier)){
    echo $msgpanier; //indique si le produit a déjà été ajouté ou non
  }
?>

 <?=menu("Goodies",$nbreprod,"produits")?>
<?php
$sql="SELECT * FROM produits WHERE catp='goodie' and qtep<>0 and (statutprod is null or statutprod<>'supprime')  ";
//Code pour la pagination
$result=$con->query($sql);
$result_par_page=10; //Nombre de produits par page
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
$sql="SELECT * FROM produits WHERE catp='goodie' and qtep<>0 and (statutprod is null or statutprod<>'supprime') LIMIT ".$index_limit.','.$result_par_page;
$result=$con->query($sql);

?>
    <article class="container">
<?php
    

    if ( ! $result )
    {
         echo "<p> Probleme </p>" ;
    }
    else{
        while ($ligne = $result->fetch_object()) {
            echo "
    <section class='image'>
          <form method='post' action=''>
             <input type='hidden' name='id' value=".$ligne->id_produit." />
            <a href='page_produit.php?id_produit=$ligne->id_produit'><img src='".$ligne->image."' ></a>
            <p>".$ligne->nomp."</p>
            <p>".$ligne->prixp." ¥</p>
           
             <button type='submit' class='ajout produit1' >Ajouter au panier</button>
           </form>
        </section>";
        }
    } 
       
 ?>    
    </article>
  <div class="pagination" id="pagination">
<?php
for ($page=1;$page<=$nombre_page;$page++){
  echo '<a href=goodies.php?page='.$page.'>'.$page.'</a> ';
}
?>
</div>

<?=footer()?>
