//ce que l'utilisateur est en train de lire
var id_flux;
var id_dossier;

var leftFlap_initialposLeft;

$(document).ready( function start(){
	
 	//temporaire : nécessitera de récupérer les flux de la communautée
 	id_flux = 1;
 	id_dossier=null;
 	
 	addArticles(12, 0, id_flux, id_dossier);
 	
 	leftFlap_initialposLeft = $("#leftFlap").css("left");

 	updateLeftFlapSize();
 	
 	//start listeners
 	spyScroll();
 	spyResizeWindow();
 	startClicListeners();
});


function OpenLeftFlap(duration)
{
	var add = $("#leftFlap").width()-$("#leftFlap_Bouton").width();
	$("#leftFlap").animate({left:"+="+add} ,duration);
	$("#articles").animate({paddingLeft:"+="+add} ,duration);
	
	$("#leftFlap_Bouton").empty().append("<p>Fermer</p>");
}

function CloseLeftFlap(duration)
{
	var add = $("#leftFlap").width()-$("#leftFlap_Bouton").width();
	$("#leftFlap").animate({left:"-="+add} ,duration);
	$("#articles").animate({paddingLeft:"-="+add} ,duration);
	
	$("#leftFlap_Bouton").empty().append("<p>Ouvrir</p>");
}

function updateLeftFlapSize()
{
	$("#leftFlap").height($(window).height());
}

//------------------------------------------------------//
//----------------------LISTENERS-----------------------//
//------------------------------------------------------//

function startClicListeners()
{
	$("#leftFlap_Bouton").on("click", function() {

	 	left = $("#leftFlap").css("left");

	 	if(left == leftFlap_initialposLeft) //open
	 	{	
	 		OpenLeftFlap(500);
     	}
     	else if (left == "0px") //close
     	{
	     	CloseLeftFlap(500);
     	}
	 	
	 });
	 
	 $(".flux").on("click", function() {
		
		id_flux = $(this).children(".idflux_hidden").text();
		id_dossier=null;
		
		addArticles(12, 0, id_flux, id_dossier);
		
	 });
    
    $(".deleteFolder").on("click", function() { 
        id_dossier = $(this).parent().parent().find(".iddossier_hidden").text();
        deleteFolder(id_dossier,$(this).parent());
    });
    
    $(".editFolder").on("click", function() { 
        id_dossier = $(this).parent().parent().find(".iddossier_hidden").text();
        folder_new_name = "OK";
        editFolder(id_dossier,folder_new_name,$(this).parent());
    });
    
}

//ajoute des articles si l'utilisateur scroll en bas de la page
function spyScroll() {
     var $win = $(window);

     $win.scroll(function ()
     {
     	//Add Articles
        if ($win.height() + $win.scrollTop() == $(document).height())
        {
        	//alert("t'en veux plus ??");
            addArticles(12, $(".article").length, id_flux, id_dossier);
        }
        
        //Move the leftFlap
        if($win.scrollTop()>$('#headbar').height())
        {
        	$("#leftFlap").css( "top", $win.scrollTop());
		}
		else
		{
			$("#leftFlap").css( "top", $('#headbar').height());
		}
        
     });
}

function spyResizeWindow(){
	$(window).resize(function() {
		updateLeftFlapSize();
	});
}

//------------------------------------------------------//
//-------------------------AJAX-------------------------//
//------------------------------------------------------//

//ajoute des articles
function addArticles(nbToAdd, nbShowed, id_flux, id_dossier)
{
	jQuery.ajax({
		type: 'POST',
		url: 'srvAjax/showArticles.php',
		
		data: {
		  nbadd: nbToAdd,
		  nbshowed: nbShowed,
		  idflux: id_flux,
		  iddossier: id_dossier,
		}, 
		success: function(data, textStatus, jqXHR) {
			// La réponse du serveur est contenu dans la variable « data »
			// On peut faire ce qu'on veut avec ici
			
			var elemAdd = $('#articles');
			
			if(nbShowed==0){
				elemAdd.empty();
				$(window).scrollTop(0);
			}
			
			elemAdd.append(data);
			
		},
		error: function(jqXHR, textStatus, errorThrown) {
			alert("Error addArticles");
		}
	});
}

function deleteFolder(id_dossier, parent)
{
    jQuery.ajax({
        type: 'POST',
        url: 'srvAjax/manageFolders.php',
        
        data : {
            action: "deleteFolder",
            id: id_dossier
        },
        
        success: function(data, textStatus, jqXHR) {
            if(data == true)
            {
                parent.parent().css("display","none");
                parent.parent().parent().find(".flux").css("display","none");
                
                var html = $('body');
                html.append('<div class="informationBox info">Le dossier a été supprimé avec succès</div>');
                $('informationBox').toggleClass('animation');
            }
            else
            {
                var html = $('body');
                html.append(data);
                $('informationBox').toggleClass('animation');
            }
        },
        
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
			alert("Error manageFolders > DeleteFolder");
		}
                
    });
}

function editFolder(id_dossier, folder_new_name, parent)
{   
    jQuery.ajax({
        type: 'POST',
        url: 'srvAjax/manageFolders.php',
        
        data : {
            action: "editFolder",
            id: id_dossier,
            folder_name: folder_new_name
        },
        
        success: function(data, textStatus, jqXHR) {
            if(data == true)
            {
                parent.parent().find(".nameFolder").text(folder_new_name);
            }
            else
            {
                console.log(data);
            }
        },
        
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
			alert("Error manageFolders > EditFolder");
		}      
    });
}