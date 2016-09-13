<?php
//if(isset($_SESSION['user']))
//{
	//$login = $_SESSION['user'];
//}

   
   $pdo = new PDO('mysql:host=localhost;dbname=divertz', 'root', ''); 
   
   //On compte le nombre d'element par categorie.
   $count_cat = "SELECT COUNT(DISTINCT ID_element) AS id FROM descriptions ";
   $req_cat = $pdo->query($count_cat);
   $verif_cat = $req_cat->fetch();
   
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
   $cat_select = "SELECT a.ID_element,a.ID_categorie,a.ID_data,a.titre,a.duree,a.date,b.ID_lien,b.lk_image,b.lk_fichier,c.id_stat,c.nb_vue,d.ID_compteur,d.vt_pos,d.vt_neg FROM descriptions AS a,lien AS b,statistiques AS c,compteur AS d WHERE a.ID_element=b.ID_lien AND a.ID_element=c.id_stat AND a.ID_element=d.ID_compteur ORDER BY a.date DESC LIMIT ".$lim_bas.",".$lim_haut."";
   //On traite la requete de la categorie
   $req_select = $pdo->query($cat_select);
   
   
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php
if($_SERVER['SERVER_NAME'] == "divertiz.com")
  {echo '<meta http-equiv="Refresh" content="0; URL="> ';}
  else
  {}
?>
<link rel='stylesheet'  href='csstag/principal.css' type='text/css' media='all' />
<link rel='stylesheet'  href='csstag/contenu_video.css' type='text/css' media='all' />
<meta name="robots" content="index,follow,noarchive">
<meta name="keywords" content="drole,animaux,farce,top,images" />
<meta name="description" lang="fr" content="Une selection des meilleur videos et image du net,sans oublier les jeux videos,le blog et nos videos adultes." />
<link rel="canonical" href="index.php" />
<link rel="shortcut icon" href="img/img_main/favicon.ico">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="scriptdv/menu_desk.js"></script>
<script type="text/javascript" src="shared/media_sys.js"></script>
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

<body onload="videorandom(1);">
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
   <span class="af_logo" onmouseover="showMenu(this);" onmouseout="hideMenu(this);" ><a href="index.php" id="logo_type" ><img src="img/img_main/divertiz.png" width="150" /></a>
   <div class="menu_down">
					<div class="menu_network">
						<div class="float_network">
					<div class="image_two">
					  <ul class="float_hub">
					    <li class="left_top_annu"><a class="cat_video_sx" href="index.php">Videos</a></li>
					    <li class="left_top_annu"><a class="cat_video_sx" href="pictures/All_pictures.php">Images</a></li>
					    <li class="left_top_annu"><a class="cat_video_sx" href="games/All_games.php">Games</a></li>
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
					<a class="lk_ss puce" href="index.php">Videos</a>
				<div class="menu_down">
				 <div class="menu_rest">
				  <div class="float_rest">
					<div class="categories_divers">
					  <ul class="float_rent">
						<li class="left_top_annu"><a class="cat_video_sx" href="index.php">All videos</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="video/top_vues.php">Top vues</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="video/top_votes.php">top votes</a></li>
					  </ul>
					</div>
					</div>
				 </div>
				</div>
				</li>
				<li class="puce_ss" onmouseover="showMenu(this);" onmouseout="hideMenu(this);">
					<a class="lk_ss" href="video/droles.php">Categories</a>
					
				<div class="menu_down">
				<div class="menu_vcat">
						<div class="float_vcat">
					<div class="Game_one">
					  <ul class="float_gamer">
						<li class="left_top_annu"><a class="cat_video_sx" href="video/autos.php">Autos</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="video/motos.php">Motos</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="video/engine.php">engine</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="video/droles.php">Drole</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="video/farces.php">Farces</a></li>
						<li class="left_top_annu"><a class="cat_video_sx"  href="video/music.php">Music/Dance</a></li>
						<li class="left_top_annu"><a class="cat_video_sx"  href="video/animaux.php">Animaux</a></li>
					  </ul>
					</div>
					<div class="Game_two">
					<ul class="float_gamer">
						<li class="left_top_annu"><a class="cat_video_sx"  href="video/animation.php">Animation</a></li>
						<li class="left_top_annu"><a class="cat_video_sx"  href="video/insolite.php">Insolite</a></li>
						<li class="left_top_annu"><a class="cat_video_sx"  href="video/nature.php">Nature</a></li>
						<li class="left_top_annu"><a class="cat_video_sx"  href="video/tutoriels.php">tutoriels</a></li>
						<li class="left_top_annu"><a class="cat_video_sx"  href="video/television.php">Television</a></li>
						<li class="left_top_annu"><a class="cat_video_sx"  href="video/cuisine.php">Cuisine</a></li>
						<li class="left_top_annu"><a class="cat_video_sx"  href="video/divers.php">Divers</a></li>
					  </ul>
					</div>
					</div>
					</div>
				</div>
					
				</li>
				<li class="puce_ss" onmouseover="showMenu(this);" onmouseout="hideMenu(this);" >
				<a class="lk_ss " href="pictures/All_pictures.php">Images</a>
					<div class="menu_down">
					<div class="menu_image">
						<div class="float_image">
					<div class="image_two">
					  <ul class="float_imagine">
					    <li class="left_top_annu"><a class="cat_video_sx" href="pictures/All_pictures.php">All pictures</a></li>
					    <li class="left_top_annu"><a class="cat_video_sx" href="pictures/top_vues.php">Top vues</a></li>
					    <li class="left_top_annu"><a class="cat_video_sx" href="pictures/top_votes.php">Top votes</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="pictures/droles.php">Drole</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="pictures/insolite.php">Insolite</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="pictures/memes.php">Memes</a></li>
					  </ul>
					</div>
					<div class="image_two">
					  <ul class="float_imagine">
						<li class="left_top_annu"><a class="cat_video_sx" href="pictures/engine.php">Engine</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="pictures/cute-girls.php">Jolie filles</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="pictures/animaux.php">Animaux</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="pictures/paysage.php">Paysage</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="pictures/generale.php">Generale</a></li>
					  </ul>
					</div>
					</div>
					</div>
				</div>
				</li>
				<li class="puce_ss" onmouseover="showMenu(this);" onmouseout="hideMenu(this);">
				<a class="lk_ss " href="games/All_games.php">Games</a>
				<div class="menu_down">
				<div class="menu_game">
						<div class="float_game">
					<div class="Game_one">
					  <ul class="float_gamer">
						<li class="left_top_annu"><a class="cat_video_sx" href="games/All_games.php">Tous les jeux</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="games/top_vues.php">Les plus jouer</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="games/top_votes.php">Mieux notée</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="games/arcade.php">Arcade</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="games/action.php">Action</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="games/sport.php">Sport</a></li>
					  </ul>
					</div>
					<div class="Game_two">
					<ul class="float_gamer">
						<li class="left_top_annu"><a class="cat_video_sx" href="games/strategie.php">Stratégie</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="games/puzzle.php">Puzzle</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="games/course.php">Course</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="games/tir.php">Tir</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="games/memoires.php">Memoires</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="games/jeux-divers.php">Autre jeux</a></li>
					  </ul>
					</div>
					</div>
					</div>
				</div>
				</li>
				<li class="puce_ss " onmouseover="showMenu(this);" onmouseout="hideMenu(this);">
				<a class="lk_ss" href="shared/video_src.php">Proposez</a>
					<div class="menu_down">
					<div class="menu_proposez">
						<div class="float_proposez">
						 <div class="categorie_blog">
					  <ul class="float_centre_blog">
						<li class="left_top_annu"><a class="cat_video_sx" href="shared/video_src.htm">Video</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="shared/image_src.php">Image</a></li>

					  </ul>
					  </div>
					  </div>
					</div>
				</div>
				</li>
			</ul>
			
		<div class="bb_search">
		<form id="form_caster" action="shared/search.php" method="get">
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
	<div class="float_nav">
			<span class="txt_nav">Vous etes ici : </span>
			<span><a class="txt_li_nav" href="index.php">accueil</a></span>
			<span class="txt_nav"> &rsaquo; </span>
			<span><a class="txt_li_pos" href="index.php">Toutes les videos</a></span>
			

			
	</div>
		<div class="titre_categorie"><h4 style="margin-top:0px; margin-bottom:0px;"><span style="text-transform : capitalize;">Toutes les videos</span></h4></div>
		<div  class="red_line"></div>
		<div class="pertinance">
		 <ul class="pertinancepos">
		<li class="cast_pert"><a class="connectpert lkpert" href="index.php">New videos</a></li>
		<li class="cast_pert"><a class="connectpert lkpert" href="video/top_votes.php">Meilleurs classement</a></li>
		<li class="cast_pert"><a class="connectpert lkpert" href="video/top_vues.php">Les plus consultés</a></li>
	</ul>
	
		</div>
		<div class="info_pertinace">Pertinance : <span style="color:rgb(192,8,13); letter-spacing:1px;">News videos</span></div>
			<div class="media_container">
			<ul class="box_caster">
			<?php while($verif_select = $req_select->fetch()) { ?>
			 <li class="width_container float_left">
			 <div class="date_upload">
				<div class="txt_info">
				<span style="margin-left:12px;" class="black">
				<?php   
				$date = $verif_select['date'];
				$date2 = substr($date,0,10);
				$jour = date('d', strtotime($date2));
				$njour = date('w', strtotime($date2));
				$year = date('Y', strtotime($date2));
				$nmois = date('m', strtotime($date2));

				switch ($njour) {
						case 1:
						$semaine = "Lun.";
						break;
						case 2:
						$semaine = "Mar.";
						break;
						case 3:
						$semaine = "Mer.";
						break;
						case 4:
						$semaine = "Jeu.";
						break;
						case 5:
						$semaine = "Ven.";
						break;
						case 6:
						$semaine = "Sam.";
						break;
						case 0:
						$semaine = "Dim.";
						break;
				}

				switch ($nmois) {
						case 1:
						$mois = "Jan.";
						break;
						case 2:
						$mois = "Fév.";
						break;
						case 3:
						$mois = "Mar.";
						break;
						case 4:
						$mois = "Avr.";
						break;
						case 5:
						$mois = "Mai.";
						break;
						case 6:
						$mois = "Juin.";
						break;
						case 7:
						$mois = "Juil.";
						break;
						case 8:
						$mois = "Aou.";
						break;
						case 9:
						$mois = "Sept.";
						break;
						case 10:
						$mois = "Oct.";
						break;
						case 11:
						$mois = "Nov.";
						break;
						case 12:
						$mois = "Dec.";
						break;
				}
				echo $semaine." ".$jour."  ".$mois." ".$year;
				?>
				</span>
				</div>
			 </div>
				<div class="img_container">
					<a href="<?php echo $verif_select['lk_fichier']; ?>" ><img src="<?php echo $verif_select['lk_image']; ?>" alt="<?php echo $verif_select['titre']; ?>" title="<?php echo $verif_select['titre']; ?>"/></a>
					<a class="titre_container" href="<?php echo $verif_select['lk_fichier']; ?>" ><?php echo htmlentities($verif_select['titre']); ?></a>
				</div>
					<div class="stat_video">
					    <div class="duree txt_info ">
							<span class="display black"><?php echo $verif_select['duree']; ?></span>
							<span class="capitale display">duree</span>
						</div>
						<div class="vues txt_info ">
							<span class="display black"><?php echo $vue = number_format($verif_select['nb_vue'],0,',',','); ?></span>
							<span class="capitale display">vues</span>
						</div>
						<div class="classement txt_info ">
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
	echo '<li class="page_number_nav float_left"><a href=video/'.$base.'.php?page=1>Debut&nbsp;</a></li>';
}

if($ID_courant == 1)
{
	echo '<li class="page_number_nav disabled float_left" style="margin-right:5px;"><a>Prec.&nbsp;</a></li>';
}
else
{
	echo '<li class="page_number_nav float_left" style="margin-right:5px;"><a href=video/'.$base.'.php?page='.$prev.'>Prec.&nbsp;</a></li>';
}
/////////////////////////////////
if($ID_courant >= $nb_page-2)
{
  if($fin>0)
  {
	for($page_m=$fin;$page_m<=$ID_courant-1;$page_m++)
	{
	  echo '<li class="page_number float_left"><a href=video/'.$base.'.php?page='.$page_m.'>'.$page_m.'</a></li>';
	}
  }
  else
  {
	for($page_m=1;$page_m<=$ID_courant-1;$page_m++)
		{
		  echo '<li class="page_number float_left"><a href=video/'.$base.'.php?page='.$page_m.'>'.$page_m.'</a></li>';
		}
  }
}
else
{
	if($ini>0 && $ini>=3 )
	{
		for($page_m=$ini;$page_m<=$ID_courant-1;$page_m++)
		{
		  echo '<li class="page_number float_left"><a href=video/'.$base.'.php?page='.$page_m.'>'.$page_m.'</a></li>';
		}
	}
	else if($ini>=(-1) || $ini>=0)
	{
		for($page_m=1;$page_m<=$ID_courant-1;$page_m++)
		{
		  echo '<li class="page_number float_left"><a href=video/'.$base.'.php?page='.$page_m.'>'.$page_m.'</a></li>';
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
	  
	  echo '<li class="page_number float_left"><a href=video/'.$base.'.php?page='.$page_p.'>'.$page_p.'</a></li>';
	}
  }
  else
  {
    for($page_p=$ID_courant+1;$page_p<=$nb_page;$page_p++)
		{
		  echo '<li class="page_number float_left"><a href=video/'.$base.'.php?page='.$page_p.'>'.$page_p.'</a></li>';
		}
  }
}
else
{
	if($upi<=$nb_page && $upi<=$nb_page-2)
	{
		for($page_p=$ID_courant+1;$page_p<=$upi;$page_p++)
		{
		  echo '<li class="page_number float_left"><a href=video/'.$base.'.php?page='.$page_p.'>'.$page_p.'</a></li>';
		}
		
	}
	else if($upi>$nb_page || $upi>=$nb_page-1)
	{
		for($page_p=$ID_courant+1;$page_p<=$nb_page;$page_p++)
		{
		  echo '<li class="page_number float_left"><a href=video/'.$base.'.php?page='.$page_p.'>'.$page_p.'</a></li>';
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
	echo '<li class="page_number_nav float_left" style="margin-left:5px;"><a href=video/'.$base.'.php?page='.$suiv.'>Suiv.&nbsp;</a></li>';
}

if($ID_courant == $nb_page)
{
	echo '<li class="page_number_nav disabled float_left"><a>Fin&nbsp;</a></li>';
}
else
{
	echo '<li class="page_number_nav float_left"><a href=video/'.$base.'.php?page='.$nb_page.'>Fin&nbsp;</a></li>';
}
?>
</ul>
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
					<li class=""><a class="" href=""><img src="img/img_main/divertiz.png" width="150" /></a></li>
					<li class=""><span> &copy; - divertiz.com 2011-2012</span></li>
				</ul>
			</div>
			<div class="float_blog_wik">
			<div class="title_copyright"><a class="lk_copyright" href="" onclick="return false;">Upload</a></div>
			<ul class="block_legal">
					<li class=""><a href="shared/video_src.php" class ="lk_footer">Soumettre une video</a></li>
					<li class=""><a href="shared/image_src.php" class ="lk_footer">Soumettre une image</a></li>
				</ul>
			</div>
			<div class="participate_more">
			<div class="title_copyright"><a class="lk_copyright" href="#">Partenaires Divertiz</a></div>
			<ul class="block_legal">
					<li class=""><a class="" href="http://www.gazzling.com/"><img src="img/img_main/gazzling.png" width="150" /></a></li>
				</ul>
			</div>
			
			</div>

	  </div>
	 </div>
</body>
</html>