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

include("fonctions.php");
$con=connect_sqli(); 
$con->set_charset("utf8");
if(!empty($_SESSION["shopping_cart"])) { //nombre de produits ds le cart
$compteproduit = count(array_keys($_SESSION["shopping_cart"]));}
else{
   $compteproduit = 0;
}

$req="SELECT pseudo,mdpu FROM utilisateurs";
$resforeq=$con->query($req);
$listepseudo=array();
while($ligne = $resforeq->fetch_assoc()){ //On va chercher les pseudos sous forme de tableau
  $listepseudo[]=$ligne; 
}
$pseudos=array();
$mdp=array();
foreach($listepseudo as $element){
    $pseudos[]=$element['pseudo'];
    $mdp[]=$element['mdpu'];
//On va se servir de ces tableau dans le code javascript
    //Pour faciliter l'ajout des tableau en javascript on stocke les pseudos et mpd dans des tableau 1D
//Les pseudos auront le même index que leur mot de passe
}


  ?>

<?=menu("Connexion",$compteproduit,"connexion")?>()

<?php 
if($_SERVER['REQUEST_METHOD']== "POST")
{
  $pseudo=trim($_POST['identifiant']);//On ne veut pas que les espaces a droites ou a gauche soient comptés
  $mdp=$_POST['password'];
  $mdp2=md5($mdp);
  if(!empty($pseudo) && !empty($mdp)){
    $sql="SELECT * FROM utilisateurs where pseudo='$pseudo' and (mdpu='$mdp' or mdpu='$mdp2' )";
    $result=mysqli_query($con,$sql);
    $count=mysqli_num_rows($result);
    $data=mysqli_fetch_assoc($result);

  }
  if ($count==1){ //si on trouve une ligne qui correspond a la requête

    $_SESSION['id_u']=$data['id_u'];  //correspond a la clé primaire de la table utilisateurs (un nombre autoincrement)
    $_SESSION['pseudo']=$data['pseudo'];
    $_SESSION["statut"]=$data['statut'];
     if ($_SESSION["statut"]==1){
    header("location: pages_client/index_client.php");
  }

  else if ($_SESSION["statut"]==2){
    header("location: page_vendeur.php");
  } 

  else if ($_SESSION["statut"]==3){
     header("location: pages_admin/page_admin.php");
  }



  }
  else{
    echo "<h2 style='background-color:black;color:white'>Vous n'avez pas entré le bon mot de passe</h2>";
  }



}


?>
    <div class="hauteur"></div>
    
      <form action="" method="post" class="login-form">
        <h2>Connectez-vous</h2>

        <div class="txtb">
          <input type="text" placeholder="Identifiant" name="identifiant" id="identifiant" required="required">
          <span id="identifiant_manquant"></span>
        </div>
        <div class="txtb" style="margin-top: 30px">
          <input type="password" placeholder="Mot de passe" name="password" id="password" required="required">
          <span id="mdp_manquant"></span> 
        </div>
        <div class="password">
          <h6><a href="mdpoublié.php">Mot de passe oublié ?</a></h6>
        </div>
        <div class="submit">
          <button type="submit" class="logbtn" id='bouton_envoi'>Valider</button>  
       </div>
    <div class="bottom-text">
          Vous n'avez pas de compte ?<br><br> <a href="inscription.php">Inscrivez-vous</a>
        </div>

      </form>
<script type="text/javascript">
var pseudos=<?php echo json_encode($pseudos);?>;
pseudos=pseudos.map(pseudo=>pseudo.toLowerCase());
var mdpu=<?php echo json_encode($mdp);?>;
var validation = document.getElementById('bouton_envoi');
var identifiant = document.getElementById('identifiant');
var identifiant_m = document.getElementById('identifiant_manquant');
var password = document.getElementById('password');
var mdp_m = document.getElementById('mdp_manquant');
validation.addEventListener('click', f_valid);

function f_valid(e){
  if (identifiant.validity.valueMissing){
    e.preventDefault();
    identifiant_m.textContent = 'Entrez un identifiant';
    identifiant_m.style.color = 'red';
  
  }
  else if (!pseudos.includes(identifiant.value.trim().toLowerCase())){ //On ne veut pas que les espaces a droites ou a gauche soient comptés
    e.preventDefault();
    identifiant_m.textContent = 'Identifiant invalide';
    identifiant_m.style.color = 'red';
  }
  else{
    identifiant_m.textContent = '';
  }
  if (password.validity.valueMissing){
    e.preventDefault();
    mdp_m.textContent = 'Entrez un mot de passe';
    mdp_m.style.color = 'red';
  
  }
  else{
    mdp_m.textContent = '';
  }

  if (pseudos.includes(identifiant.value.toLowerCase())) {
     
      var index=pseudos.indexOf(identifiant.value.toLowerCase());
             //Cette variable va permettre de matcher le pseudo à son mdp, car le pseudo a le mm index que son mdp
    
     if((password.value!==mdpu[index]) && md5(password.value)!==mdpu[index]){
        alert(alt[index]);
       //La bd est composée de mdp non cryptés et d'autres cryptés donc on regarde pr les deux

        e.preventDefault();
        mdp_m.textContent = "Mot de passe erroné";
        mdp_m.style.color = 'red';
    }
    else{
      mdp_m.textContent = 'same password';
    }

  }
}
  </script>

<?=footer()?>