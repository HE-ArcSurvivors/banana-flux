$(function () {
     var $win = $(window);

     $win.scroll(function ()
     {
        if ($win.height() + $win.scrollTop() == $(document).height())
        {
        	//alert("t'en veux plus ??");
            addArticles(12, $(".article").length);
        }
     });
     
});

$(document).ready( function start(){
 	//alert("it's work");
 	addArticles(12, 0);
});



function addArticles(nbToAdd, nbShowed)
{
	jQuery.ajax({
		type: 'POST',
		url: 'showArticles.php',
		
		data: {
		  nbadd: nbToAdd,
		  nbshowed: nbShowed,
		}, 
		success: function(data, textStatus, jqXHR) {
			// La réponse du serveur est contenu dans la variable « data »
			// On peut faire ce qu'on veut avec ici
			
			var elemAdd = $('#articles');
			
			if(nbShowed==0){
				elemAdd.empty();
			}
			
			elemAdd.append(data);
			
		},
		error: function(jqXHR, textStatus, errorThrown) {
			alert("erreure addArticles");
		}
	});
}
