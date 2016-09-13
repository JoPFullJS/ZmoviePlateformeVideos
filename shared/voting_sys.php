<?php

if(isset($_POST['element']) && isset($_POST['type']) && isset($_POST['id']))
{

	//on choisi le bouton qui a �te selectionner
	switch($_POST['type'])
		{
		case 0: $vote = 'vt_neg';
		break;
		case 1: $vote = 'vt_pos';
		break;
		}
	//define('DB_USER', 'onecaste_media');
   //define('DB_PASSWORD', 'wgpz27k@');
  // define('DB_HOST', 'localhost');
   //$connexion = mysql_connect( DB_HOST , DB_USER , DB_PASSWORD );
   //Selection de la table de donn�e
   //mysql_select_db(DB_NAME);

   $pdo = new PDO('mysql:host=localhost;dbname=divertz', 'root', '');

   $ip = $_SERVER['REMOTE_ADDR'];
   $count="SELECT COUNT(ID_ip) AS vote FROM  vote_ip  WHERE ID_vote='".$_POST['id']."' AND ID_ip='".$ip."'";
   $req_count =  $pdo->query( $count );
   $verif_count = $req_count->fetch();

   if($verif_count['vote'] == 0)
   {
		$ajout_ip="INSERT INTO vote_ip SET ID_ip='".$ip."',ID_vote='".$_POST['id']."'";
		$req_ajout =  $pdo->query( $ajout_ip );
		if(isset($req_ajout))
			{
				$ajout_unit="SELECT ".$vote.",ID_compteur FROM compteur WHERE ID_compteur='".$_POST['id']."'";
				$req_unit =  $pdo->query($ajout_unit);

			 while($verif_unit = $req_unit->fetch())
			 {
				if($vote == 'vt_pos')
				{
					$unit = $verif_unit[$vote]+1;
					$maj = "UPDATE compteur SET vt_pos='".$unit."' WHERE ID_compteur='".$_POST['id']."'";
					$req_maj =  $pdo->query($maj);

					//On redemande la valeur de l'élément selectionner
					$reponse = "SELECT ".$vote." FROM compteur WHERE ID_compteur='".$_POST['id']."'";
					$req_reponse =  $pdo->query($reponse);

					while($verif_reponse = $req_reponse->fetch())
					{
						$data = $verif_reponse[$vote];
						echo $data;

					}
				}
				else if($vote == 'vt_neg')
				{

					$unit = $verif_unit[$vote]+1;
					$maj = "UPDATE compteur SET vt_neg='".$unit."' WHERE ID_compteur='".$_POST['id']."'";
					$req_maj =  $pdo->query($maj);
					//On renvoir une reponse au script
					$reponse = "SELECT ".$vote." FROM compteur WHERE ID_compteur='".$_POST['id']."'";
					$req_reponse =  $pdo->query($reponse);

					while($verif_reponse = $req_reponse->fetch())
					{
						$data = $verif_reponse[$vote];
						echo $data;
					}
				}
			 }
			}
   }

   else if($verif_count['vote'] == 1)
   {

		$date = new DateTime();
		$instant = $date->format('Y-m-d H:i:s');
		$select_date = "SELECT date_vote AS date FROM vote_ip WHERE ID_vote='".$_POST['id']."' AND ID_ip='".$ip."'";
		$req_date =  $pdo->query($select_date);
		$verif_date = $req_date->fetch();

			$date1 = strtotime($instant);
			$date2 = strtotime($verif_date['date']);


		$diff = $date1 - $date2;
		if($diff > 86400)
		{

				$ajout_unit="SELECT ".$vote." FROM compteur WHERE ID_compteur='".$_POST['id']."'";
				$req_unit =  $pdo->query( $ajout_unit );

			 while($verif_unit = fetch($req_unit))
			 {
				if($vote == 'vt_pos')
				{
					$unit = $verif_unit[$vote]+1;
					$maj = "UPDATE compteur SET ".$vote."='".$unit."' WHERE ID_compteur='".$_POST['id']."'";
					$req_maj =  $pdo->query($maj);
					//on ajoute la date du vote
					$ajout_date = "UPDATE vote_ip SET date_vote='".$instant."' WHERE ID_vote='".$_POST['id']."' AND ID_ip='".$ip."'";
		            $req_date =  $pdo->query($ajout_date);
					//On renvoir une reponse au script
					$reponse = "SELECT ".$vote." FROM compteur WHERE ID_compteur='".$_POST['id']."'";
					$req_reponse =  $pdo->query($reponse);

					$verif_reponse = $req_reponse->fetch();

						$data = $verif_reponse[$vote];
						echo $data;


				}
				else if($vote == 'vt_neg')
				{

					$unit = $verif_unit[$vote]+1;
					$maj = "UPDATE compteur SET ".$vote."='".$unit."' WHERE ID_compteur='".$_POST['id']."'";
					$req_maj =  $pdo->query($maj);
					//on ajoute la date du vote
					$ajout_date = "UPDATE vote_ip SET date_vote='".$instant."' WHERE ID_vote='".$_POST['id']."' AND ID_ip='".$ip."'";
		            $req_date =  $pdo->query($ajout_date);
					//On renvoir une reponse au script
					$reponse = "SELECT ".$vote." FROM compteur WHERE ID_compteur='".$_POST['id']."'";
					$req_reponse =  $pdo->query($reponse);

					$verif_reponse = $req_reponse->fetch();

						$data = $verif_reponse[$vote];
						echo $data;

				}
			}

		}
		else if($diff < 86400)
		{

		}
   }

 }
?>
