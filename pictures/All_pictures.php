<?php
if(isset($_SESSION['user']))
{
	$login = $_SESSION['user'];
}
	$chaine=(strrpos($_SERVER['PHP_SELF'],'/')+1); 
   $cat=substr($_SERVER['PHP_SELF'],$chaine); 
   $base=rtrim($cat,'.php'); 
   
   define('DB_NAME', 'onecaste_image');   define('DB_USER', 'onecaste_media');
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
   
   //On compte le nombre d'elemnet par categorie.
   $count_cat = "SELECT COUNT(DISTINCT ID_element) AS id FROM descriptions ";
   $req_cat = mysql_query($count_cat,$rent_bd);
   $verif_cat = mysql_fetch_array($req_cat);
   
    //On determine le nombre de page
   //declaration de variable
   if(isset($_GET['page']))
   {
	 $ID_courant = $_GET['page'];
   }
   else
   {
	 $ID_courant=1;
   }
   
   if(isset($req_cat))
   {
      if($verif_cat['id'] >= 21)
	  {
		$nb_page = (ceil($verif_cat['id']/21))+1;
	  }
	  else
	  {
		$nb_page = 1;
	  }
   }
   else
   {
     $nb_page = 1;
   }
   if(empty($ID_courant))
   {
		$bas = $ID_courant-1;
		$haut = $ID_courant;
		$lim_bas = ($bas*21);
		$lim_haut = ($haut*21)-1;
   }
   else
   {
		$bas = 0;
		$haut = 1;
		$lim_bas = ( $bas*21);
		$lim_haut = ( $haut*21)-1;
   }

   //On selectionnetous les element par vues
   $cat_select = "SELECT a.ID_element,a.ID_categorie,a.ID_data,a.titre,a.date,b.ID_lien,b.lk_image,b.lk_fichier,c.id_stat,c.nb_vue,d.ID_compteur,d.vt_pos,d.vt_neg,e.theme,e.ID FROM descriptions AS a,lien AS b,statistiques AS c,compteur AS d,categories AS e WHERE a.ID_categorie=e.ID AND a.ID_element=b.ID_lien AND a.ID_element=c.id_stat AND a.ID_element=d.ID_compteur ORDER BY a.date DESC LIMIT ".$lim_bas.",".$lim_haut."";
   //On traite la requete de la categorie
   $req_select = mysql_query($cat_select,$rent_bd);
   
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
		$select_650 = "SELECT lien_promo FROM rent_760 WHERE ID='".$rand_650."'";
		$req_select_650 = mysql_query($select_650,$promo_bd);

	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel='stylesheet'  href='http://www.divertiz.com/csstag/principal.css' type='text/css' media='all' />
<link rel='stylesheet'  href='http://www.divertiz.com/csstag/contenu_video.css' type='text/css' media='all' />
<meta name="robots" content="index,follow,noarchive">
<meta name="keywords" content="drole,animaux,farce,top,images" />
<meta name="description" lang="fr" content="Une selection des meilleur videos et image du net,sans oublier les jeux videos,le blog et nos videos adultes." />
<link rel="canonical" href="http://www.divertiz.com/index.php" />
<link rel="shortcut icon" href="http://www.divertiz.com/img/img_main/favicon.ico">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="http://www.divertiz.com/scriptdv/menu_desk.js"></script>
<script type="text/javascript" src="http://www.divertiz.com/shared/media_sys.js"></script>
<title></title>
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

<body onload="videorandom(3);">
<div id="fb-root"></div>
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
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/index.php">All videos</a></li>
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
						<li class="left_top_annu"><a class="cat_video_sx"  href="http://www.divertiz.com/video/cuisine.php">Cuisine</a></li>
						<li class="left_top_annu"><a class="cat_video_sx"  href="http://www.divertiz.com/video/divers.php">Divers</a></li>
					  </ul>
					</div>
					</div>
					</div>
				</div>
					
				</li>
				<li class="puce_ss" onmouseover="showMenu(this);" onmouseout="hideMenu(this);" >
				<a class="lk_ss puce" href="http://www.divertiz.com/pictures/All_pictures.php">Images</a>
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
					  </ul>
					</div>
					<div class="image_two">
					  <ul class="float_imagine">
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/pictures/engine.php">Engine</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/pictures/cute-girls.php">Jolie filles</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/pictures/animaux.php">Animaux</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/pictures/paysage.php">Paysage</a></li>
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
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/games/All_games.php">Tous les jeux</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/games/top_vues.php">Les plus jouer</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/games/top_votes.php">Mieux notée</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/games/arcade.php">Arcade</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/games/action.php">Action</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/games/sport.php">Sport</a></li>
					  </ul>
					</div>
					<div class="Game_two">
					<ul class="float_gamer">
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/games/strategie.php">Stratégie</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/games/puzzle.php">Puzzle</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/games/course.php">Course</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/games/tir.php">Tir</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/games/memoires.php">Memoires</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/games/jeux-divers.php">Autre jeux</a></li>
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
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/shared/video_src.php">Video</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/shared/image_src.php">Image</a></li>

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
			<input type="hidden" name="db" value="2">
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
		<!-- Contenu de la categorie -->
		<div style="clear:both; height:10px;"></div>
	<div class="float_nav">
			<span class="txt_nav">Vous etes ici : </span>
			<span><a class="txt_li_nav" href="http://www.divertiz.com/index.php">accueil</a></span>
			<span class="txt_nav"> &rsaquo; </span>
			<span><a class="txt_li_pos" href="http://www.divertiz.com/pictures/All_pictures.php">Toutes les images</a></span>
			

			
	</div>
		<div class="titre_categorie"><h4 style="margin-top:0px; margin-bottom:0px;"><span style="text-transform : capitalize;">Toutes les videos</span></h4></div>
		<div  class="red_line"></div>
		<div class="pertinance">
		 <ul class="pertinancepos">
		<li class="cast_pert"><a class="connectpert lkpert" href="All_pictures.php">New videos</a></li>
		<li class="cast_pert"><a class="connectpert lkpert" href="top_votes.php">Meilleurs classement</a></li>
		<li class="cast_pert"><a class="connectpert lkpert" href="top_vues.php">Les plus consultés</a></li>
	</ul>
	
		</div>
		<div class="info_pertinace">Pertinance : <span style="color:rgb(192,8,13); letter-spacing:1px;">News videos</span></div>
			<div class="media_container">
			<ul class="box_caster">
			 <?php while($verif_select = mysql_fetch_array($req_select)) { ?>
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
							<span class="display black"><?php echo $verif_select['theme']; ?></span>
							<span class="capitale display">cat.</span>
						</div>
						<div class="img_vues txt_info ">
							<span class="display black"><?php echo number_format($verif_select['nb_vue'],0,',',','); ?></span>
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
			 <?php } ?>
			 
			</ul>

			</div>
			<div style="clear:both; height:1px;"></div>
			<div style="margin-bottom:5px;" class="red_line"></div>
			<div class="page_courant">Page <?php echo $ID_courant; ?></div>
<div class="nav_container" >
<ul style="padding:0px; margin:0px;">
<?php

$prev=$ID_courant-1;
$suiv=$ID_courant+1;
$ini = $ID_courant-3;
$upi = $ID_courant+3;
$fin = $ID_courant-4;
$debut = $ID_courant+4;

if($ID_courant == 1)
{
	echo '<li class="page_number_nav disabled float_left"><a>Debut&nbsp;</a></li>';
}
else
{
	echo '<li class="page_number_nav float_left"><a href=http://www.divertiz.com/pictures/'.$base.'.php?page=1>Debut&nbsp;</a></li>';
}

if($ID_courant == 1)
{
	echo '<li class="page_number_nav disabled float_left" style="margin-right:5px;"><a>Prec.&nbsp;</a></li>';
}
else
{
	echo '<li class="page_number_nav float_left" style="margin-right:5px;"><a href=http://www.divertiz.com/pictures/'.$base.'.php?page='.$prev.'>Prec.&nbsp;</a></li>';
}
/////////////////////////////////
if($ID_courant >= $nb_page-2)
{
  if($fin>0)
  {
	for($page_m=$fin;$page_m<=$ID_courant-1;$page_m++)
	{
	  echo '<li class="page_number float_left"><a href=http://www.divertiz.com/pictures/'.$base.'.php?page='.$page_m.'>'.$page_m.'</a></li>';
	}
  }
  else
  {
	for($page_m=1;$page_m<=$ID_courant-1;$page_m++)
		{
		  echo '<li class="page_number float_left"><a href=http://www.divertiz.com/pictures/'.$base.'.php?page='.$page_m.'>'.$page_m.'</a></li>';
		}
  }
}
else
{
	if($ini>0 && $ini>=3 )
	{
		for($page_m=$ini;$page_m<=$ID_courant-1;$page_m++)
		{
		  echo '<li class="page_number float_left"><a href=http://www.divertiz.com/pictures/'.$base.'.php?page='.$page_m.'>'.$page_m.'</a></li>';
		}
	}
	else if($ini>=(-1) || $ini>=0)
	{
		for($page_m=1;$page_m<=$ID_courant-1;$page_m++)
		{
		  echo '<li class="page_number float_left"><a href=http://www.divertiz.com/pictures/'.$base.'.php?page='.$page_m.'>'.$page_m.'</a></li>';
		}
	}
}
/////////////////////////////////////////
//current page
echo '<li class="page_number courant float_left"><a>'.$ID_courant.'</a></li>';

/////////////////////////////////////////
if($ID_courant <=3)
{
  if($debut<$nb_page)
  {
	for($page_p=$ID_courant+1;$page_p<=$debut;$page_p++)
	{
	  
	  echo '<li class="page_number float_left"><a href=http://www.divertiz.com/pictures/'.$base.'.php?page='.$page_p.'>'.$page_p.'</a></li>';
	}
  }
  else
  {
    for($page_p=$ID_courant+1;$page_p<=$nb_page;$page_p++)
		{
		  echo '<li class="page_number float_left"><a href=http://www.divertiz.com/pictures/'.$base.'.php?page='.$page_p.'>'.$page_p.'</a></li>';
		}
  }
}
else
{
	if($upi<=$nb_page && $upi<=$nb_page-2)
	{
		for($page_p=$ID_courant+1;$page_p<=$upi;$page_p++)
		{
		  echo '<li class="page_number float_left"><a href=http://www.divertiz.com/pictures/'.$base.'.php?page='.$page_p.'>'.$page_p.'</a></li>';
		}
		
	}
	else if($upi>$nb_page || $upi>=$nb_page-1)
	{
		for($page_p=$ID_courant+1;$page_p<=$nb_page;$page_p++)
		{
		  echo '<li class="page_number float_left"><a href=http://www.divertiz.com/pictures/'.$base.'.php?page='.$page_p.'>'.$page_p.'</a></li>';
		}
		
	}
}

//////////////////////////////////////

if($ID_courant == $nb_page)
{
	echo '<li class="page_number_nav disabled float_left" style="margin-left:5px;"><a>Suiv.&nbsp;</a></li>';
}
else
{
	echo '<li class="page_number_nav float_left" style="margin-left:5px;"><a href=http://www.divertiz.com/pictures/'.$base.'.php?page='.$suiv.'>Suiv.&nbsp;</a></li>';
}

if($ID_courant == $nb_page)
{
	echo '<li class="page_number_nav disabled float_left"><a>Fin&nbsp;</a></li>';
}
else
{
	echo '<li class="page_number_nav float_left"><a href=http://www.divertiz.com/pictures/'.$base.'.php?page='.$nb_page.'>Fin&nbsp;</a></li>';
}
?>
</ul>
</div>
		 <div class="pub_bottom">
		   <?php if(isset($default_650)) echo $default_650; ?>
	   <?php 
	   if(isset($rand_650))
	   {
		while(		$verif_select = mysql_fetch_array($req_select_650)) 
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
		<div class="like_reseau_sociaux">
		<!-- Reseaux sociaux -->
		<div class="titre_annexe">
		<h3 class="dis_titre">SUIVRE DIVERTIZ</h3>
		</div>
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

				</ul>
		</div>
		
	</div>
	<div style="clear:both; height:5px;"></div>
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