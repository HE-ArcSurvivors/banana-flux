function getEditProfilePopup(id_popup)
{
    jQuery.ajax({
        type: 'POST',
        url: 'srvAjax/manageProfile.php',
        
        data : {
            action: "printForm",
        },
        
        success: function(data, textStatus, jqXHR) {
            
            $(id_popup).empty().append(data);

            var html = $('body');
            html.append('<div class="informationBox info">OK</div>');
            $('informationBox').toggleClass('animation');
        },
        
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
			alert("Error manageProfile > getEditProfilePopup");
		}
                
    });

    
}