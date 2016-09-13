
<?php

if(isset($_POST['element']) && isset($_POST['id']))
{
// On choisi la base de donne
    switch($_POST['element'])
		{
			case 1: define('DB_NAME', 'onecaste_rent');
			break;
			case 2: define('DB_NAME', 'onecaste_game');
			break;
			case 3: define('DB_NAME', 'onecaste_image');
			break;
		}
	//on choisi le bouton qui a éte selectionner   define('DB_USER', 'onecaste_media');
   define('DB_PASSWORD', 'wgpz27k@');
   define('DB_HOST', 'localhost');
   $connexion = mysql_connect( DB_HOST , DB_USER , DB_PASSWORD );
   //Selection de la table de donnée
   mysql_select_db( DB_NAME,$connexion);
   

	$ajout_unit="SELECT nb_vue,id_stat FROM statistiques WHERE id_stat='".$_POST['id']."'";
	$req_unit =  mysql_query( $ajout_unit );
	
while($verif_unit = mysql_fetch_array($req_unit))
{
	$unit = $verif_unit['nb_vue']+1;
	$maj = "UPDATE statistiques SET nb_vue='".$unit."' WHERE id_stat='".$_POST['id']."'";
	$req_maj = mysql_query($maj); 
}	
 }
?>
