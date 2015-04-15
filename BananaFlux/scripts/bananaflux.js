var currentRSSurl; //ce que l'utilisateur est en train de lire

$(document).ready( function start(){
	currentRSSurl = prompt("Tu veux lire quoi ?", "http://www.20min.ch/rss/rss.tmpl?type=rubrik&get=313&lang=ro");
 	addArticles(12, 0, currentRSSurl);
 	spyScroll();
});

//ajoute des articles si l'utilisateur scroll en bas de la page
function spyScroll() {
     var $win = $(window);

     $win.scroll(function ()
     {
        if ($win.height() + $win.scrollTop() == $(document).height())
        {
        	//alert("t'en veux plus ??");
            addArticles(12, $(".article").length, currentRSSurl);
        }
     });
}

//ajoute des articles
function addArticles(nbToAdd, nbShowed, urlRSS)
{
	jQuery.ajax({
		type: 'POST',
		url: 'showArticles.php',
		
		data: {
		  nbadd: nbToAdd,
		  nbshowed: nbShowed,
		  rssurl: urlRSS,
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
