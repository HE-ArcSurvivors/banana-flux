//ce que l'utilisateur est en train de lire
var id_flux;
var id_dossier;

var leftFlap_initialposLeft;


//
//	$(document).ready
//	Se produit à la fin du rechargement du DOM
//
$(document).ready( function start(){
	
 	//temporaire : nécessitera de récupérer les flux de la communautée
 	id_flux = 1;
 	id_dossier=null;
 	
 	printDossier();
 	addArticles(12, 0, id_flux, id_dossier);
 	
 	leftFlap_initialposLeft = $("#leftFlap").css("left");

 	updateLeftFlapSize();
 	
 	//start listeners
 	spyScroll();
 	spyResizeWindow();
 	startClicListeners();
});



//------------------------------------------------------//
//----------------------LISTENERS-----------------------//
//------------------------------------------------------//

function startClicListeners()
{
    //
	//	click listener on #leftFlap_Bouton
	//	Ouvre ou ferme le volet gauche
	//
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
	 
	 //
	 //	click listener on .flux
	 //	afficher les articles du flux
	 //
	 $('#dossiers_user').on("click", '.flux', function() {
		
		id_flux = $(this).children(".idflux_hidden").text();
		id_dossier=null;
		
		addArticles(12, 0, id_flux, id_dossier);
		
	 });

    $('#dossiers_user').on("click", '.deleteFolder',function() { 
        
        id_dossier = $(this).parent().parent().find(".iddossier_hidden").text();
        name_dossier = $(this).parent().parent().find(".nameFolder").text();
        
        var popID = "popup_deleteFolder"; //pop-up a afficher
        getDeleteFolderPopup('#' + popID, name_dossier, id_dossier);        
       
        var popWidth = 600;
        $('#' + popID).fadeIn().css({'width': popWidth});
        var popMargLeft = ($('#' + popID).width() + 80) / 2;

        $('#' + popID).css({
            'margin-left' : -popMargLeft
        });

        $('body').append('<div id="fade"></div>');
        $('#fade').css({'filter' : 'alpha(opacity=80)'}).fadeIn();
    });
    
    $("#dossiers_user").on("click", '.editFolder', function() { 
        
        name_dossier = $(this).parent().parent().find(".nameFolder").text();
        id_dossier = $(this).parent().parent().find(".iddossier_hidden").text();
        
        var popID = "popup_editFolder"; //pop-up a afficher
        getEditFolderPopup('#' + popID,name_dossier,id_dossier);        
       
        var popWidth = 400; //L'argeur de la popup
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
    
    $("#headbar").on("click", '.editProfileButton', function() {
        
        console.log("HEADBAR CLICK");
        var popID = "popup_editProfile"; //pop-up a afficher
        getEditProfilePopup('#' + popID);        
       
        var popWidth = 800; //L'argeur de la popup
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
                 
    $('#popup_editFolder').on("click", '.editFolderButton',  function(){ 	
 	
        popup = $('#popup_editFolder');
        
        id_dossier = popup.find('.iddossier_hidden').text();
        folder_new_name = document.querySelector('#folder_newname').value;
        
        editFolder(id_dossier,folder_new_name,$(this).parent());
        
        printDossier();
        
        $.when($('.popup_block').fadeOut()).done(function() { 
            $('#fade').fadeOut();
		});
	
    });
    
    $('#popup_deleteFolder').on("click", '.deleteFolderValidate',  function(){ 	
 	
        popup = $('#popup_deleteFolder');
        
        id_dossier = popup.find('.iddossier_hidden').text();
        
        deleteFolder(id_dossier);
        
        printDossier();
        
        $.when($('.popup_block').fadeOut()).done(function() { 
            $('#fade').fadeOut();
		});
	
    });

    //
	//	click listener on .addFlux
	//	Appartient au volet gauche
	//  TODO ! (en cours)
	//
 	$('.addFlux').on('click', function(){
			var courantid = $(this).attr('id');

			showPopup("popup_addflux", '<p class="boutonStyle addFluxPopup_addFluxURL">je ne trouve pas ce que je veux :/</p><p class="boutonStyle addFluxPopup_ajouter">Ajouter</p><p class="boutonStyle close_popup">Abandonner</p>', 650);
	});
		
	//
	//	click listener on .addFluxPopup_addFluxURL
	//	Appartient à #popup_addflux
	//  TODO ! (en cours)
	//
	$('.popup_block').on("click", '.addFluxPopup_addFluxURL',  function(){ 
		$.when($('.popup_block').fadeOut())
			   .done(function() { 
											
						jQuery.ajax({
							type: 'POST',
							url: 'srvAjax/popupAddFluxURL.php',
							
							success: function(data, textStatus, jqXHR) {
								
								showPopup("popup_addfluxURL", data, 650);
															
							},
							error: function(jqXHR, textStatus, errorThrown) {
								alert("erreur PopupAddFlux");
							}
						});
					
					
			   });
	});
	
	//
	//	click listener on .close_popup
	//	Appartient à .popup_block (all popup)
	//	Ferme toutes les popups
	//
	$('.popup_block').on("click", '.close_popup',  function(){ 
		$.when($('.popup_block').fadeOut())
			   .done(function() { 
					$('#fade').fadeOut();
			   });
	});
	
	//
	//	click listener on .addFluxURLpopup_Ajouter
	//	Appartient à #popup_addfluxURL
	//	Valide les entrées de l'utilisateur et soumet à "addFluxURL()"
	//
	$('#popup_addfluxURL').on("click", '.addFluxURLpopup_Ajouter',  function(){ 	
		var popup = $('#popup_addfluxURL');
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

//
//	spyScroll
//	ajoute des articles si l'utilisateur scroll en bas de la page
//  met a jour la position du volet gauche pour qu'il suive l'écran
//
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

//
//	spyResizeWindow
//  met a jour la hauteur du volet gauche au redimentionnement de la fenêtre
//
function spyResizeWindow(){
	$(window).resize(function() {
		updateLeftFlapSize();
	});
}

//------------------------------------------------------//
//-------------------------AJAX-------------------------//
//------------------------------------------------------//

//
//  addArticles (AJAX)
//	ajoute des articles aux articles de la page
// 	nbToAdd 			: nombre d'article a afficher
//  nbShowed 			: nombre d'aricle déjà affiché sur la page
//	id_flux, id_dossier : quoi afficher
//
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

//
//	addFluxURL (AJAX)
//	ajoute un flux à la base de données
// 	a partir de : id_dossier, nom_flux, url_flux et de l'user en session
//
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
			alert("erreur addFluxURL");
		}
	});
}


//------------------------------------------------------//
//----------------Utilitaires validation----------------//
//------------------------------------------------------//	

//
//	Url_Valide
//	valide une URL d'un fichier xml
//	TODO /!\
//
function Url_Valide(UrlTest)
{
  var regexp = new RegExp("/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/");
  //return regexp.test(UrlTest);
  
  //TODO !
  return true;
}

//------------------------------------------------------//
//----------------Utilitaires interface-----------------//
//------------------------------------------------------//	


//
//	OpenLeftFlap
//	Ouvre le volet gauche
//
function OpenLeftFlap(duration)
{
	var add = $("#leftFlap").width()-$("#leftFlap_Bouton").width();
	$("#leftFlap").animate({left:"+="+add} ,duration);
	$("#articles").animate({paddingLeft:"+="+add} ,duration);
	
	$("#leftFlap_Bouton").empty().append("<p>Fermer</p>");
}

//
//	CloseLeftFlap
//	Ferme le volet gauche
//
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

//
//	printDossier (AJAX)
//	met a jour les dossier de l'utilisateur dans le volet
//  gauche
//
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

//
//	showPopup
//	affiche la popup avec l'id "popID" (sans # !) 
//	et remplace par "data" (HTML) son contenu 
//
function showPopup(popID, data, popWidth)
{
	var verifpopup = $("#"+popID).attr('class'); // Si la popup existe elle a un nom de class
	if(verifpopup != undefined) // la popup existe
	{	
		$.when($("#"+popID).empty().append(data)).done(function() {
																	
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
	}
}