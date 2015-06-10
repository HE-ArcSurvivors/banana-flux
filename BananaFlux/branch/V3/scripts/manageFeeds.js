function deleteFeed(feed_folder_id, parent)
{
    jQuery.ajax({
        type: 'POST',
        url: 'srvAjax/manageFeed.php',
        
        data : {
            action: "deleteFeed",
            id: feed_folder_id
        },
        
        success: function(data, textStatus, jqXHR) {
            
            console.log(data);
            /*if(data == "SUCCESS")
            {
                var html = $('body');
                html.append('<div class="informationBox info">Le dossier a été supprimé avec succès</div>');
                $('informationBox').toggleClass('animation');
            }
            else
            {
                var html = $('body');
                html.append(data);
                $('informationBox').toggleClass('animation');
            }*/
        },
        
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
			alert("Error manageFeed > deleteFeed");
		}
                
    });
}

function getDeleteFolderPopup(feedName, feedID)
{
    var data = '<h1>Désinscription du Feed : "';
    data += feedName;
    data += '"</h1>';
    
    data += '<div class="popup_content">';
    data += '<p>Voulez-vous vraiment vous désinscrire de ce Feed ?</p>';
    data += '</div>';
        
    data += '<span class="idFeedFolder hidden">';
    data += feedID;
    data += '</span>';
    
    data += '<p class="boutonStyle deleteFeedValidate">Supprimer</p>';
    data += '<p class="boutonStyle close_popup">Annuler</p>';
    
    return data;
}