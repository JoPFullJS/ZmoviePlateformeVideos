<?php
//session_start();
//if(!isset($_SESSION['user']))
	//{
	// header("Location:../rest/index.php");
	//}
//else
  //{
	if(isset($_POST['envoyer']))
	 {
		if(isset($_FILES['image']) && $_FILES['image']['error'] == 0)
		 {
			  $count_titre = strlen(htmlspecialchars($_POST['titre']));
				if($count_titre < 105 )
				{
					$count_description = strlen(htmlspecialchars($_POST['description']));
					$count_mot_cle = str_word_count($_POST['keyword']);
					if($count_description < 255 && $count_mot_cle < 8 )
					{
					   //define('DB_NAME', 'onecaste_rent');  
					   //define('DB_USER', 'onecaste_media');
					   //define('DB_PASSWORD', 'wgpz27k@');
					   //define('DB_HOST', 'localhost');
					   
					   //Connexion a la base de donnée
					   //$connexion   =   mysql_connect( DB_HOST , DB_USER , DB_PASSWORD );
					   //Selection de la table de donnée
					   
					   //mysql_select_db(DB_NAME,$connexion);
					   
					   $pdo = new PDO('mysql:host=localhost;dbname=divertz', 'root', ''); 
					   
					   $titre = htmlspecialchars($_POST['titre']);
					   $requete1 = "SELECT COUNT(DISTINCT titre) AS titre FROM  descriptions  WHERE  titre LIKE '%".$titre."%'";
					   $sql =  $pdo->query($requete1);
					   $titre_video = $sql->fetch();
					   
					   if($titre_video['titre']==0)
					   {
								switch($_POST['categorie'])
								{
									case 1: $dossier = "video/autos/";
									break;
									case 2: $dossier = "video/avion/";
									break;
									case 3: $dossier = "video/animation/";
									break;
									case 4: $dossier = "video/animaux/";
									break;
									case 5: $dossier = "video/droles/";
									break;
									case 6: $dossier = "video/insolite/";
									break;
									case 7: $dossier = "video/engine/";
									break;
									case 8: $dossier = "video/tutoriels/";
									break;
									case 9: $dossier = "video/music/";
									break;
									case 10: $dossier = "video/motos/";
									break;
									case 11: $dossier = "video/nature/";
									break;
									case 12: $dossier = "video/television/";
									break;
									case 13: $dossier = "video/divers/";
									break;
									
								}
								$id1 = substr(uniqid(rand(), true),-3);
								$id2 = substr(uniqid(rand(), true),-3);
								$id3 = substr(uniqid(rand(), true),-3);
								$id_video = $id1.$id2.$id3;
								//Normaliser le titre pour affichage
								$normalizeChars = array(
									'Á'=>'A', 'À'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Å'=>'A', 'Ä'=>'A', 'Æ'=>'AE', 'Ç'=>'C',
									'É'=>'E', 'È'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Í'=>'I', 'Ì'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ð'=>'Eth',
									'Ñ'=>'N', 'Ó'=>'O', 'Ò'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O',
									'Ú'=>'U', 'Ù'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y',
						   
									'á'=>'a', 'à'=>'a', 'â'=>'a', 'ã'=>'a', 'å'=>'a', 'ä'=>'a', 'æ'=>'ae', 'ç'=>'c',
									'é'=>'e', 'è'=>'e', 'ê'=>'e', 'ë'=>'e', 'í'=>'i', 'ì'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'eth',
									'ñ'=>'n', 'ó'=>'o', 'ò'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o',
									'ú'=>'u', 'ù'=>'u', 'û'=>'u', 'ü'=>'u', 'ý'=>'y',
								   
									'ß'=>'sz', 'þ'=>'thorn', 'ÿ'=>'y'
								); 
						       $fichier = strtr($_POST['titre'],$normalizeChars);
							   $nom_fichier = strtolower(preg_replace('/([^.a-z0-9]+)/i', '-', $fichier));
		                       $nom = rtrim($nom_fichier, '-');
							   $extension = ".php";
							   $dossier_image = "video/upload/";
							   $racine = $_SERVER['DOCUMENT_ROOT']."/jophasworks/";
							   $divertiz = "http://localhost/divertiz/";
							   $default = "default/default_video_rent.php";
							   $fichier_default = $racine.$default;
							   $fichier_dest = $racine.$dossier.$nom.'-'.$id_video.$extension;
							   $lk_fichier = $divertiz.$dossier.$nom.'-'.$id_video.$extension;
							   //les variable a inserer
							   $categorie = $_POST['categorie'];
							   $description = $_POST['description'];
							   $mot_cle = $_POST['keyword'];
							   $duree = $_POST['duree'];
							   $video = $_POST['embed'];
							   //On upload le fichier swf et image
							       $image = basename($_FILES['image']['name']);
								   $taille_maxi = 20000000;
								   $taille = filesize($_FILES['image']['tmp_name']);
								   $extensions_valides = array('jpg' , 'jpeg' , 'gif' , 'png');
										//1. strrchr renvoie l'extension avec le point (« . »).
										//2. substr(chaine,1) ignore le premier caractère de chaine.
										//3. strtolower met l'extension en minuscules.
									$extension_image = strtolower(  substr(  strrchr($image, '.')  ,1)  );
									 $fichier_image = $racine.$dossier_image.$nom.'-'.$id_video.'.'.$extension_image;
									 $image140 = $racine.$dossier_image.$nom.'-'.$id_video.'_140x90.'.$extension_image;
									 $image120 = $racine.$dossier_image.$nom.'-'.$id_video.'_120x83.'.$extension_image;
									 $lk_image = $divertiz.$dossier_image.$nom.'-'.$id_video.'.'.$extension_image;
									if (in_array($extension_image,$extensions_valides) ) 
									{
										$dommage = "Extension correcte";
									}
									if($taille>$taille_maxi)
										{
											$erreur = 'Le fichier est trop gros...';
										}
									if(isset($dommage) && !isset($erreur) ) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
									{
										 move_uploaded_file($_FILES['image']['tmp_name'], $fichier_image);
										 move_uploaded_file($_FILES['image140']['tmp_name'], $image140);
										 move_uploaded_file($_FILES['image120']['tmp_name'], $image120);
									}
									if(function_exists('move_uploaded_file'))
									{ 	
			
										//$description_video = "INSERT INTO descriptions AS a,lien AS b,compteur AS c,statitiques AS d SET a.ID_element='".$id_video."',a.ID_categorie='".$categorie."',a.duree='".$duree."',a.titre='".$titre."',a.description='".$description."',a.keyword='".$mot_cle."',b.ID_lien='".$id_video."',b.embed_video='".$video."',b.lk_fichier='".$fichier_dest."',b.lk_image='".$fichier_image."',c.ID_compteur='".$id_video."',d.id_stat='".$id_video."'";
										
										$description = "INSERT INTO descriptions SET ID_element='".$id_video."',ID_categorie='".$categorie."',duree='".$duree."',titre='".$titre."',description='".$description."',keyword='".$mot_cle."'";
										$verif_descrption = $pdo->query($description);
										
										$lien = "INSERT INTO lien SET ID_lien='".$id_video."',embed_video='".$video."',lk_fichier='".$lk_fichier."',lk_image='".$lk_image."'";
										$verif_lien = $pdo->query($lien);
										
										$compteur = "INSERT INTO compteur SET ID_compteur='".$id_video."'";
										$verif_compteur = $pdo->query($compteur);
										
										$stat = "INSERT INTO statistiques SET id_stat='".$id_video."'";
										$verif_stat = $pdo->query($stat);
										
										if(isset($verif_descrption))
											{
												copy($fichier_default,$fichier_dest);
												$reusit = "copie du fichier effectue avec success !";
												mysql_close();
											}
									}
					}
					else
						{
						  $erreur_titre2 ="Le titre de votre video est deja dans la base.";
						}
					
				}
				else
					{
					 $erreur_desk ="Verifirez tous les champ,Ils doivent être tous remplie pour valider votre contenu.";
					}
			}
			else
				{
				  $erreur_titre ="Le titre de votre video est trop long.";
				}
		}
	 }
 // }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel='stylesheet'  href='../csstag/principal.css' type='text/css' media='all' />
<link rel='stylesheet'  href='../csstag/contenu_video.css' type='text/css' media='all' />
<link rel='stylesheet'  href='../csstag/upload.css' type='text/css' media='all' />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="../scriptdv/menu_desk.js"></script>
<script type="text/javascript" src="../shared/lenght.js"></script>
<title>Videos droles,sexy,images insolite,les blogs,business affiliation - VideosCaster</title>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36262769-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>

<body>
 <div class="wrap_main">
   <div class="header">
   <div class="header_width">
    <!-- Logo -->
   <span class="af_logo" onmouseover="showMenu(this);" onmouseout="hideMenu(this);" ><a href="http://www.divertiz.com/index.php" id="logo_type" ><img src="../img/img_main/divertiz.png" width="150" /></a>
   <div class="menu_down">
					<div class="menu_network">
						<div class="float_network">
					<div class="image_two">
					  <ul class="float_hub">
					    <li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/index.php">Videos</a></li>
					    <li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/pictures/All_pictures.php">Images</a></li>
					    <li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/games/All_games.php">Games</a></li>
					  </ul>
					</div>
					</div>
					</div>
				</div>
   </span>
   
   <div class="af_ss_cat">
   <div class="fd_ss_cat">
			<ul class="pos_ss">
				<li class="puce_ss" onmouseover="showMenu(this);" onmouseout="hideMenu(this);">
					<a class="lk_ss" href="http://www.divertiz.com/index.php">Videos</a>
				<div class="menu_down">
				 <div class="menu_rest">
				  <div class="float_rest">
					<div class="categories_divers">
					  <ul class="float_rent">
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/video/videos.php">All videos</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/video/top_vues.php">Top vues</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/video/top_votes.php">top votes</a></li>
					  </ul>
					</div>
					</div>
				 </div>
				</div>
				</li>
				<li class="puce_ss" onmouseover="showMenu(this);" onmouseout="hideMenu(this);">
					<a class="lk_ss" href="http://www.divertiz.com/video/droles.php">Categories</a>
					
				<div class="menu_down">
				<div class="menu_vcat">
						<div class="float_vcat">
					<div class="Game_one">
					  <ul class="float_gamer">
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/video/autos.php">Autos</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/video/motos.php">Motos</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/video/engine.php">engine</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/video/droles.php">Drole</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/video/farces.php">Farces</a></li>
						<li class="left_top_annu"><a class="cat_video_sx"  href="http://www.divertiz.com/video/music.php">Music/Dance</a></li>
						<li class="left_top_annu"><a class="cat_video_sx"  href="http://www.divertiz.com/video/animaux.php">Animaux</a></li>
					  </ul>
					</div>
					<div class="Game_two">
					<ul class="float_gamer">
						<li class="left_top_annu"><a class="cat_video_sx"  href="http://www.divertiz.com/video/animation.php">Animation</a></li>
						<li class="left_top_annu"><a class="cat_video_sx"  href="http://www.divertiz.com/video/insolite.php">Insolite</a></li>
						<li class="left_top_annu"><a class="cat_video_sx"  href="http://www.divertiz.com/video/nature.php">Nature</a></li>
						<li class="left_top_annu"><a class="cat_video_sx"  href="http://www.divertiz.com/video/tutoriels.php">tutoriels</a></li>
						<li class="left_top_annu"><a class="cat_video_sx"  href="http://www.divertiz.com/video/television.php">Television</a></li>
						<li class="left_top_annu"><a class="cat_video_sx"  href="http://www.divertiz.com/video/music.php">Divers</a></li>
					  </ul>
					</div>
					</div>
					</div>
				</div>
					
				</li>
				<li class="puce_ss" onmouseover="showMenu(this);" onmouseout="hideMenu(this);" >
				<a class="lk_ss " href="http://www.divertiz.com/pictures/All_pictures.php">Images</a>
					<div class="menu_down">
					<div class="menu_image">
						<div class="float_image">
					<div class="image_two">
					  <ul class="float_imagine">
					    <li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/pictures/All_pictures.php">All pictures</a></li>
					    <li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/pictures/top_vues.php">Top vues</a></li>
					    <li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/pictures/top_votes.php">Top votes</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/pictures/droles.php">Drole</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/pictures/insolite.php">Insolite</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/pictures/memes.php">Memes</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/pictures/engine.php">Engine</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/pictures/jolie_filles.php">Jolie filles</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/pictures/animaux.php">Animaux</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/pictures/generale.php">Paysage</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/pictures/generale.php">Generale</a></li>
					  </ul>
					</div>
					</div>
					</div>
				</div>
				</li>
				<li class="puce_ss" onmouseover="showMenu(this);" onmouseout="hideMenu(this);">
				<a class="lk_ss " href="http://www.divertiz.com/games/games.php">Games</a>
				<div class="menu_down">
				<div class="menu_game">
						<div class="float_game">
					<div class="Game_one">
					  <ul class="float_gamer">
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/games/games.php">Tous les jeux</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/games/top_vues.php">Les plus jouer</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/games/top_votes.php">Mieux notée</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/games/arcade.php">Arcade</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/games/action.php">Action</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/games/sport.php">Sport</a></li>
					  </ul>
					</div>
					<div class="Game_two">
					<ul class="float_gamer">
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/games/stratégie.php">Stratégie</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/games/puzzle.php">Puzzle</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/games/course.php">Course</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/games/tir.php">Tir</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/games/memoires.php">Memoires</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/games/jeux_divers.php">Autre jeux</a></li>
					  </ul>
					</div>
					</div>
					</div>
				</div>
				</li>
				<li class="puce_ss " onmouseover="showMenu(this);" onmouseout="hideMenu(this);">
				<a class="lk_ss puce" href="http://www.divertiz.com/blog/cuisine/cuisine.php">Proposez</a>
					<div class="menu_down">
					<div class="menu_proposez">
						<div class="float_proposez">
						 <div class="categorie_blog">
					  <ul class="float_centre_blog">
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/blog/people/people.php">Video</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/blog/autos/autos.php">Image</a></li>

					  </ul>
					  </div>
					  </div>
					</div>
				</div>
				</li>
			</ul>
			
		<div class="bb_search">
		<form id="form_caster" action="http://www.divertiz.com/shared/search.php" method="get">
			<input class="input_text" id="q" type="text" name="q" value="Recherche"  onfocus="if(this.value=='Recherche')this.value='';" onblur="if(this.value=='') this.value='Recherche';" />
			<input type="hidden" name="db" value="1">
			<input class="button"  type="submit" width="30" value="" />
			
		</form>
	</div>

	</div>
   </div>

	
	</div>
   </div>
   <div class="main_layer_width">
   <div class="main">
   <!-- contenu -->

	<div class="contenu_cat">

		<div class="liste_contenu">
		<!-- Contenu de la categorie -->
		<div style="clear:both; height:10px;"></div>
		<div class="titre_categorie"><h4 style="margin-top:0px; margin-bottom:0px;"><span>Proposer une video rent</span></h4></div>
		<div style="clear:both; height:5px;"></div>
		<div  class="red_line"></div>
		<div style="clear:both; height:5px;"></div>
		<div style="clear:both; height:15px;">
		<?php
		  if(isset($erreur)) echo $erreur;
		  if(isset($erreur_desk)) echo $erreur_desk;
		  if(isset($erreur_titre)) echo $erreur_titre;
		  if(isset($erreur_titre2)) echo $erreur_titre2;
		?>
		</div>
			<div class="float_upload">
				<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
				<div class="desk_video">
					<div class="float_pprz ch_url">
					<span class="txt_url_img">Titre de la video :</span><span class="mes_titre">(0 mots | 100 Caracteres restant)</span><br />
					<textarea class="url_img titre" name="titre" cols="120" rows="2" ></textarea> <br/><br />
					<span class="txt_url_img">Duree de la video :</span><br />
					<textarea class="url_img" name="duree" cols="20" rows="1" ></textarea> <br/><br />
					<span class="txt_url_img">Thumb de la video(160x110px) :</span> <br />			
					<input type="hidden" name="MAX_FILE_SIZE" value="10000000">
					<input  class="url_img" type="file" name="image"  /> <br />
					<span class="txt_url_img">Thumb de la video(140x90px) :</span> <br />			
					<input type="hidden" name="MAX_FILE_SIZE" value="10000000">
					<input  class="url_img" type="file" name="image140"  /> <br />
					<span class="txt_url_img">Thumb de la video(120x83px) :</span> <br />			
					<input type="hidden" name="MAX_FILE_SIZE" value="10000000">
					<input  class="url_img" type="file" name="image120"  /> <br />
					<span class="txt_url_img">Embled de la video :</span><br />
					<textarea class="url_img" name="embed" cols="120" rows="3" ></textarea> <br /><br />
					<span class="txt_url_img">Description :</span><span class="mes_desk">(0 mots | 250 Caracteres restant)</span>  <br />
					<textarea id="desk_img" name="description" cols="120" rows="3" ></textarea> <br /><br />
					<label class="txt_url_img">Keyword :</label><span class="mes_tag">(0 mots | 6 mots restant)</span><br /><input id="tag" type="text" name="keyword" />
					
					</div>
				</div>
				<div class="categories_up">
				<div class="float_pprz ch_lab">
						<ul>
						<li class="txt_url_img">Selectionner la categories qui reflète votre contenu :</li>
						<li class="radio_lab">
							<div class="float_pprz align_lab">
								<input type="radio" name="categorie" id="droles" value="1" /> <label class="lab_cat">Auto</label><br />
								<input type="radio" name="categorie" id="droles" value="2" /> <label class="lab_cat">farces</label><br />
								<input type="radio" name="categorie" id="droles" value="3" /> <label class="lab_cat">Animation</label><br />
								<input type="radio" name="categorie" id="droles" value="4" /> <label class="lab_cat">Animaux</label><br />
							</div>
							<div class="float_pprz align_lab">
								<input type="radio" name="categorie" id="droles" value="5" /> <label class="lab_cat">Drole</label><br />
								<input type="radio" name="categorie" id="droles" value="6" /> <label class="lab_cat">insolite</label><br />
								<input type="radio" name="categorie" id="droles" value="7" /> <label class="lab_cat">engine</label><br />
								<input type="radio" name="categorie" id="droles" value="8" /> <label class="lab_cat">Tuto</label><br />
							</div>
							<div class="float_pprz align_lab">
								<input type="radio" name="categorie" id="droles" value="9" /> <label class="lab_cat">Music/Dance</label><br />
								<input type="radio" name="categorie" id="droles" value="10" /> <label class="lab_cat">Moto</label><br />
								<input type="radio" name="categorie" id="droles" value="11" /> <label class="lab_cat">Nature</label><br />
								<input type="radio" name="categorie" id="droles" value="12" /> <label class="lab_cat">television</label><br />
							</div>
							<div class="float_pprz align_lab">
								
								
								<input type="radio" name="categorie" id="droles" value="13" /> <label class="lab_cat">Divers</label><br />
							</div>
						</li>
						</ul>
					</div>

					
				</div>
				<div><input class="sub_rn" type="submit" name="envoyer" value="Soumettre" /></div>
				</form>
				
			</div>
			<div style="clear:both; height:80px;"></div>
			</div>
	</div>
   <div class="zone_annexe">
		<div class="">
		<!-- Publicité animée -->
		</div>
		<div class="">
		<!-- Zone pour nos partenaires -->
		</div>
		<div class="">
		<!-- Zone de connection et reseaux social -->
		</div>
		
	</div>
	<div style="clear:both; height:10px;"></div>
	</div>
   </div>
 <!-- Fin wrap -->
 </div>
<div class="statslive"><!-- http://livestats.fr - Outils de mesure d'audience en temps réel -->
<script type="text/javascript" src="http://livestats.fr/counter.php?u=divertiz"></script>
<a href="http://livestats.fr/"><img src="http://livestats.fr/vertical.php?username=divertiz" width="32" height="105" border="0" style="position: fixed; bottom: 50%; z-index:8777; float:left; left:0;"></a> <!-- Fin --></div>
	 <div class="footer_one_idea">
	 <!-- footer -->
	  <div class="linge_cast"></div>
	  <div class="grunge_footer">
	    	<div class="float_zone_footer">
			<div class="float_copyright">
				<div class="title_copyright"><a class="lk_copyright" href="#"></a></div>
				<ul class="block_media">
					<li class=""><a class="" href="http://www.divertiz.com/"><img src="http://www.divertiz.com/img/img_main/divertiz.png" width="150" /></a></li>
					<li class=""><span> &copy; - divertiz.com 2011-2012</span></li>
				</ul>
			</div>
			<div class="float_blog_wik">
			<div class="title_copyright"><a class="lk_copyright" href="" onclick="return false;">Upload</a></div>
			<ul class="block_legal">
					<li class=""><a href="http://www.divertiz.com/shared/video_src.php" class ="lk_footer">Soumettre une video</a></li>
					<li class=""><a href="http://www.divertiz.com/shared/image_src.php" class ="lk_footer">Soumettre une image</a></li>
				</ul>
			</div>
			<div class="participate_more">
			<div class="title_copyright"><a class="lk_copyright" href="#">Partenaires Divertiz</a></div>
			<ul class="block_legal">
					<li class=""><a class="" href="http://www.gazzling.com/"><img src="http://www.divertiz.com/img/img_main/gazzling.png" width="150" /></a></li>
				</ul>
			</div>
			
			</div>

	  </div>
	 </div>
<?php mysql_close($rent_bd); 
	  mysql_close($promo_bd);
?>
</body>
</html>