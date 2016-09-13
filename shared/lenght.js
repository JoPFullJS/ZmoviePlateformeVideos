$(document).ready( function(e) {
 $('.titre').keyup(function() {
  
    var nombreCaractere2 = $(this).val().length;
    var nombreCaractere2 = 100 - nombreCaractere2;
    
    var nombreMots2 = jQuery.trim($(this).val()).split(' ').length;
    if($(this).val() === '') {
     	nombreMots2 = 0;
    }	
    
    var msg2 = '(' + nombreMots2 + ' mot(s) | ' + nombreCaractere2 + ' Caractere(s) restant)';
    $('.mes_titre').text(msg2);
    if (nombreCaractere2 < 0)
	{ 
		$('.mes_titre').addClass("mauvais"); 
		$('.sub_rn').attr('disabled','disabled');
		$('.sub_rn').addClass("sub_js");
		$('.sub_rn').removeClass("sub_rn");
	} 
	else 
	{
		$('.mes_titre').removeClass("mauvais"); 
		$('.sub_rn').removeAttr('disabled');
		$('.sub_js').addClass("sub_rn");
		$('.sub_js').removeClass("sub_js");
	}
    
  })  
  
  $('#desk_img').keyup(function() {
  
    var nombreCaractere = $(this).val().length;
    var nombreCaractere = 250 - nombreCaractere;
    
    var nombreMots = jQuery.trim($(this).val()).split(' ').length;
    if($(this).val() === '') {
     	nombreMots = 0;
    }	
    
    var msg = '(' + nombreMots + ' mot(s) | ' + nombreCaractere + ' Caractere(s) restant)';
    $('.mes_desk').text(msg);
    if (nombreCaractere < 0) 
	{ 
		$('.mes_desk').addClass("mauvais"); 
		$('.sub_rn').attr('disabled','disabled');
		$('.sub_rn').addClass("sub_js");
		$('.sub_rn').removeClass("sub_rn");
	}
	else 
	{ 
		$('.mes_desk').removeClass("mauvais");
		$('.sub_rn').removeAttr('disabled');
		$('.sub_js').addClass("sub_rn");
		$('.sub_js').removeClass("sub_js");
	}
    
  }) 
  
 $('#tag').keyup(function() {
  
    
    var nombreMots3 = jQuery.trim($(this).val()).split(',').length;
	var motrestant = 6 - nombreMots3;
    if($(this).val() === ',') {
     	nombreMots3 = 0;
		
    }	
    
    var msg3 = '(' + nombreMots3 + ' mot(s) | ' + motrestant + ' mot(s) restant)';
    $('.mes_tag').text(msg3);
    if (motrestant < 0)
	{ 
		$('.mes_tag').addClass("mauvais"); 
		$('.sub_rn').attr('disabled','disabled');
		$('.sub_rn').addClass("sub_js");
		$('.sub_rn').removeClass("sub_rn");
		
	} 
	else 
	{ 
		$('.mes_tag').removeClass("mauvais"); 
		$('.sub_rn').removeAttr('disabled');
		$('.sub_js').addClass("sub_rn");
		$('.sub_js').removeClass("sub_js");
	}
    
  })    
});