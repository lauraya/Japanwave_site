<?php 
session_start();
include("fonctions.php");
if(!empty($_SESSION["shopping_cart"])) { //nombre de produits ds le cart
$compteproduit = count(array_keys($_SESSION["shopping_cart"]));}
else{
   $compteproduit = 0;
}
?>
<?=menu("Contacts",$compteproduit,"connexion")?>
 
    <form>
        <div class="contact">
        	<table>
        		<br><br>
        		<tr style="height:60px;"><h2>Où nous retrouver ?</h2></tr>
        		<tr>
        			<td><img src="images/telephone_icone.jpg" alt="icone telephone"></td>
        			<td><img src="images/email_icone.jpg" alt="icone mail"></td>
        			<td><img src="images/adresse_icon.jpg" alt="icone adresse"></td>
        		</tr>
        		<tr>
        			<td><h2>Téléphone</h2></td>
        			<td><h2>E-mail</h2></td>
        			<td><h2>Adresse</h2></td>
        		</tr>
        		<tr>
        			<td><br><h3>Japanwave</h3></td>
        			<td><br><h3>Japanwave</h3></td>
        			<td><br><h3>Japanwave</h3></td>
        		</tr>
        		<tr>
        			<td rowspan="2">01 ** ** ** **</td>
        			<td>*********@gmail.com</td>
        			<td rowspan="2"> 90 Rue de Tolbiac, 75013 Paris</td>
        		</tr>
        		<tr>

        			<td>*********@hotmail.com</td>

        		</tr>
        		<tr>
        		<td><br><h3>SAYAPHOMMY Laura</h3></td>
        		<td><br><h3>SAYAPHOMMY Laura</h3></td>
        		<td><br><h3>SAYAPHOMMY Laura</h3></td>
        		</tr>
        			<td>06 ** ** ** **</td>
        			<td>*********@gmail.com</td>
        			<td rowspan="2"> 90 Rue de Tolbiac, 75013 Paris</td>
        		</tr>
        		<tr>
        			<td>07 ** ** ** **</td>
        			<td>*********@hotmail.com</td>
        
        		</tr>
        		<tr>
        			<td><br><h3>ZHENG Florent</h3></td>
        			<td><br><h3>ZHENG Florent</h3></td>
        			<td><br><h3>ZHENG Florent</h3></td>
        		</tr>
        		<tr>
        			<td>06 ** ** ** **</td>
        			<td>*********@gmail.com</td>
        			<td rowspan="2"> 90 Rue de Tolbiac, 75013 Paris</td>
        		</tr>
        		<tr>
        			<td>07 ** ** ** **</td>
        			<td>*********@gmail.com</td>
        
        		</tr>
                <tr>
                    <td colspan="3" style="text-align: center;vertical-align: middle;height: 125px;"><p style="font-size:20px;"><strong>Venez nous suivre sur nos réseaux sociaux!</strong></p></td>
                </tr>
        		<tr>
        			<td><a href="#"><img src="images/instagram_logo.jpg" alt="icone instagram"></td></a>
        			<td><a href="#"><img src="images/twitter_icone.jpg" alt="icone twitter"></td></a>
        			<td><a href="#"><img src="images/facebook_icone.jpg" alt="icone facebook"></td></a>
        		</tr>
        		<tr>
        			<td><h2>Instagram</h2></td>
        			<td><h2>Twitter </h2></td>
        			<td><h2>Facebook </h2></td>
        		</tr>
        		<tr>
        			<td colspan="3"><br><br><br>Vous pouvez retrouver en exclusivité de nouveaux produits qui sortiront par la suite présentés sur instagram avec des partenariats exclusifs !<br>
        			Si vous voulez en savoir plus sur Japanwave et suivre le quotidien des productions et des envois et êtres informés en amont de toute information !<br>
        			Pour plus de questions, vous pouvez nous contacter en message privé via Facebook, nous répondrons le plus vite possible.</td>
        		</tr>
        	</table>
         </div>
      </form>
 

<?=footer()?>