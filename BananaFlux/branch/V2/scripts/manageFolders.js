function deleteFolder(id_dossier, parent)
{
    console.log(id_dossier);
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
                var html = $('body');
                html.append('<div class="informationBox info">Le dossier a été modifié avec succès</div>');
                $('informationBox').toggleClass('animation');
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

function getEditFolderPopup(id_popup, folderCurrentName, folderID)
{
    var data = '<h1>Renommer "';
    data += folderCurrentName;
    data+= '"</h1>';
    data += '<div class="popup_content"><p><label>Nom du dossier : <input type="text" id="folder_newname" name="folder_newname" value="';
    data += folderCurrentName;
    data += '" /></label></p></div>';
    data += '<span class="iddossier_hidden">';
    data += folderID;
    data += '</span>';
    data += '<p class="boutonStyle editFolderButton">Modifier</p>';
    data += '<p class="boutonStyle close_popup">Annuler</p>';
    
    $(id_popup).empty().append(data);
}

function getDeleteFolderPopup(id_popup, folderName, folderID)
{
    var data = '<h1>Supprimer "';
    data += folderName;
    data += '"</h1>';
    
    data += '<div class="popup_content">';
    data += '<p>Voulez-vous vraiment supprimer le dossier ';
    data += folderName;
    data += ' ?</p>';
    data += '<p><b>ATTENTION !</b> Vous serez désinscrit de tous les flux contenus dans le dossier!</p>';
        
    data += '<span class="iddossier_hidden">';
    data += folderID;
    data += '</span>';
    
    data += '<p class="boutonStyle deleteFolderValidate">Supprimer</p>';
    data += '<p class="boutonStyle close_popup">Annuler</p>';
    
    $(id_popup).empty().append(data);
}