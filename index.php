<?php
session_start();
if(isset($_SESSION['id_u']) and isset($_SESSION["statut"])){//On empêche l'accès à la page aux utilisateurs connecté
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
define('MyConst', TRUE); //utilisé pour limiter l'accès à la page ajout_produit par exemple, plus généralement les fichiers en include
include("fonctions.php");

$con=connect_sqli(); 
$con->set_charset("utf8");
include("ajout_produit.php");
?>

<?=accueil_menu($nbreprod)?>

    <div class="presentation">
    <h2 class="ligne machine" id="ligne">Bienvenue sur notre site! <br> Ici vous aurez accès à des articles tous droits venus du Japon.</h2> 
     <form action="chercher.php" method="POST">
    <input type="text" name="recherche" />
     <input type="submit" value="Chercher" />
    </form>
    </div>
	 
        <article>
            <h1>Produits</h1>
            <section>
                <div class="carousel-container">
                  <div class="carousel-inner">
                    <div class="track">
                      <div class="card-container">
                        <div class="card">
                            <a href="patisserie.php">
                            <img src="products/Dorayaki.jpg"></div>

                      </div>
                      <div class="card-container">
                        <div class="card">
                            <a href="bonbon.php">
                            <img src="products/ChupaChups.jpg"></div></a>
                      </div>
                      <div class="card-container">
                        <div class="card">
                          <a href="goodies.php">
                          <img src="products/peluche-pikachu.jpg"></div></a>
                      </div>
              
                      <div class="card-container">
                        <div class="card">
                          <a href="boisson.php">
                          <img src="products/mitsuya-pomme-riche.jpg"></div></a>
                      </div>
                      <div class="card-container">
                        <div class="card">
                          <a href="boisson.php">
                          <img src="products/pepsi-japon-cola.jpg"></div></a>
                      </div>
                      <div class="card-container">
                        <div class="card">
                          <a href="nouille.php">
                          <img src="products/yakisoba-okonomi.jpg"></div></a>
                      </div>
                      <div class="card-container">
                        <div class="card">
                          <a href="nouille.php">
                          <img src="products/chicken-ramen.jpg"></div></a>
                      </div>
                      <div class="card-container">
                        <div class="card">
                          <a href="patisserie.php">
                          <img src="products/baumkuchen-banana.jpg"></div></a>
                      </div>
                      <div class="card-container">
                        <div class="card">
                          <a href="patisserie.php">
                          <img src="products/Mochi.jpg"></div></a>
                      </div>
                    </div>
                  </div>
                  <div class="nav">
                    <button class="prev"><</button>
                    <button class="next">></button>
                  </div>
                </div>      
            </section>
        </article>


  
  <?=footer()?>
