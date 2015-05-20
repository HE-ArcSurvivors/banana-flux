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
            
            if(data == "SUCCESS")
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
			alert("Error manageFolders > eleteFolder");
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
            if(data == "SUCCESS")
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
			alert("Error manageFolders > editFolder");
		}      
    });
}

function createFolder(folder_new_name)
{   
    jQuery.ajax({
        type: 'POST',
        url: 'srvAjax/manageFolders.php',
        
        data : {
            action: "addFolder",
            folder_name: folder_new_name
        },
        
        success: function(data, textStatus, jqXHR) {
            if(data == "SUCCESS")
            {               
                var html = $('body');
                html.append('<div class="informationBox info">Le dossier a été ajouté avec succès</div>');
                $('informationBox').toggleClass('animation');
            }
            else
            {
                console.log(data);
            }
        },
        
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
			alert("Error manageFolders > newFolder");
		}      
    });
}

function getEditFolderPopup(folderCurrentName, folderID)
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
    return data;
}

function getDeleteFolderPopup(folderName, folderID)
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
    
    return data;
}

function getNewFolderPopup()
{
    var data = '<h1>Ajouter un nouveau dossier</h1>';
    
    data += '<div class="popup_content">';
    
    data += '<div class="popup_content"><p><label>Nom du dossier : ';
    data += '<input type="text" id="folder_newname" name="folder_newname"/>';
    data += '</label></p></div>';
    
    data += '<p class="boutonStyle createFolderValidate">Créer</p>';
    data += '<p class="boutonStyle close_popup">Annuler</p>';
    
    return data;
}