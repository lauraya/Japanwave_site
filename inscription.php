<?php
session_start();
if(isset($_SESSION['id_u']) and isset($_SESSION["statut"])){ //On empêche l'accès à la page aux utilisateurs connectés
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

include("fonctions.php");
$con=connect_sqli(); 
$con->set_charset("utf8");
if(!empty($_SESSION["shopping_cart"])) { //nombre de produits ds le cart
$compteproduit = count(array_keys($_SESSION["shopping_cart"]));}
else{
   $compteproduit = 0;
}
$req="SELECT pseudo,mailu FROM utilisateurs";
$resforeq=$con->query($req);
$listepseudo=array();
while($ligne = $resforeq->fetch_assoc()){ //On va chercher les pseudos sous forme de tableau
	$listepseudo[]=$ligne; 
}
$pseudos=array();
$mails=array();
foreach($listepseudo as $element){
		$pseudos[]=$element["pseudo"];
		$mails[]=$element["mailu"]; //On va se servir de ces tableau dans le code javascript
		//Pour faciliter l'ajout des tableau en javascript on stocke les pseudos et mail dans des tableau 1D
}

  ?>


<?=menu("Inscription",$compteproduit,"connexion")?>
<?php 
$pseudo=$mdp=$mail=$nom=$prenom=$date="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	//Vérifications des données insérées côté serveur
    if (!empty(trim($_POST["identifiant"]))){ //l'identifiant correspond au pseudo de l'utilisateur
        $temp=$_POST["identifiant"];
        $reqpseudo="SELECT * FROM utilisateurs where pseudo='$temp'"; //On récupère le pseudo correspondant
        $resforpseudo=$con->query($reqpseudo);
        if ($resforpseudo->num_rows==0) { //On vérifie que le pseudo n'est pas déjà présent dans la base de données
            if((!empty(trim($_POST['password']))) and (strlen($_POST["password"])>=6)){
                if((!empty(trim($_POST['mail'])))&&(preg_match("/[a-z0-9_\-\.]+@[a-z0-9_\-\.]+\.[a-z]+/i", $_POST['mail']))){
                    if ((!empty(trim($_POST['nom']))) and (preg_match("/^[a-zA-Z]+$/", $_POST['nom']))){
                        if ((!empty(trim($_POST['prenom']))) and (preg_match("/^[a-zA-Z]+$/", $_POST['prenom']))){
            
                                $pseudo=trim($_POST["identifiant"]);//On ne veut pas que le pseudo soit enregistré avec des espaces
                                //a gauche et a droite
                                $mdp=$_POST['password'];
                                $mail=$_POST['mail'];
                                $nom=$_POST['nom'];
                                $prenom=$_POST['prenom'];
                                $statut=1;
                                $sql="insert into utilisateurs(pseudo,mdpu,mailu,nomu,prenom,statut) values ('$pseudo',md5('$mdp'),'$mail','$nom','$prenom','$statut')";//md5 a été ajouté a postériori, donc dans la bd il y a des mdp encryptés d'autres non
                                mysqli_query($con,$sql);
                                header("location: connexion.php");
                                die;
                        }
                    }

            }
        }
  }
}
} 
?>

    <div class="hauteur"></div>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="login-form" style="height: 850px; top: 700px;">
		<h1>Inscription</h1>
		<div class="txtb">
        	<input type="text" placeholder="Identifiant" name="identifiant" id="identifiant"  required="required">
        	<span id="identifiant_manquant"></span>
        </div>
        <div class="txtb" style="margin-top: 30px">
        	<input type="password" placeholder="Mot de passe" name="password" id="password" required="required">
        	<span id="mdp_manquant"></span>
        </div>
         <div class="txtb">
          <input type="text" placeholder="Adresse e-mail" name="mail" id="mail" required="required">
          <span id="mail_manquant"></span>
        </div>
        <div class="txtb">
          <input type="text" placeholder="Nom" name="nom"  id="nom" required="required">
          <span id="nom_manquant"></span>
        </div>
        <div class="txtb">
          <input type="text" placeholder="Prénom" name="prenom" id="prenom" required="required">
          <span id="prenom_manquant"></span>
        </div>

      	<div class="submit">
       		<button type="submit" class="logbtn" id='bouton_envoi'>Valider </button>
   	   </div>




        <div class="bottom-text">
          Vous avez déjà un compte ?<br><br> <a href="connexion.php">Connectez vous</a>
        </div>	


   </form>

<script>
//Vérification des données insérées côté client
var pseudos=<?php echo json_encode($pseudos);?>; //Convertit le tableau php en javascript
pseudos=pseudos.map(pseudo=>pseudo.toLowerCase()); //On convertit tous les éléments du tableau en minuscule

var validation = document.getElementById('bouton_envoi');
var identifiant = document.getElementById('identifiant');
var identifiant_m = document.getElementById('identifiant_manquant');
var password = document.getElementById('password');
var mdp_m = document.getElementById('mdp_manquant');
var nom = document.getElementById('nom');
var nom_m = document.getElementById('nom_manquant');
var prenom = document.getElementById('prenom');
var prenom_m = document.getElementById('prenom_manquant');
validation.addEventListener('click', f_valid);
function f_valid(e){
	if (identifiant.validity.valueMissing){
		e.preventDefault();
		identifiant_m.textContent = 'Entrez un identifiant valide';
		identifiant_m.style.color = 'red';

	}

	else if (pseudos.includes(identifiant.value.trim().toLowerCase())){
		e.preventDefault();
		identifiant_m.textContent = 'Identifiant déjà existant';
		identifiant_m.style.color = 'red';
	}
	else{
		identifiant_m.textContent = '';
	}
	if (password.validity.valueMissing){
		e.preventDefault();
		mdp_m.textContent = 'Entrez un mot de passe valide';
		mdp_m.style.color = 'red';
	
	}
	else if ((password.value.length<6)){
		e.preventDefault();
		mdp_m.textContent = 'Entrez un mot de passe de plus de 6 caractères';
		mdp_m.style.color = 'red';
	
	}
	else{
		mdp_m.textContent = '';
	}
	if ((nom.validity.valueMissing)||(/^[a-zA-Z]+$/. test(nom.value)==false)){
		e.preventDefault();
		nom_m.textContent = 'Entrez un nom valide';
		nom_m.style.color = 'red';
	}
		else{
		nom_m.textContent = '';
	}
	if ((prenom.validity.valueMissing)||(/^[a-zA-Z]+$/. test(prenom.value)==false)){
		e.preventDefault();
		prenom_m.textContent = 'Entrez un prénom valide';
		prenom_m.style.color = 'red';
	}
	else{
		prenom_m.textContent = '';
	}
}

var mails= <?php echo json_encode($mails);?>;
mails=mails.map(mailu=>mailu.toLowerCase());
var email = document.getElementById("mail");
var email_m = document.getElementById('mail_manquant');
var email_v = /[a-z0-9_\-\.]+@[a-z0-9_\-\.]+\.[a-z]+/i;
validation.addEventListener('click', mail);

function mail(e){
	if (email.validity.valueMissing){
		e.preventDefault();
		email_m.textContent = 'Entrez une adresse mail valide';
		email_m.style.color = 'red';
	}

	else if (email_v.test(email.value)==false) {
		e.preventDefault();
		email_m.textContent = 'Entrez un format valide';
		email_m.style.color = 'red';

	}


	else if(mails.includes(email.value.toLowerCase())){
		e.preventDefault();
		email_m.textContent = 'Adresse déjà existante';
		email_m.style.color = 'red';

	}
	else{
		email_m.textContent = '';
	}
}</script>
  <?=footer()?>