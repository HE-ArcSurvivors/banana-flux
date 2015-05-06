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
                /*parent.parent().css("display","none");
                parent.parent().parent().find(".flux").css("display","none");*/
                
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
    var data = '<h1>Renommer un dossier</h1>';
    data += '<div class="popup_content"><label>Nom du dossier : <input type="text" id="folder_newname" name="folder_newname" value="';
    data += folderCurrentName;
    data += '" /></label></div>';
    data += '<span class="iddossier_hidden">';
    data += folderID;
    data += '</span>';
    data += '<p class="boutonStyle editFolderButton">Modifier</p>';
    data += '<p class="boutonStyle close_popup">Annuler</p>';
    
    $(id_popup).empty().append(data);
}