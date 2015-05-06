//ce que l'utilisateur est en train de lire
var id_flux;
var id_dossier;

var leftFlap_initialposLeft;

$(document).ready( function start(){
	
 	//temporaire : nécessitera de récupérer les flux de la communautée
 	id_flux = 1;
 	id_dossier=null;
 	
 	addArticles(12, 0, id_flux, id_dossier);
 	printDossier();
 	
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
	 $('#dossiers_user').on("click", '.flux', function() {
		
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

//POPUP
	 $('.addFlux').on('click', function(){
				var courantid = $(this).attr('id');

				//affichage de la popup
				
			
				var verifpopup = $('#popup_addflux').attr('class'); // Si la popup existe elle a un nom de class
				if(verifpopup != undefined) // la popup existe
				{	
				
				
					jQuery.ajax({
						type: 'POST',
						url: 'srvAjax/popupAddFlux.php',
						
						success: function(data, textStatus, jqXHR) {
							// La réponse du serveur est contenu dans la variable « data »
							// On peut faire ce qu'on veut avec ici
							
							$.when($("#popup_addflux").empty().append(data)).done(function() {
								
								var popID = "popup_addflux"; //pop-up a afficher
								var popWidth = 650; //L'argeur de la popup
							
								//Faire apparaitre la pop-up
								$('#' + popID).fadeIn().css({'width': popWidth});
							
								//Récupération du margin, qui permettra de centrer la fenêtre - on ajuste de 80px en conformité avec le CSS
								var popMargLeft = ($('#' + popID).width() + 80) / 2;
							
								//On affecte le margin pour centrer la popup verticalement
								$('#' + popID).css({
									'margin-left' : -popMargLeft
								});
								
			
								
								//Effet fade-in du fond opaque
								$('body').append('<div id="fade"></div>'); //Ajout du fond opaque noir
								//Apparition du fond - .css({'filter' : 'alpha(opacity=80)'}) pour corriger les bogues de IE
								$('#fade').css({'filter' : 'alpha(opacity=80)'}).fadeIn();
								
								
							});
							
							
														
						},
						error: function(jqXHR, textStatus, errorThrown) {
							alert("erreure PopupAddFlux");
						}
					});
					
				}
					
		});
		
		$('#popup_addflux').on("click", '.close_popup',  function(){ 
			$.when( $('.popup_block').fadeOut())
				   .done(function() { 
						$('#fade').fadeOut();
				   });
		});
		
		$('#popup_addflux').on("click", '.addFlux_popup',  function(){ 	
			var popup = $('#popup_addflux');
			var html = $('body');
			
			var checkedFolder = $('input[type=radio][name=addFluxPopup_folder]:checked');
			var folder_id = checkedFolder.attr('id');
			
			var url_flux = $('#addFluxPopup_flux_url').val();
			var name_flux = $('#addFluxPopup_flux_name').val();
			
			errors = "";
			
			if(folder_id == undefined)
			{
				errors += "Selectionnez un dossier <br/>";
				
			}
			if(!Url_Valide(url_flux))
			{
				errors += "URL invalide <br/>";
			}
			if(name_flux == "")
			{
				errors += "Nom du flux manquant <br/>";
			}
			
			if(errors == "")
			{
				addFluxURL(folder_id, name_flux,  url_flux);
			}
			else
			{
				html.append('<div class="informationBox warning">'+errors+'</div>');
				$('informationBox').toggleClass('animation');
			}
			
		});
}



function Url_Valide(UrlTest)
{
  var regexp = new RegExp("/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/");
  //return regexp.test(UrlTest);
  
  //TODO !
  return true;
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
			alert("erreure addArticles");
		}
	});
}

function addFluxURL(id_dossier, nom_flux, url_flux)
{
	jQuery.ajax({
		type: 'POST',
		url: 'srvAjax/addFluxUrl.php',
		
		data: {
		  	iddossier: id_dossier,
		  	nomflux: nom_flux,
		  	urlflux: url_flux,
		}, 
		success: function(data, textStatus, jqXHR) {
			// La réponse du serveur est contenu dans la variable « data »
			// On peut faire ce qu'on veut avec ici
			if(data=="ok")
			{
				var html = $('body');
				html.append('<div class="informationBox info">Ajout OK :)</div>');
				$('informationBox').toggleClass('animation');
				printDossier(); // update the left flap
				
				//close the popup
				$.when( $('.popup_block').fadeOut())
				   .done(function() { 
						$('#fade').fadeOut();
				   });
			}
			else
			{
				msg = '<div class="informationBox warning">'+data+'</div>';
				
				var html = $('body');
				html.append(msg);
				$('informationBox').toggleClass('animation');
			}
						
		},
		error: function(jqXHR, textStatus, errorThrown) {
			alert("erreure addFluxURL");
		}
	});
}


function printDossier()
{
	jQuery.ajax({
		type: 'POST',
		url: 'srvAjax/showDossiers.php',
		
		success: function(data, textStatus, jqXHR) {
			// La réponse du serveur est contenu dans la variable « data »
			// On peut faire ce qu'on veut avec ici
			$('#dossiers_user').empty().append(data);
						
		},
		error: function(jqXHR, textStatus, errorThrown) {
			alert("erreure printDossier");
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