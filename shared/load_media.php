<?php

if(isset($_POST['element']))
{
// On choisi la base de donne
    //switch($_POST['element'])
		//{
			//case 1: define('DB_NAME', 'onecaste_rent');
			//break;
			//case 2: define('DB_NAME', 'onecaste_game');
			//break;
			//case 3: define('DB_NAME', 'onecaste_image');
			//break;
		//}   define('DB_USER', 'onecaste_media');
   //define('DB_PASSWORD', 'wgpz27k@');
   //define('DB_HOST', 'localhost');
   //$connexion   =   mysql_connect( DB_HOST , DB_USER , DB_PASSWORD );
   //Selection de la table de donnée
   //mysql_select_db(DB_NAME,$connexion);
   
   $pdo = new PDO('mysql:host=localhost;dbname=divertz', 'root', '');
   
   //On determine le nombre d'element dans la table
   //$count_media="SELECT COUNT(DISTINCT ID) AS media FROM  descriptions";
   $count_media="SELECT COUNT(DISTINCT id_stat) AS media FROM  statistiques";
   $req_media =  $pdo->query($count_media);
   while($verif_media = $req_media->fetch())
   {
	   $number = $verif_media['media'];
	   $echantillon = 8;
	   $random = array();
	   for($i=0;$i<$echantillon;$i++)
		{
		 array_push($random,rand(1,$number));
		}
	}
   //on selection les element
   $select_media = "SELECT a.ID_element,e.theme,a.ID,a.titre,a.date,b.ID_lien,b.lk_image,b.lk_fichier,c.id_stat,c.nb_vue,d.ID_compteur,d.vt_pos,d.vt_neg FROM descriptions AS a,lien AS b,statistiques AS c,compteur AS d,categories AS e WHERE a.ID_element=b.ID_lien AND a.ID_element=c.id_stat AND a.ID_element=d.ID_compteur AND e.ID=a.ID_categorie AND a.ID IN ('".$random[0]."','".$random[1]."','".$random[2]."','".$random[3]."','".$random[4]."','".$random[5]."','".$random[6]."','".$random[7]."')";
   //$select_media = "SELECT id_stat,nb_vue FROM statistiques AS c WHERE  id_stat IN ('".$random[0]."','".$random[1]."','".$random[2]."','".$random[3]."','".$random[4]."','".$random[5]."','".$random[6]."','".$random[7]."','".$random[8]."','".$random[9]."')";
   $req_select_media =  $pdo->query($select_media);
   while($verif_select_media = $req_select_media->fetch())
   { 
   ?>

		<li class="rand_container">
					<a href="<?php echo $verif_select_media['lk_fichier']; ?>"><img src="<?php echo $verif_select_media['lk_image']; ?>"/></a>
					<a href="<?php echo $verif_select_media['lk_fichier']; ?>" class="titre_rand float_right" style="width:160px; display:block;"><?php echo htmlentities($verif_select_media['titre']); ?></a>
					<div class="stat_rand float_right">
						<div class="cat_rand txt_info">
						<span class="display black_rand"><?php echo htmlentities($verif_select_media['theme']); ?></span>
						<span class="capitale_rand display">cat.</span>
						</div>
						<div class="vues_rand txt_info">
						<span class="display black_rand"><?php echo $verif_select_media['nb_vue']; ?></span>
						<span class="capitale_rand display">vues</span>
						</div>
						<div class="class_rand txt_info">
						<span class="display
						<?php if($verif_select_media['vt_pos']>$verif_select_media['vt_neg']) 
				{
					$res=($verif_select_media['vt_pos']*100)/($verif_select_media['vt_pos']+$verif_select_media['vt_neg']);
					$perct=round($res,0);
					$rate=$perct;
						echo " green";
						echo '">';
						echo $rate."%";
				} 
				else{
					$res=($verif_select_media['vt_neg']*100)/($verif_select_media['vt_pos']+$verif_select_media['vt_neg']);
					$perct=round($res,0);
					$rate=$perct;
					echo " red";
				    echo '">';
				    echo $rate."%";
				} ?>
						</span>
						<span class="capitale_rand display">rating</span>
						</div>
					</div>
				
			</li>

<?php	
   }
 }
?>