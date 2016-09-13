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
	
	//choix de la categorie
   switch ($catego) {
    case "autos":
        $categorie = 1;
        break;
    case "farces":
        $categorie = 2;
        break;
	case "animation":
        $categorie = 3;
        break;
	case "animaux":
        $categorie = 4;
        break;
	case "droles":
        $categorie = 5;
        break;
	case "insolite":
        $categorie = 6;
        break;
	case "engine":
        $categorie = 7;
        break;
	case "tutoriels":
        $categorie = 8;
        break;
	case "music":
        $categorie = 9;
        break;
	case "motos":
        $categorie = 10;
        break;
	case "nature":
        $categorie = 11;
        break;
	case "television":
        $categorie = 12;
        break;
	case "divers":
        $categorie = 13;
        break;
	case "cuisine":
        $categorie = 14;
        break;
	case "sciences":
        $categorie = 15;
        break;
   }

   define('DB_NAME', 'onecaste_rent'); 
   define('DB_USER', 'onecaste_media');
   define('DB_PASSWORD', 'wgpz27k@');
   define('DB_HOST', 'localhost');
   define('DB_PROMO','onecaste_promo_rent');
   //Connection des base de donnee
   $rent_bd = mysql_connect( DB_HOST , DB_USER , DB_PASSWORD );
   $promo_bd = mysql_connect( DB_HOST , DB_USER , DB_PASSWORD , TRUE);
  
   //Selection de la base de donnee
   mysql_select_db(DB_NAME,$rent_bd);
   mysql_select_db(DB_PROMO,$promo_bd);
   /////////////////////////////visite de la page/////////////////
   $ajout_unit="SELECT nb_vue,id_stat FROM statistiques WHERE id_stat='".$id."'";
   $req_unit =  mysql_query($ajout_unit,$rent_bd);
	
	while($verif_unit = mysql_fetch_array($req_unit))
	{
		$unit = $verif_unit['nb_vue']+1;
		$maj = "UPDATE statistiques SET nb_vue='".$unit."' WHERE id_stat='".$id."'";
		$req_maj = mysql_query($maj,$rent_bd); 
	}	
   //select keyword
   $select_keyword = "SELECT keyword FROM descriptions WHERE ID_element IN ('".$id."')";
   $req_keyword = mysql_query($select_keyword,$rent_bd);
   $verif_keyword = mysql_fetch_array($req_keyword);
   //On extrait les mot pour un requete
   $mot = $verif_keyword['keyword'];
   $keyword=explode(',',$mot);
	$compteur=count($keyword);
	$search ="";
	$first ="";
	  for($i=0;$i<$compteur;$i++)
		{
		  if($i == 0)
		  {
			$first ="a.keyword LIKE '%".$keyword[0]."%' ";
		  }
		  else
		  {
			$search .="OR a.keyword LIKE '%".$keyword[$i]."%' ";
		  }
		}
	$req_search=$first.$search;
	//Selection des contenu similaire
	$select_similaire = "SELECT a.ID_element,a.ID_categorie,a.ID_data,a.titre,a.duree,a.date,a.keyword,b.ID_lien,b.lk_image,b.lk_fichier,c.id_stat,c.nb_vue,d.ID_compteur,d.vt_pos,d.vt_neg FROM descriptions AS a,lien AS b,statistiques AS c,compteur AS d WHERE a.ID_element=b.ID_lien AND a.ID_element=c.id_stat AND a.ID_element=d.ID_compteur AND (".$req_search.") AND a.ID_element NOT IN ('".$id."') LIMIT 6";
	$req_similaire = mysql_query($select_similaire,$rent_bd);

    //partenaire
   $select_partenaires = "SELECT intitule_part FROM partenaires";
   $req_partenaires = mysql_query($select_partenaires,$rent_bd);
   
   //On selectionne les element de la categorie
   $video_select = "SELECT a.ID_element,a.ID,a.ID_categorie,a.titre,a.description,a.ID_data,a.date,a.keyword,b.lk_image,b.lk_fichier,b.embed_video,c.id_stat,c.nb_vue,d.ID_compteur,d.vt_pos,d.vt_neg FROM descriptions AS a,lien AS b,statistiques AS c,compteur AS d WHERE a.ID_categorie='".$categorie."' AND a.ID_element=b.ID_lien AND a.ID_element=c.id_stat AND a.ID_element=d.ID_compteur AND ID_element IN ('".$id."')";
   //On traite la requete de la categorie
   $req_video = mysql_query($video_select,$rent_bd);
   $verif_video = mysql_fetch_array($req_video);
   //---------------------------------------------------------------------------------------------------------------------------------//
   //Contenu suivant et precedent////////////////////////////////////////////////
   $select_id = "SELECT COUNT(DISTINCT ID) AS id FROM descriptions";
   $req_id = mysql_query($select_id,$rent_bd);
   $verif_id = mysql_fetch_array($req_id);
   $nb_id = $verif_id['id'];
   $id_courant = $verif_video['ID'];
   //--------------------------------------------------------------------------------------------------------
   //Pour toutes les videos
		//  page suivante  ------------------------//
		if($id_courant == $nb_id)
		{
			//On prend un ID au hasard
			//$id1 = round(($nb_id*0.2),0);
			//$id2 = round(($nb_id*0.8),0);
			//$id_sui = rand($id1,$id2);
			//On selectionne l'image suivante
			$select_sui ="SELECT a.ID,a.ID_element,a.ID_data,a.titre,c.id_stat,c.nb_vue,d.ID_compteur,d.vt_pos,d.vt_neg,b.lk_image,b.lk_fichier FROM descriptions AS a,lien AS b,statistiques AS c,compteur AS d WHERE a.ID_element=b.ID_lien AND a.ID_element=c.id_stat AND a.ID_element=d.ID_compteur AND a.ID=1 LIMIT 1";
			$req_sui = mysql_query($select_sui,$rent_bd);
			$verif_sui = mysql_fetch_array($req_sui);
		}
		else
		{
			$select_sui ="SELECT a.ID,a.ID_element,a.ID_data,a.titre,c.id_stat,c.nb_vue,d.ID_compteur,d.vt_pos,d.vt_neg,b.lk_image,b.lk_fichier FROM descriptions AS a,lien AS b,statistiques AS c,compteur AS d WHERE a.ID_element=b.ID_lien AND a.ID_element=c.id_stat AND a.ID_element=d.ID_compteur AND ID>'".$id_courant."' ORDER BY a.ID ASC LIMIT 1";
			$req_sui = mysql_query($select_sui,$rent_bd);
			$verif_sui = mysql_fetch_array($req_sui);
		}
		//  Page precedente   ---------------------//
		if($id_courant == 1)
		{
			//On prend un ID au hasard
			//$id1 = round(($nb_id*0.2),0);
			//$id2 = round(($nb_id*0.8),0);
			//$id_pre = rand($id1,$id2);
			//On selectionne l'image suivante
			$select_pre ="SELECT a.ID,a.ID_element,a.ID_data,a.titre,c.id_stat,c.nb_vue,d.ID_compteur,d.vt_pos,d.vt_neg,b.lk_image,b.lk_fichier FROM descriptions AS a,lien AS b,statistiques AS c,compteur AS d WHERE a.ID_element=b.ID_lien AND a.ID_element=c.id_stat AND a.ID_element=d.ID_compteur AND a.ID='".$nb_id."' LIMIT 1";
			$req_pre = mysql_query($select_pre,$rent_bd);
			$verif_pre = mysql_fetch_array($req_pre);
		}
		else
		{
			$select_pre ="SELECT a.ID,a.ID_element,a.ID_data,a.titre,c.id_stat,c.nb_vue,d.ID_compteur,d.vt_pos,d.vt_neg,b.lk_image,b.lk_fichier FROM descriptions AS a,lien AS b,statistiques AS c,compteur AS d WHERE a.ID_element=b.ID_lien AND a.ID_element=c.id_stat AND a.ID_element=d.ID_compteur AND a.ID<'".$id_courant."' ORDER BY a.ID DESC LIMIT 1";
			$req_pre = mysql_query($select_pre,$rent_bd);
			$verif_pre = mysql_fetch_array($req_pre);
		}
		
   //-----------------------------------------------------------------------------------------------------
   //Pour les videos par categorie
   $select_theme = "SELECT COUNT(DISTINCT ID) AS theme FROM categories";
   $req_theme = mysql_query($select_theme,$rent_bd);
   $verif_theme = mysql_fetch_array($req_theme);
   $nb_theme = $verif_theme['theme'];
   $cat_courant = $verif_video['ID_categorie'];
		//  Page suivant  ---------------------------//
		if($cat_courant == $nb_theme)
		{
			$select_count_cat = "SELECT ID_categorie,COUNT(DISTINCT ID) AS id FROM descriptions WHERE ID_categorie='".$nb_theme."' AND ID>'".$id_courant."'";
			$req_count_cat = mysql_query($select_count_cat,$rent_bd);
			$verif_count_cat = mysql_fetch_array($req_count_cat);
			
			if($verif_count_cat['id'] == 0)
			{
			  $id_cat_courant = 1;
			  
			  $select_cat_sui = "SELECT a.ID,a.ID_element,a.ID_categorie,a.ID_data,a.titre,c.id_stat,c.nb_vue,d.ID_compteur,d.vt_pos,d.vt_neg,b.lk_image,b.lk_fichier FROM descriptions AS a,lien AS b,statistiques AS c,compteur AS d WHERE a.ID_element=b.ID_lien AND a.ID_element=c.id_stat AND a.ID_element=d.ID_compteur AND a.ID_categorie='".$id_cat_courant."' ORDER BY a.ID ASC LIMIT 1";
			  $req_cat_sui = mysql_query($select_cat_sui,$rent_bd);
			  $verif_cat_sui = mysql_fetch_array($req_cat_sui);
			}
			else
			{
			  $select_cat_sui = "SELECT a.ID,a.ID_element,a.ID_categorie,a.ID_data,a.titre,c.id_stat,c.nb_vue,d.ID_compteur,d.vt_pos,d.vt_neg,b.lk_image,b.lk_fichier FROM descriptions AS a,lien AS b,statistiques AS c,compteur AS d WHERE a.ID_element=b.ID_lien AND a.ID_element=c.id_stat AND a.ID_element=d.ID_compteur AND a.ID_categorie='".$cat_courant."' AND a.ID>'".$id_courant."' ORDER BY a.ID ASC LIMIT 1";
			  $req_cat_sui = mysql_query($select_cat_sui,$rent_bd);
			  $verif_cat_sui = mysql_fetch_array($req_cat_sui);
			}
		}
		else
		{
			$select_count_cat = "SELECT ID_categorie,COUNT(DISTINCT ID) AS id FROM descriptions WHERE ID_categorie='".$cat_courant."' AND ID>'".$id_courant."'";
			$req_count_cat = mysql_query($select_count_cat,$rent_bd);
			$verif_count_cat = mysql_fetch_array($req_count_cat);
			
			if($verif_count_cat['id'] == 0)
			{
			  $id_cat_sui = $cat_courant+1;
			  
			  $select_cat_sui = "SELECT a.ID,a.ID_element,a.ID_categorie,a.ID_data,a.titre,c.id_stat,c.nb_vue,d.ID_compteur,d.vt_pos,d.vt_neg,b.lk_image,b.lk_fichier FROM descriptions AS a,lien AS b,statistiques AS c,compteur AS d WHERE a.ID_element=b.ID_lien AND a.ID_element=c.id_stat AND a.ID_element=d.ID_compteur AND a.ID_categorie='".$id_cat_sui."' ORDER BY a.ID ASC LIMIT 1";
			  $req_cat_sui = mysql_query($select_cat_sui,$rent_bd);
			  $verif_cat_sui = mysql_fetch_array($req_cat_sui);
			}
			else
			{
			  $select_cat_sui = "SELECT a.ID,a.ID_element,a.ID_categorie,a.ID_data,a.titre,c.id_stat,c.nb_vue,d.ID_compteur,d.vt_pos,d.vt_neg,b.lk_image,b.lk_fichier FROM descriptions AS a,lien AS b,statistiques AS c,compteur AS d WHERE a.ID_element=b.ID_lien AND a.ID_element=c.id_stat AND a.ID_element=d.ID_compteur AND a.ID_categorie='".$cat_courant."' AND a.ID>'".$id_courant."' ORDER BY a.ID ASC LIMIT 1";
			  $req_cat_sui = mysql_query($select_cat_sui,$rent_bd);
			  $verif_cat_sui = mysql_fetch_array($req_cat_sui);
			}
		}
		//  Page precedente  ------------------------------------------------//
		if($cat_courant == 1)
		{
			$select_count_cat2 = "SELECT ID_categorie,COUNT(DISTINCT ID) AS id FROM descriptions WHERE ID_categorie='1' AND ID<'".$id_courant."'";
			$req_count_cat2 = mysql_query($select_count_cat2,$rent_bd);
			$verif_count_cat2 = mysql_fetch_array($req_count_cat2);
			
			if($verif_count_cat2['id'] == 0)
			{
				$id_cat_courant2 = $nb_theme;
				
				$select_cat_pre = "SELECT a.ID,a.ID_element,a.ID_categorie,a.ID_data,a.titre,c.id_stat,c.nb_vue,d.ID_compteur,d.vt_pos,d.vt_neg,b.lk_image,b.lk_fichier FROM descriptions AS a,lien AS b,statistiques AS c,compteur AS d WHERE a.ID_element=b.ID_lien AND a.ID_element=c.id_stat AND a.ID_element=d.ID_compteur AND a.ID_categorie='".$id_cat_courant2."' ORDER BY a.ID DESC LIMIT 1";
			    $req_cat_pre = mysql_query($select_cat_pre,$rent_bd);
				$verif_cat_pre = mysql_fetch_array($req_cat_pre);
			}
			else
			{
			  $select_cat_pre = "SELECT a.ID,a.ID_element,a.ID_categorie,a.ID_data,a.titre,c.id_stat,c.nb_vue,d.ID_compteur,d.vt_pos,d.vt_neg,b.lk_image,b.lk_fichier FROM descriptions AS a,lien AS b,statistiques AS c,compteur AS d WHERE a.ID_element=b.ID_lien AND a.ID_element=c.id_stat AND a.ID_element=d.ID_compteur AND a.ID_categorie='".$cat_courant."' AND a.ID<'".$id_courant."' ORDER BY a.ID DESC LIMIT 1";
			  $req_cat_pre = mysql_query($select_cat_pre,$rent_bd);
			  $verif_cat_pre = mysql_fetch_array($req_cat_pre);
			}
		}
		else
		{
			$select_count_cat2 = "SELECT ID_categorie,COUNT(DISTINCT ID) AS id FROM descriptions WHERE ID_categorie='".$cat_courant."' AND ID<'".$id_courant."'";
			$req_count_cat2 = mysql_query($select_count_cat2,$rent_bd);
			$verif_count_cat2 = mysql_fetch_array($req_count_cat2);
			
			if($verif_count_cat2['id'] == 0)
			{
			  $id_cat_pre = $cat_courant-1;
			  
			  $select_cat_pre = "SELECT a.ID,a.ID_element,a.ID_categorie,a.ID_data,a.titre,c.id_stat,c.nb_vue,d.ID_compteur,d.vt_pos,d.vt_neg,b.lk_image,b.lk_fichier FROM descriptions AS a,lien AS b,statistiques AS c,compteur AS d WHERE a.ID_element=b.ID_lien AND a.ID_element=c.id_stat AND a.ID_element=d.ID_compteur AND a.ID_categorie='".$id_cat_pre."' ORDER BY a.ID DESC LIMIT 1";
			  $req_cat_pre = mysql_query($select_cat_pre,$rent_bd);
			  $verif_cat_pre = mysql_fetch_array($req_cat_pre);
			}
			else
			{
			  $select_cat_pre = "SELECT a.ID,a.ID_element,a.ID_categorie,a.ID_data,a.titre,c.id_stat,c.nb_vue,d.ID_compteur,d.vt_pos,d.vt_neg,b.lk_image,b.lk_fichier FROM descriptions AS a,lien AS b,statistiques AS c,compteur AS d WHERE a.ID_element=b.ID_lien AND a.ID_element=c.id_stat AND a.ID_element=d.ID_compteur AND a.ID_categorie='".$cat_courant."' AND a.ID<'".$id_courant."' ORDER BY a.ID DESC LIMIT 1";
			  $req_cat_pre = mysql_query($select_cat_pre,$rent_bd);
			  $verif_cat_pre = mysql_fetch_array($req_cat_pre);
			}
		}
		
   //----------------------------------------------------------------------------------------------------------------------------------------//
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
<link rel='stylesheet'  href='http://www.divertiz.com/csstag/principal.css' type='text/css' media='all' />
<link rel='stylesheet'  href='http://www.divertiz.com/csstag/contenu_video.css' type='text/css' media='all' />
<meta property="og:title" content="<?php echo $verif_video['titre']; ?>"/>
<meta property="og:url" content="<?php echo $verif_video['lk_fichier']; ?>"/>
<meta property="og:image" content="<?php echo $verif_video['lk_image']; ?>"/>
<meta property="og:description"  content="<?php echo strip_tags($verif_video['description']); ?>"/>
<meta property="og:site_name" content="http://www.divertiz.com/" />
<meta property="fb:admins" content="100004229702769" />
<link rel="image_src" href="<?php echo $verif_video['lk_image']; ?>" />
<meta name="robots" content="index,follow,noarchive">
<meta name="keywords" content="<?php echo $verif_video['keyword']; ?>" />
<meta name="description" lang="fr" content="<?php echo strip_tags($verif_video['description']); ?>" />
<link rel="canonical" href="<?php echo $verif_video['lk_fichier']; ?>" />
<link rel="shortcut icon" href="http://www.divertiz.com/img/img_main/favicon.ico">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="http://www.divertiz.com/scriptdv/menu_desk.js"></script>
<script type="text/javascript" src="http://www.divertiz.com/shared/media_sys.js"></script>
<title><?php echo $verif_video['titre']; ?></title>
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
		
<script type="text/javascript" >
  function getvoting(id,type,element)
	{
      $.ajax({
  	type : 'POST', 
	url : 'http://www.divertiz.com/shared/voting_sys.php', 
	data : {
		id:id,
		type:type,
		element:element
		},
	success : function(data){ 
			if(data)
			{
				if(type)
				{
					t_up = parseInt(data);
					var t_down = <?php echo $verif_video['vt_neg']; ?>;
					var t_percent = (t_up*100)/(t_up+t_down);
					$(".positif_vote").css("width", t_percent + "%");
					$("#rate_pos").phpl(t_up);
				}
				else
				{
					t_down = parseInt(data);
					var t_up = <?php echo $verif_video['vt_pos']; ?>;
					var t_percent = (t_up * 100) / (t_up + t_down);
					$(".positif_vote").css("width", t_percent + "%");
					$("#rate_neg").phpl(t_down);
				}
				$(".pourcentage").phpl('Merci !');
				$(".pourcentage").css("padding-top", "4px");
				$(".pourcentage").css("font-size", "14px");
			}
			else
			{

				$(".pourcentage").phpl('Déjà votez !');
				$(".pourcentage").css("padding-top", "4px");
				$(".pourcentage").css("font-size", "14px");
			}
	}
      });
    }
</script>
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
					<a class="lk_ss" href="http://www.divertiz.com/index.php">Videos</a>
				<div class="menu_down">
				 <div class="menu_rest">
				  <div class="float_rest">
					<div class="categories_divers">
					  <ul class="float_rent">
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/index.php">All videos</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/video/top_vues.php">Top vote</a></li>
						<li class="left_top_annu"><a class="cat_video_sx" href="http://www.divertiz.com/video/top_votes.php">top vue</a></li>
					  </ul>
					</div>
					</div>
				 </div>
				</div>
				</li>
				<li class="puce_ss" onmouseover="showMenu(this);" onmouseout="hideMenu(this);">
					<a class="lk_ss puce" href="http://www.divertiz.com/video/droles.php">Categories</a>
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
				<a class="lk_ss " href="http://www.divertiz.com/games/games.php">Games</a>
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
				<a class="lk_ss" href="http://www.divertiz.com/blog/cuisine/cuisine.php">Proposez</a>
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
		<form id="form_caster" action="http://shared.divertiz.com/search" method="get">
			<input class="input_text" id="q" type="text" name="q" value="Recherche"  onfocus="if(this.value=='Recherche')this.value='';" onblur="if(this.value=='') this.value='Recherche';" />
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
		<div class="titre_categorie"><h5 style="margin-top:0px; margin-bottom:0px;"><?php echo $verif_video['titre']; ?></h5></div>
		<div style="height:5px;"></div>
			<div class="video_embled" style="margin-left:auto; margin-right:auto; width:650px;" >
			<?php echo $verif_video['embed_video']; ?>
			</div>
			
			<div class="bar_info" style="margin-left:auto; margin-right:auto; width:640px;">
			<div class="green_vote float_left">
			 <a href="" onclick="getvoting(<?php echo $verif_video['ID_element']; ?>,1,<?php echo $verif_video['ID_data']; ?>); return false;" class="rate_green" title="J'aime ce contenu !"><strong class="tex_rate" id="rate_pos" ><?php echo $verif_video['vt_pos']; ?></strong></a>
			</div>
			<div class="red_vote float_left">
			<a href="" onclick="getvoting(<?php echo $verif_video['ID_element']; ?>,0,<?php echo $verif_video['ID_data']; ?>); return false;" class="rate_red" title="Je n'aime pas ce contenu !"><strong class="tex_rate" id="rate_neg"><?php echo $verif_video['vt_neg']; ?></strong></a>
			</div>
			<div class="stat_vote float_left">
				<div class="positif_vote" style="width:<?php 
				if($verif_video['vt_pos']>$verif_video['vt_neg']) 
				{
					$res=($verif_video['vt_pos']*100)/($verif_video['vt_pos']+$verif_video['vt_neg']);
					$perct=round($res,4);
					$rate=round($perct,0);
					echo $perct;
					
				} 
				else{
					$res=($verif_video['vt_pos']*100)/($verif_video['vt_pos']+$verif_video['vt_neg']);
					$perct=round($res,4);
					$rate=round($perct,0);
				    echo $perct;
				} ?>%"></div>
				<div class="pourcentage"><?php echo $rate; ?>%</div>
			</div>
			<div class="like_fbk float_left">
			<div id="fb-root"></div>

		<div class="fb-like" data-href="<?php echo $verif_video['lk_fichier']; ?>" data-send="false" data-layout="button_count" data-width="250" data-show-faces="false" data-font="arial"></div>
			</div>
			
				<div class="info_view" >
					<span><?php echo $vue = number_format($verif_video['nb_vue'],0,',',','); ?> vues</span>
			</div>
			</div>
			<div class="titre_vod"><h4><a href="<?php echo $verif_video['lien']; ?>">telecharger des milliers de films en hd !</a></h4></div>
			<div class="info_upload" style="margin-left:auto; margin-right:auto; width:630px; word-spacing:4px;">
			<span><strong>Posté le :  </strong> <?php
			$annee=substr($verif_video['date'],0,4);
			$mois=substr($verif_video['date'],5,2);
			$jour=substr($verif_video['date'],8,2);
			$heurs=substr($verif_video['date'],11,8);
			switch($mois)
			{
			 case 01: $calendrier = "Janvier";
			 break;
			 case 02: $calendrier = "Fevrier";
			 break;
			 case 03: $calendrier = "Mars";
			 break;
			 case 04: $calendrier = "Avril";
			 break;
			 case 05: $calendrier = "Mai";
			 break;
			 case 06: $calendrier = "Juin";
			 break;
			 case 07: $calendrier = "Juillet";
			 break;
			 case 08: $calendrier = "Aout";
			 break;
			 case 09: $calendrier = "Septembre";
			 break;
			 case 10: $calendrier = "Octobre";
			 break;
			 case 11: $calendrier = "Novembre";
			 break;
			 case 12: $calendrier = "Decembre";
			 break;
			}
			echo $jour."  ".$calendrier."  ".$annee." à ".$heurs;
			?></span>
			</div>
			<div class="info_upload" style="margin-left:auto; margin-right:auto; width:630px;">
			<span><strong>Tag :  </strong><?php
			   
			   $mot = $verif_video['keyword'];
			   $keyword=explode(',',$mot);
				$compteur=count($keyword);
				$search ="";
				$first ="";
				  for($i=0;$i<$compteur;$i++)
					{
					  if($i == 0)
					  {
						$first ="".$keyword[0]."";
					  }
					  else
					  {
						$search .=" , ".$keyword[$i]."";
					  }
					}
				echo $first.$search;
			?>
			</div>
			<div class="description">
				<p><?php echo $verif_video['description']; ?></p>
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
			<div class="fb-comments" data-href="<?php echo $verif_video['lk_fichier']; ?>" data-num-posts="5" data-width="640"></div>
			</div>
			<div class="titre_categorie"><h4 style="margin-top:0px; margin-bottom:0px;">videos similaires</h4></div>
		<div  class="gris_line"></div>
			<div class="media_container">
			<ul class="box_caster">
		 <?php while($verif_similaire = mysql_fetch_array($req_similaire)) { ?>
			 <li class="width_container float_left">
			 <div class="date_upload">
				<div class="txt_info">
				<span style="margin-left:12px;" class="capitale" >il y a</span>
				<span style="margin-left:12px;" class="black">
				<?php   
				$today = getdate();
				$date = $today[0];
				$ajout = strtotime($verif_similaire['date']);
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
					<a href="<?php echo $verif_similaire['lk_fichier']; ?>" ><img src="<?php echo $verif_similaire['lk_image']; ?>" alt="<?php echo $verif_similaire['titre']; ?>" title="<?php echo $verif_similaire['titre']; ?>"/></a>
					<a class="titre_container" href="<?php echo $verif_similaire['lk_fichier']; ?>" ><?php echo $verif_similaire['titre']; ?></a>
				</div>
					<div class="stat_video">
					    <div class="duree txt_info ">
							<span class="display black"><?php echo $verif_similaire['duree']; ?></span>
							<span class="capitale display">duree</span>
						</div>
						<div class="vues txt_info ">
							<span class="display black"><?php echo $verif_similaire['nb_vue']; ?></span>
							<span class="capitale display">vues</span>
						</div>
						<div class="classement txt_info ">
							<span class="display 
			<?php if($verif_similaire['vt_pos']>$verif_similaire['vt_neg']) 
				{
					$res=($verif_similaire['vt_pos']*100)/($verif_similaire['vt_pos']+$verif_similaire['vt_neg']);
					$perct=round($res,0);
					$rate=$perct;
					echo " green";
					echo '">';
					echo $rate."%";
				} 
				else{
					$res=($verif_similaire['vt_pos']*100)/($verif_similaire['vt_pos']+$verif_similaire['vt_neg']);
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
	<div class="like_reseau_sociaux">
		<!-- Reseaux sociaux -->
		<div class="titre_annexe">
		<h3 class="dis_titre">SUIVRE DIVERTIZ</h3>
		</div>
		<div style="clear:both; height:3px;"></div>
		<div class="fb-like" data-href="http://www.facebook.com/pages/Divertiz/428047647245563" data-send="true" data-layout="button_count" data-width="250" data-show-faces="false" data-font="arial"></div>
		</div>
		
		<h3 class="titre_pre_sui">Categorie :<span><?php echo " ".$catego; ?></span></h3>
	
	    <div class="prec_suiv">
				<div class="prev float_left">
				<a href="<?php echo $verif_cat_pre['lk_fichier']; ?>" class="display_block">
				<img src="<?php $lk_image = rtrim($verif_cat_pre['lk_image'], '.jpg'); echo $lk_image."_140x90.jpg"; ?>" title="<?php echo $verif_cat_pre['titre']; ?>" alt="<?php echo $verif_cat_pre['titre']; ?>">
				</a>
				<a class="display_block" href="<?php echo $verif_cat_pre['lk_fichier']; ?>">Précédent</a>
				</div>
				
				<div class="next float_right">
				<a href="<?php echo $verif_cat_sui['lk_fichier']; ?>" class="display_block">
				<img src="<?php $lk_image = rtrim($verif_cat_sui['lk_image'], '.jpg'); echo $lk_image."_140x90.jpg";?>" title="<?php echo $verif_cat_sui['titre']; ?>" alt="<?php echo $verif_cat_sui['titre']; ?>"></a>
				<a class="display_block" href="<?php echo $verif_cat_sui['lk_fichier']; ?>">Suivant</a>
				</div>
				<div style="clear:both; height:2px;"></div>
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
		<h3 class="titre_pre_sui">Categorie : <span>Tous les videos</span></h3>
		<div class="prec_suiv">
				<div class="prev float_left">
				<a href="<?php echo $verif_pre['lk_fichier']; ?>" class="display_block">
				<img src="<?php $lk_image = rtrim($verif_pre['lk_image'], '.jpg'); echo $lk_image."_140x90.jpg"; ?>" title="<?php echo $verif_pre['titre']; ?>" alt="<?php echo $verif_pre['titre']; ?>">
				</a>
				<a class="display_block" href="<?php echo $verif_pre['lk_fichier']; ?>">Précédent</a>
				</div>
				
				<div class="next float_right">
				<a href="<?php echo $verif_sui['lk_fichier']; ?>" class="display_block">
				<img src="<?php $lk_image = rtrim($verif_sui['lk_image'], '.jpg'); echo $lk_image."_140x90.jpg";?>" title="<?php echo $verif_sui['titre']; ?>" alt="<?php echo $verif_sui['titre']; ?>"></a>
				<a class="display_block" href="<?php echo $verif_sui['lk_fichier']; ?>">Suivant</a>
				</div>
				<div style="clear:both; height:2px;"></div>
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