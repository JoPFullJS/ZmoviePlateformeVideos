<?php
if(isset($_SESSION['user']))
{
	$login = $_SESSION['user'];
}
	//On prend l'identifiant de la page
	$page = $_SERVER['PHP_SELF'];
	$nom = rtrim($page, '.php');
	$id = substr($nom,-9);
	
	//categorie
	$chaine=(strrpos($_SERVER['PHP_SELF'],'/')); 

	$cat=substr($_SERVER['PHP_SELF'],0,$chaine); 

	$chaine2=((strrpos($cat,'/'))+1); 

	$catego=substr($cat,$chaine2,$chaine);

   define('DB_NAME', 'onecaste_rent');   define('DB_USER', 'onecaste_media');
   define('DB_PASSWORD', 'wgpz27k@');
   define('DB_HOST', 'localhost');
   define('DB_PROMO','onecaste_promo_rent');
   //Connection des base de donnee
   $rent_bd = mysql_connect( DB_HOST , DB_USER , DB_PASSWORD );
   $promo_bd = mysql_connect( DB_HOST , DB_USER , DB_PASSWORD , TRUE);
  
   //Selection de la base de donnee
   mysql_select_db(DB_NAME,$rent_bd);
   mysql_select_db(DB_PROMO,$promo_bd);
   
    //partenaire
   $select_partenaires = "SELECT intitule_part FROM partenaires";
   $req_partenaires = mysql_query($select_partenaires,$rent_bd);
   
   //On selectionne les element de la categorie
   $video_select = "SELECT a.ID_element,a.titre,a.description,a.user,a.ID_data,a.duree,a.largeur,a.date,b.lk_image,b.lk_fichier,b.embed_video,b.format_video,b.ID_world,c.nb_vue,d.vt_pos,d.vt_neg FROM descriptions AS a,lien AS b,statistiques AS c,compteur AS d WHERE a.ID_element=b.ID_lien=c.id_stat=d.ID_compteur AND ID_element IN ('".$id."')";
   //On traite la requete de la categorie
   $req_video = mysql_query($video_select,$rent_bd);
   $verif_video = mysql_fetch_array($req_video);
   //On selectionne les 3 banniere
   //Banniere de 760 et plus
   $count_760 = "SELECT COUNT(DISTINCT ID) AS header FROM rent_760";
   $req_760 = mysql_query($count_760,$promo_bd);
   $verif_760 = mysql_fetch_array($req_760);
   if(isset($req_760))
    {
		if($verif_760['header']>0)
		{
			$rand_760 = rand(1,$verif_760['header']);
		}
		else
		{
			$default_760 = '<img src="http://www.divertiz.com/img/img_main/pub_728.jpg" alt="pub en attente" border="0">';
		}
	}
	if(isset($rand_760))
	{
		$select_760 = "SELECT lien_promo FROM rent_760 WHERE ID='".$rand_760."'";
		$req_select_760 = mysql_query($select_760,$promo_bd);
		
	}
	//Banniere de 350 et moins
   $count_350 = "SELECT COUNT(DISTINCT ID) AS header FROM rent_350";
   $req_350 = mysql_query($count_350,$promo_bd);
   $verif_350 = mysql_fetch_array($req_350);
   if(isset($req_350))
    {
		if($verif_350['header']>0)
		{
			$rand_350 = rand(1,$verif_350['header']);
		}
		else
		{
			$default_350 = '<img src="http://www.divertiz.com/img/img_main/pub_350.jpg" alt="pub en attente" border="0">';
		}
	}
	if(isset($rand_350))
	{
		$select_350 = "SELECT lien_promo FROM rent_760 WHERE ID='".$rand_350."'";
		$req_select_350 = mysql_query($select_350,$promo_bd);
		
	}
	//Banniere de 650 et moins
   $count_650 = "SELECT COUNT(DISTINCT ID) AS header FROM rent_650";
   $req_650 = mysql_query($count_650,$promo_bd);
   $verif_650 = mysql_fetch_array($req_650);
   if(isset($req_650))
    {
		if($verif_650['header']>0)
		{
			$rand_650 = rand(1,$verif_650['header']);
		}
		else
		{
			$default_650 = '<img src="http://www.divertiz.com/img/img_main/pub_650.jpg" alt="pub en attente" border="0">';
		}
	}
	if(isset($rand_650))
	{
		$select_650 = "SELECT lien_promo FROM rent_760 WHERE ID='".$rand_350."'";
		$req_select_650 = mysql_query($select_350,$promo_bd);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel='stylesheet'  href='../../http://www.divertiz.com/csstag/principal.css' type='text/css' media='all' />
<link rel='stylesheet'  href='../../../csstag/contenu_video.css' type='text/css' media='all' />
<meta property="og:site_name" content="VideoCaster.com" />
<meta property="og:title" content="The Rock"/>
<meta property="og:url" content="http://www.imdb.com/title/tt0117500/"/>
<meta property="og:image" content="http://ia.media-imdb.com/rock.jpg"/>
<meta property="og:description"  content="Un chien joue à attraper la balle avec sa maitresse."/>
<link rel="image_src" href="http://ia.media-imdb.com/rock.jpg" />
<meta name="robots" content="index,follow,noarchive">
<meta name="keywords" content="mot,cle" />
<meta name="description" lang="fr" content="description du contenu" />
<link rel="canonical" href="url" />
<link rel="shortcut icon" href="http://www.divertiz.com/img/img_main/favicon.ico">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="http://www.divertiz.com/scriptdv/menu_desk.js"></script>
<script type="text/javascript" src="../../../shared/media_sys.js"></script>
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

<body onload="videorandom(1);">
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/fr_FR/all.js#xfbml=1";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
<div class="wrap_main">
   <div class="header">
   <div class="header_width">
    <!-- Logo -->
   <span class="af_logo" onmouseover="showMenu(this);" onmouseout="hideMenu(this);" ><a href="http://www.divertiz.com/index.php" id="logo_type" ><img src="http://www.divertiz.com/img/img_main/divertiz.png" width="150" /></a>
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
  <!-- Moteur de recherche-->

   <!-- Statistique -->
	
   <!--menu sous categorie -->
   
   <div class="af_ss_cat">
   <div class="fd_ss_cat">
			<ul class="pos_ss">
				<li class="puce_ss" onmouseover="showMenu(this);" onmouseout="hideMenu(this);">
					<a class="lk_ss puce" href="http://www.divertiz.com/index.php">Videos</a>
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
				<a class="lk_ss " href="http://www.divertiz.com/games/All_games.php">Games</a>
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
				<a class="lk_ss" href="http://www.divertiz.com/shared/video_src.php">Proposez</a>
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
  <div class="ads_speed" style="margin-left:auto; margin-right:auto;">
  <!-- BEGIN ExoClick.com Ad Code -->
   <?php if(isset($default_760)) echo $default_760; ?>
   <?php 
   if(isset($rand_760))
   {
	while($verif_760 = mysql_fetch_array($req_select_760)) 
		{
			
			if(isset($verif_760['lien_promo'])) echo $verif_760['lien_promo'];
         }
	}
   ?>
   
<!-- END ExoClick.com Ad Code -->

  </div>
   <div class="main">
   <!-- contenu -->

	<div class="contenu_cat">

		<div class="liste_contenu">
		<div style="clear:both; height:10px;"></div>
	<div class="float_nav">
			<span class="txt_nav">Vous etes ici : </span>
			<span><a class="txt_li_nav" href="http://www.divertiz.com/index.php">accueil</a></span>
			<span class="txt_nav"> &rsaquo; </span>
			<span><a class="txt_li_nav" href="http://www.divertiz.com/index.php">videos rent</a></span>
			<span class="txt_nav"> &rsaquo; </span>
			<span><a class="txt_li_pos" href="http://www.divertiz.com/video/<?php echo $catego; ?>.php"><?php echo $catego; ?></a></span>
	</div>
		<!-- Contenu de la categorie -->
		<div class="titre_categorie"><h5 style="margin-top:0px; margin-bottom:0px;">Un titre pour ma video</h5></div>
		<div style="height:5px;"></div>
			<div class="video_embled" style="margin-left:auto; margin-right:auto; width:650px;" >
			<div><embed src="http://www.nokenny.com/player.swf" width="650" height="526" allowscriptaccess="always" allowfullscreen="true" type="application/x-shockwave-flash" flashvars="config=http://www.nokenny.com/v/voiture-vs-cables-electrique&autostart=0&displayclick=play"></embed><br /><a href="http://www.nokenny.com/voiture-vs-cables-electrique.phpl">Voiture VS Câbles électrique</a> - <a href="http://www.nokenny.com">NoKenny</a></div>
			</div>
			
			<div class="bar_info" style="margin-left:auto; margin-right:auto; width:640px;">
			<div class="green_vote float_left">
			 <a href="" onclick="return false" class="rate_green"><strong class="tex_rate">4</strong></a>
			</div>
			<div class="red_vote float_left">
			<a href="" onclick="return false" class="rate_red"><strong class="tex_rate">20</strong></a>
			</div>
			<div class="stat_vote float_left">
				<div class="positif_vote" style="width:90%;"></div>
				<div class="pourcentage">90%</div>
			</div>
			<div class="like_fbk float_left">
			<div id="fb-root"></div>

		<div class="fb-like" data-href="http://www.facebook.com/pages/Divertiz/428047647245563" data-send="false" data-layout="button_count" data-width="250" data-show-faces="false" data-font="arial"></div>
			</div>
			
				<div class="info_view" >
					<div class="user_view"><img src="../../../img/img_main/view_icon.png" height="25"/><span class="user_color2"><strong>2365 Vues</strong></span></div>
			</div>
			</div>
			<div class="titre_vod"><h4><a href="#">telecharger des milliers de films en hd !</a></h4></div>
			<div class="info_upload" style="margin-left:auto; margin-right:auto; width:630px; word-spacing:4px;">
			<span><strong>Posté le :  </strong> 21/25/2012 à 20:36</span>
			</div>
			<div class="description">
				<p>Le fichier audio ou vidéo est simplement proposé au téléchargement, de la même manière que tout autre type de fichier.<br/>Et c'est le navigateur qui se charge d'effectuer la lecture de la vidéo.<br/>Différentes techniques de sécurisation existent pour les contenus audios.</p>
			</div>
			<div class="reclame"style="margin-left:auto; margin-right:auto;">
			<?php if(isset($default_650)) echo $default_650; ?>
   <?php 
   if(isset($rand_650))
   {
	while($verif_650 = mysql_fetch_array($req_select_650)) 
		{
			
			if(isset($verif_650['lien_promo'])) echo $verif_650['lien_promo'];
         }
	}
   ?>
			</div>
			<div class="box_fb" style="margin-left:auto; margin-right:auto;" >
			<div class="fb-comments" data-href="http://www.divertiz.com/video/animaux/default_video_rent.php" data-num-posts="5" data-width="640"></div>
			</div>
			<div class="titre_categorie"><h4 style="margin-top:0px; margin-bottom:0px;">videos similaires</h4></div>
		<div  class="gris_line"></div>
			<div class="media_container">
			<ul class="box_caster">
			<!-- <?php while($verif_select = mysql_fetch_array($req_select)) { ?>
			 <li class="width_container float_left">
			 <div class="date_upload">
				<div class="txt_info">
				<span style="margin-left:12px;" class="capitale" >il y a</span>
				<span style="margin-left:12px;" class="black">
				<?php   
				$today = getdate();
				$date = $today[0];
				$ajout = strtotime($verif_select['date']);
				$dif = $date-$ajout;

				if($dif >0 && $dif <= 60)
				{
					$when = " un instant";
					echo $when;
				}
				else if($dif > 60 && $dif <= 3600)
				{
					$brain = $dif/60;
					$ago = round($brain,0);
					$when = $ago." minutes";
					echo $when;
				}
				else if($dif > 3600 && $dif <= 86400)
				{
					$brain = $dif/3600;
					$ago = round($brain,0);
					$when = $ago." heurs";
					echo $when;
				}
				else if($dif > 86400 && $dif <= 604800)
				{
					$brain = $dif/86400;
					$ago = round($brain,0);
					$when = $ago." jours";
					echo $when;
				}
				else if($dif > 604800 && $dif <= 2419200)
				{
					$brain = $dif/604800;
					$ago = round($brain,0);
					$when = $ago." semaines";
					echo $when;
				}
				else if($dif > 2419200 && $dif <= 29030400)
				{
					$brain = $dif/2419200;
					$ago = round($brain,0);
					$when = $ago." mois";
					echo $when;
				}
				else if($dif > 29030400 && $dif <= 145152000)
				{
					$brain = $dif/29030400;
					$ago = round($brain,0);
					$when = $ago." ans";
					echo $when;
				}
				else
				{
					$when = $ago." plus de 5 ans";
					echo $when;
				}
				?>
				</span>
				</div>
			 </div>
				<div class="img_container">
					<a href="<?php echo $verif_select['lk_fichier']; ?>" ><img src="<?php echo $verif_select['lk_image']; ?>" alt="<?php echo $verif_select['titre']; ?>" title="<?php echo $verif_select['titre']; ?>"/></a>
					<a class="titre_container" href="<?php echo $verif_select['lk_fichier']; ?>" ><?php echo htmlentities($verif_select['titre']); ?></a>
				</div>
					<div class="stat_video">
					    <div class="img_categorie txt_info ">
							<span class="display black"><?php echo $verif_select['duree']; ?></span>
							<span class="capitale display">duree</span>
						</div>
						<div class="img_vues txt_info ">
							<span class="display black"><?php echo $verif_select['nb_vue']; ?></span>
							<span class="capitale display">vues</span>
						</div>
						<div class="img_classement txt_info ">
							<span class="display 
			<?php if($verif_select['vt_pos']>$verif_select['vt_neg']) 
				{
					$res=($verif_select['vt_pos']*100)/($verif_select['vt_pos']+$verif_select['vt_neg']);
					$perct=round($res,0);
					$rate=$perct;
						echo " green";
						echo '">';
						echo $rate."%";
				} 
				else{
					$res=($verif_select['vt_pos']*100)/($verif_select['vt_pos']+$verif_select['vt_neg']);
					$perct=round($res,0);
					$rate=$perct;
					echo " red";
				    echo '">';
				    echo $rate."%";
				} ?>
							</span>
							<span class="capitale display">rating</span>
						</div>
					</div>
				
			 </li>
			 <?php } ?> -->

			 <li class="width_container float_left">
			 <div class="date_upload">
				<div class="txt_info">
				<span style="margin-left:12px;" class="capitale" >ajouter le :</span>
				<span style="margin-left:12px;" class="black">21/12/2012</span>
				</div>
			 </div>
				<div class="img_container">
					<a href="#"><img src="../../../img/img_main/img_menu.jpg" style=""/></a>
					<a class="titre_container" href="#">Titre de la video qui dechire sur videosCaster</a>
				</div>
					<div class="stat_video">
					    <div class="duree txt_info ">
							<span class="display black">06:12</span>
							<span class="capitale display">duree</span>
						</div>
						<div class="vues txt_info ">
							<span class="display black">25369</span>
							<span class="capitale display">vues</span>
						</div>
						<div class="classement txt_info ">
							<span class="display green">63%</span>
							<span class="capitale display">rating</span>
						</div>
					</div>
				
			 </li>
			 <li class="width_container float_left">
			 <div class="date_upload">
				<div class="txt_info">
				<span style="margin-left:12px;" class="capitale" >ajouter le :</span>
				<span style="margin-left:12px;" class="black">21/12/2012</span>
				</div>
			 </div>
				<div class="img_container">
					<a href="#"><img src="../../../img/img_main/img_menu.jpg" style=""/></a>
					<a class="titre_container" href="#">Titre de la video qui dechire sur videosCaster</a>
				</div>
					<div class="stat_video">
					    <div class="duree txt_info ">
							<span class="display black">06:12</span>
							<span class="capitale display">duree</span>
						</div>
						<div class="vues txt_info ">
							<span class="display black">25369</span>
							<span class="capitale display">vues</span>
						</div>
						<div class="classement txt_info ">
							<span class="display green">63%</span>
							<span class="capitale display">rating</span>
						</div>
					</div>
				
			 </li>
			 			 <li class="width_container float_left">
			 <div class="date_upload">
				<div class="txt_info">
				<span style="margin-left:12px;" class="capitale" >ajouter le :</span>
				<span style="margin-left:12px;" class="black">21/12/2012</span>
				</div>
			 </div>
				<div class="img_container">
					<a href="#"><img src="../../../img/img_main/img_menu.jpg" style=""/></a>
					<a class="titre_container" href="#">Titre de la video qui dechire sur videosCaster</a>
				</div>
					<div class="stat_video">
					    <div class="duree txt_info ">
							<span class="display black">06:12</span>
							<span class="capitale display">duree</span>
						</div>
						<div class="vues txt_info ">
							<span class="display black">25369</span>
							<span class="capitale display">vues</span>
						</div>
						<div class="classement txt_info ">
							<span class="display green">63%</span>
							<span class="capitale display">rating</span>
						</div>
					</div>
				
			 </li>
			 			 <li class="width_container float_left">
			 <div class="date_upload">
				<div class="txt_info">
				<span style="margin-left:12px;" class="capitale" >ajouter le :</span>
				<span style="margin-left:12px;" class="black">21/12/2012</span>
				</div>
			 </div>
				<div class="img_container">
					<a href="#"><img src="../../../img/img_main/img_menu.jpg" style=""/></a>
					<a class="titre_container" href="#">Titre de la video qui dechire sur videosCaster</a>
				</div>
					<div class="stat_video">
					    <div class="duree txt_info ">
							<span class="display black">06:12</span>
							<span class="capitale display">duree</span>
						</div>
						<div class="vues txt_info ">
							<span class="display black">25369</span>
							<span class="capitale display">vues</span>
						</div>
						<div class="classement txt_info ">
							<span class="display green">63%</span>
							<span class="capitale display">rating</span>
						</div>
					</div>
				
			 </li>
			 			 <li class="width_container float_left">
			 <div class="date_upload">
				<div class="txt_info">
				<span style="margin-left:12px;" class="capitale" >ajouter le :</span>
				<span style="margin-left:12px;" class="black">21/12/2012</span>
				</div>
			 </div>
				<div class="img_container">
					<a href="#"><img src="../../../img/img_main/img_menu.jpg" style=""/></a>
					<a class="titre_container" href="#">Titre de la video qui dechire sur videosCaster</a>
				</div>
					<div class="stat_video">
					    <div class="duree txt_info ">
							<span class="display black">06:12</span>
							<span class="capitale display">duree</span>
						</div>
						<div class="vues txt_info ">
							<span class="display black">25369</span>
							<span class="capitale display">vues</span>
						</div>
						<div class="classement txt_info ">
							<span class="display green">63%</span>
							<span class="capitale display">rating</span>
						</div>
					</div>
				
			 </li>
			 			 <li class="width_container float_left">
			 <div class="date_upload">
				<div class="txt_info">
				<span style="margin-left:12px;" class="capitale" >ajouter le :</span>
				<span style="margin-left:12px;" class="black">21/12/2012</span>
				</div>
			 </div>
				<div class="img_container">
					<a href="#"><img src="../../../img/img_main/img_menu.jpg" style=""/></a>
					<a class="titre_container" href="#">Titre de la video qui dechire sur videosCaster</a>
				</div>
					<div class="stat_video">
					    <div class="duree txt_info ">
							<span class="display black">06:12</span>
							<span class="capitale display">duree</span>
						</div>
						<div class="vues txt_info ">
							<span class="display black">25369</span>
							<span class="capitale display">vues</span>
						</div>
						<div class="classement txt_info ">
							<span class="display green">63%</span>
							<span class="capitale display">rating</span>
						</div>
					</div>
				
			 </li>
	
			</ul>

			</div>
			<div class="reclame" style="margin-left:auto; margin-right:auto;">
			<?php if(isset($default_650)) echo $default_650; ?>
   <?php 
   if(isset($rand_650))
   {
	while($verif_650 = mysql_fetch_array($req_select_650)) 
		{
			
			if(isset($verif_650['lien_promo'])) echo $verif_650['lien_promo'];
         }
	}
   ?>
			</div>
			<div style="clear:both; height:10px;"></div>
		</div>

	</div>
	<div class="zone_annexe">
	    <div class="prec_suiv" style="margin-top:5px;">
				<div class="prev-img float_left">
				<a href="#" class="display_block">
				<img src="http://cdn1.image.youporn.phncdn.com/201204/18/7722480/160x120/8.jpg" width="140" alt="Previous Picture">
				</a>
				<a class="display_block" href="#">Précédent</a>
				</div>
				
				<div class="prev-img float_right">
				<a href="#" class="display_block">
				<img src="http://cdn1.image.youporn.phncdn.com/201204/18/7722480/160x120/8.jpg" width="140" alt="Next Picture"></a>
				<a class="display_block" href="#">Suivant</a>
				</div>
				<div style="clear:both; height:2px;"></div>
			</div>
		<div class="like_reseau_sociaux">
		<!-- Reseaux sociaux -->
		<div class="titre_annexe">
		<h3 class="dis_titre">SUIVRE DIVERTIZ</h3>
		</div>
		<div style="clear:both; height:3px;"></div>
		<div class="fb-like" data-href="http://www.facebook.com/pages/Divertiz/428047647245563" data-send="true" data-layout="button_count" data-width="250" data-show-faces="false" data-font="arial"></div>
		</div>
		<div class="pub_anime">
		<!-- Publicité animée -->
		<?php if(isset($default_350)) echo $default_350; ?>
	   <?php 
	   if(isset($rand_350))
	   {
		while($verif_350 = mysql_fetch_array($req_select_350)) 
			{
				
				if(isset($verif_350['lien_promo'])) echo $verif_350['lien_promo'];
			 }
		}
	   ?>
		</div>
		<div class="listing_com">
		<!-- Listing catégorie pour videos -->
		<div class="titre_annexe">
		<h3 class="dis_titre">VIDEOS AU HASARD</h3>
		</div>
		<!--id="charger" -->
		 <ul id="charger" style="margin-left:0px; margin-right:0px; margin-bottom:0px; margin-top:10px; padding:0px">
		<li class="rand_container">
					<a href="animation"><img src="http://cdn1.image.youporn.phncdn.com/201204/18/7722480/160x120/8.jpg"></a>
					<a href="animation" class="titre_rand float_right" style="width:160px; display:block;">Ma premiere video poster des video qui dechire grave</a>
					<div class="stat_rand float_right">
						<div class="cat_rand txt_info">
						<span class="display black_rand">animaux</span>
						<span class="capitale_rand display">cat.</span>
						</div>
						<div class="vues_rand txt_info">
						<span class="display black_rand">1</span>
						<span class="capitale_rand display">vues</span>
						</div>
						<div class="class_rand txt_info">
						<span class="display
						 green">76%	</span>
						<span class="capitale_rand display">rating</span>
						</div>
					</div>
				
			</li>
			<li class="rand_container">
					<a href="animation"><img src="http://cdn1.image.youporn.phncdn.com/201204/18/7722480/160x120/8.jpg"></a>
					<a href="animation" class="titre_rand float_right" style="width:160px; display:block;">Ma premiere video poster des video qui dechire grave</a>
					<div class="stat_rand float_right">
						<div class="cat_rand txt_info">
						<span class="display black_rand">animaux</span>
						<span class="capitale_rand display">cat.</span>
						</div>
						<div class="vues_rand txt_info">
						<span class="display black_rand">1</span>
						<span class="capitale_rand display">vues</span>
						</div>
						<div class="class_rand txt_info">
						<span class="display
						 green">76%	</span>
						<span class="capitale_rand display">rating</span>
						</div>
					</div>
				
			</li>
			<li class="rand_container">
					<a href="animation"><img src="http://cdn1.image.youporn.phncdn.com/201204/18/7722480/160x120/8.jpg"></a>
					<a href="animation" class="titre_rand float_right" style="width:160px; display:block;">Ma premiere video poster des video qui dechire grave</a>
					<div class="stat_rand float_right">
						<div class="cat_rand txt_info">
						<span class="display black_rand">animaux</span>
						<span class="capitale_rand display">cat.</span>
						</div>
						<div class="vues_rand txt_info">
						<span class="display black_rand">1</span>
						<span class="capitale_rand display">vues</span>
						</div>
						<div class="class_rand txt_info">
						<span class="display
						 green">76%	</span>
						<span class="capitale_rand display">rating</span>
						</div>
					</div>
				
			</li>
			<li class="rand_container">
					<a href="animation"><img src="http://cdn1.image.youporn.phncdn.com/201204/18/7722480/160x120/8.jpg"></a>
					<a href="animation" class="titre_rand float_right" style="width:160px; display:block;">Ma premiere video poster des video qui dechire grave</a>
					<div class="stat_rand float_right">
						<div class="cat_rand txt_info">
						<span class="display black_rand">animaux</span>
						<span class="capitale_rand display">cat.</span>
						</div>
						<div class="vues_rand txt_info">
						<span class="display black_rand">1</span>
						<span class="capitale_rand display">vues</span>
						</div>
						<div class="class_rand txt_info">
						<span class="display
						 green">76%	</span>
						<span class="capitale_rand display">rating</span>
						</div>
					</div>
				
			</li>
			<li class="rand_container">
					<a href="animation"><img src="http://cdn1.image.youporn.phncdn.com/201204/18/7722480/160x120/8.jpg"></a>
					<a href="animation" class="titre_rand float_right" style="width:160px; display:block;">Ma premiere video poster des video qui dechire grave</a>
					<div class="stat_rand float_right">
						<div class="cat_rand txt_info">
						<span class="display black_rand">animaux</span>
						<span class="capitale_rand display">cat.</span>
						</div>
						<div class="vues_rand txt_info">
						<span class="display black_rand">1</span>
						<span class="capitale_rand display">vues</span>
						</div>
						<div class="class_rand txt_info">
						<span class="display
						 green">76%	</span>
						<span class="capitale_rand display">rating</span>
						</div>
					</div>
				
			</li>
				</ul>
		</div>
		
		<div style="clear:both; height:10px;"></div>
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