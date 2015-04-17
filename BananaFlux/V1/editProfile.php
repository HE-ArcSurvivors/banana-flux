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
    
    echo 'Formulaire:<br/>';
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

    <table>
            <tr>
                <td><label for="id">
                    <?php echo $lang["FORM_EDIT_EMAIL_TITLE"]; ?> : </label></td>
                <td class="click"><?php echo $user->getEmail(); ?></td>
            </tr>  
            <tr>
                <td>
                    <form method="post" name="editProfileForm" action="<?php echo $self_url; ?>">
                    <input type="submit" />
                    <input type="hidden" name="formValidated" value="1" />
                    <input type="hidden" name="newEmail" id="newEmail" value="null" />
                    </form>
                </td>
            </tr>
    </table>


<?php   
}
?>