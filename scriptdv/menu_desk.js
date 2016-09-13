$(document).ready(function (){
$("div.menu_down").hide();
});
function showMenu(e){
   $(e).children('a.lk_ss').addClass("hover");
   //$(e).children('a.lk_ss').removeClass("puce");
   $(e).children("div.menu_down").show();
}
function hideMenu(e){
   $(e).children("div.menu_down").hide();
   $(e).children('a.lk_ss').removeClass("hover");
   //$(e).children('a.lk_ss').addClass("puce");
}