
	function videorandom(element)
	{
	 $field = $("#charger");
	 $('#ajax-loader').remove(); // on retire le loader
      $.ajax({
		type : 'POST', // envoi des données en GET ou POST
		url : 'load_media.php' , // url du fichier de traitement
		data : { element:element },// données à envoyer en  GET ou POST
		beforeSend : function() { // traitements JS à faire AVANT l'envoi
		$field.after('<img src="http://player.video-force.com/assets/images/basic/loading.gif" alt="loader" id="ajax-loader" height="150" />'); // ajout d'un loader pour signifier l'action
		},
		success : function(data){ // traitements JS à faire APRES le retour d'ajax-search.php
		$('#ajax-loader').remove(); // on enleve le loader
		$('#charger').html(data); // affichage des résultats dans le bloc
	}
		  });
    }
	

  
