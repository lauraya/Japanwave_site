<?php
session_start();
if(isset($_SESSION["id_u"])){
	if ($_SESSION["statut"]==1) {
		include("pages_client/fonctions_client.php");
		$con=connect_sqli(); 
		$con->set_charset("utf8");
		if(!empty($_SESSION["panier_client"])) { //nombre de produits ds le cart
			$compteproduit = count(array_keys($_SESSION["panier_client"]));}
			else{
				$compteproduit = 0;
			}


			?>
			<!DOCTYPE html>
			<html>
			<head>
				<meta charset="UTF-8">
				<meta name="viewport" content="width=device-width, initial-scale=1">
				<title>profil</title>
				<link rel="stylesheet" type="text/css" href="styleCSS/accueil_site.css" />
				<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
			</head>
			<body>
				<header>
					<h1><?=$_SESSION["pseudo"]?></h1> 
				</header>
				<div class="nav-wrapper">
					<nav id="barre">
						<ul>
							<img src="images/logo.png" alt="logo japonais">
							<li class="deroulant"><a href="pages_client/index_client.php">Accueil</a></li>
							<li class="deroulant"><a href="#">Alimentation ▼</a>
								<ul class="deroule">
									<li><a href="pages_client/Patisserie_client.php">Pâtisseries</a></li>
									<li><a href="pages_client/bonbon_client.php">Bonbons</a></li>
									<li><a href="pages_client/boisson_client.php">Boissons</a></li>
									<li><a href="pages_client/nouille_client.php">Nouilles</a></li>
								</ul>
							</li>
							<li class="deroulant"><a href="pages_client/goodies_client.php">Goodies</a>
							</li>

							<li class="droite deroulant"><a href="#"><?=$_SESSION["pseudo"]?> ▼</a>
								<ul class="deroule">
									<li><a href="../profils.php">Profil</a></li>
									<li><a href="pages_client/historique.php">Historique commande</a></li>
									<li><a href="deconnexion.php">Déconnexion</a></li>
								</ul>
							</li>

							<li class="droite panier"><a href="pages_client/panier_client.php"><ion-icon name="cart-outline" color="white"></ion-icon>Panier(<span><?=$compteproduit?></span>)</a></li>
						</ul>
					</nav>
				</div>
				<br><br><br>
				<ul style="text-align: center">
				<li style="font-size: 20px"><a href="pages_client/panier_client.php">Voir mon panier</a></li>
				<li style="font-size: 20px"><a href="pages_client/historique.php">Voir mon historique</a></li>
				<li style="font-size:20px; cursor: pointer;">
				<div id="hover-area">
			Changer le mot de passe
			<?php if(isset($_POST["nouveaumdp"])){
			$idu=$_SESSION["id_u"];
			$mdpactuel=$_POST["actuelmdp"];
			$sql="SELECT * from utilisateurs where (mdpu='$mdpactuel' or mdpu=md5('$mdpactuel')) and id_u=$idu";
			$result=$con->query($sql);
			if(mysqli_num_rows($result)>0){
				$nouveaumdp=$_POST["nouveaumdp"];
				if (strlen($nouveaumdp)>=6){
					$sql="UPDATE utilisateurs SET mdpu=md5('$nouveaumdp') WHERE id_u=$idu";
					$con->query($sql);
					echo "<br><p style='color:green'>Le mot de passe a bien été changé</p>";
				}
				else{
					echo "<br><p style='color:red'>Entrez un mot de passe de plus de 6 caractères</p>";
				}
			}
			else{
				echo "<br><p style='color:red'>Vous n'avez pas entré le bon mot de passe</p>";
			}			
		}?>
		</div>	
		<div id="reveal">
			<p><form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
					Mot de passe actuel: <input type="password" name="actuelmdp" required><br>
					Nouveau mot de passe: <input type="password" name="nouveaumdp" required><br><br>
					<button type="submit" >Envoyer</button>
				</form>
				

			</p>
		</div></li>
			</ul>
			</body>
			<script type="text/javascript">
				$(document).ready(function(){
			  $("#hover-area").click(function(){
			    $("#reveal").slideToggle(300);
			  });
			});
		</script>
			</html>
			<?php
		}
	if ($_SESSION["statut"]==2) {

		include("fonctions.php");
		$con=connect_sqli(); 
		$con->set_charset("utf8");
		menu_vendeur($_SESSION["pseudo"],"accueil_site");

?>
	
				<br><br><br>
				<ul style="text-align: center">
				<li style="font-size:20px; cursor: pointer;">
				<div id="hover-area">
			Changer le mot de passe
			<?php 	
			if(isset($_POST["entreprise"])){
				$idu=$_SESSION["id_u"];
				$nomEntreprise=$_POST["entreprise"];
				$sql="UPDATE utilisateurs SET nomEntreprise='$nomEntreprise' WHERE id_u=$idu";
				$con->query($sql);
			}

			if(isset($_POST["nouveaumdp"])){
			$idu=$_SESSION["id_u"];
			$mdpactuel=$_POST["actuelmdp"];
			$sql="SELECT * from utilisateurs where (mdpu='$mdpactuel' or mdpu=md5('$mdpactuel')) and id_u=$idu";
			$result=$con->query($sql);
			if(mysqli_num_rows($result)>0){
				$nouveaumdp=$_POST["nouveaumdp"];
				if (strlen($nouveaumdp)>=6){
					$sql="UPDATE utilisateurs SET mdpu=md5('$nouveaumdp') WHERE id_u=$idu";
					$con->query($sql);
					echo "<br><p style='color:green'>Le mot de passe a bien été changé</p>";
				}
				else{
					echo "<br><p style='color:red'>Entrez un mot de passe de plus de 6 caractères</p>";
				}
			}
			else{
				echo "<br><p style='color:red'>Vous n'avez pas entré le bon mot de passe</p>";
			}			
		}?>
		</div>	
		<div>
			<p><form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
					Mot de passe actuel: <input type="password" name="actuelmdp" required><br>
					Nouveau mot de passe: <input type="password" name="nouveaumdp" required><br><br>
					<button type="submit" >Envoyer</button>
				</form>
				</p>
		</div></li>
			</ul>
			<br><br><br>
			<h2 style="text-align: center">Nom entreprise</h2>
			<?php
			$idu=$_SESSION["id_u"];
			$sql="SELECT nomEntreprise FROM utilisateurs WHERE id_u=$idu";
			$result=$con->query($sql);
			$ligne=mysqli_fetch_array($result);
			if ($ligne['nomEntreprise']==null || $ligne['nomEntreprise']=="") {
			?>
			<form method="post" action="">
				<br>Entrez le nom de votre entreprise<input type="text" name="entreprise" required >
				<button type="submit">Envoyer</button>
			</form>
		<?php
			}
			else{
				echo "<br><h2 style='text-align: center'>".$ligne['nomEntreprise']."</h2>";
			}

			?>

			</body>
			</html>
			<?php
		}
	if ($_SESSION["statut"]==3) {
		include("fonctions.php");
		$con=connect_sqli(); 
		$con->set_charset("utf8");
		

?>		<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Profil</title>
    <link rel="stylesheet" type="text/css" href="styleCss/accueil_site.css">

</head>
<body class="$title">
    <header class="$title">
    </header >
     <div class="nav-wrapper">
    <nav id="barre">
        <ul>
       <img src="images/logo.png" alt="logo japonais">
        <li><a href="pages_admin/clients.php">Clients</a></li>
        <li><a href="pages_admin/vendeurs.php" class="btn1">Vendeurs</a></li>
        <li><a href="pages_admin/stocks.php" class="btn1">Stocks</a></li>
        <li><a href="profils.php" class="btn1">Profil</a></li>
         <li><a href="deconnexion.php" class="btn1">Déconnexion</a></li>
       </ul>
        </nav>
    </div>
	
				<br><br><br>
				<ul style="text-align: center">
				<li style="font-size:20px; cursor: pointer;">
				<div id="hover-area">
			Changer le mot de passe
			<?php 
			if(isset($_POST["nouveaumdp"])){
			$idu=$_SESSION["id_u"];
			$mdpactuel=$_POST["actuelmdp"];
			$sql="SELECT * from utilisateurs where (mdpu='$mdpactuel' or mdpu=md5('$mdpactuel')) and id_u=$idu";
			$result=$con->query($sql);
			if(mysqli_num_rows($result)>0){
				$nouveaumdp=$_POST["nouveaumdp"];
				if (strlen($nouveaumdp)>=6){
					$sql="UPDATE utilisateurs SET mdpu=md5('$nouveaumdp') WHERE id_u=$idu";
					$con->query($sql);
					echo "<br><p style='color:green'>Le mot de passe a bien été changé</p>";
				}
				else{
					echo "<br><p style='color:red'>Entrez un mot de passe de plus de 6 caractères</p>";
				}
			}
			else{
				echo "<br><p style='color:red'>Vous n'avez pas entré le bon mot de passe</p>";
			}			
		}?>
		</div>	
		
			<p><form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
					Mot de passe actuel: <input type="password" name="actuelmdp" required><br>
					Nouveau mot de passe: <input type="password" name="nouveaumdp" required><br><br>
					<button type="submit" >Envoyer</button>
				</form>
				</p>
		</li>
			</ul>
<?php
	}

	}
else{
		header("location:index.php");
	}
	?>