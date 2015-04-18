<?php 
require "header.php";

if(isset($_SESSION["login"]))
{
    $user = new User($db);

    if(isset($_POST["formValidated"]))
    {
        if($_POST["newEmail"] != "null")
        {
            $user->editEmail($_POST["newEmail"]);
        }
    }
    
    $user->printUser();
?>

<LINK href="style2.css" rel="stylesheet" type="text/css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" type="text/javascript" charset="utf-8"></script>
<script src="jquery.jeditable.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript" charset="utf-8">
    
$(function() {
    
    var email;
  
  $(".click").editable(function(value, settings) {
     document.getElementById("newEmail").value = value; 
     console.log(this);
     console.log(value);
     console.log(settings);
     return(value);
  }, { 
      indicator : "<img src='img/indicator.gif'>",
      tooltip   : "Click to edit...",
      style  : "inherit"
  });
    
});
</script>

    <div id="profil">
        <h1>Mon profil</h1> 
        <img src="http://wallpapers55.com/wp-content/uploads/2014/04/artistic-adore-red-panda-wallpaper-150x150.jpg" width="150" height="150" class="image"/>
        <table class="text">
            <tr>
                <td><?php echo $lang["FORM_EDIT_USERNAME_TITLE"]; ?> : </td>
                <td><?php echo $user->getUsername(); ?></td>
            </tr>
            <tr>
                <td><?php echo $lang["FORM_EDIT_EMAIL_TITLE"]; ?> : </td>
                <td class="click"><?php echo $user->getEmail(); ?></td>
            </tr> 
            <tr>
                <td><?php echo $lang["FORM_EDIT_PASSWORD_TITLE"]; ?> : </td>
                <td class="click"></td>
            </tr> 
            <tr>
                <td>
                    <?php echo $lang["FORM_EDIT_ICON_TITLE"]; ?> : </td>
                    <td><?php echo $lang["FORM_EDIT_ICON_UNAVAILABLE"]; ?></td>
            </tr> 
        </table>
        <div class="buttonSubmit">
                    <form method="post" name="editProfileForm" action="<?php echo $self_url; ?>">
                    <input type="submit" value="Valider les modifications"/>
                    <input type="hidden" name="formValidated" value="1" />
                    <input type="hidden" name="newEmail" id="newEmail" value="null" />
                    </form>
        </div>

</div>

<?php   
}
?>