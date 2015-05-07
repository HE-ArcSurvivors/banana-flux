<?php
    require_once "../header.php";
	
	$action = htmlentities($_POST['action']);
	
    if(isset($_SESSION["login"]))
    {
        $user = new User($db, $lang);
        $user->loadUser();
    }
    else
    {
        header('Location: index.php');
    }
    
    if($action == "print")
    {
?>

<h1>Mon profil</h1> 

<img src="<?php echo $user->getIcon(); ?>" width="150" height="150" class="imageProfile"/>

<form method="post" name="editProfileForm" action="<?php echo $self_url; ?>">
    <table class="text">
    <tr>
        <td><?php echo $lang["FORM_EDIT_USERNAME_TITLE"]; ?> : </td>
        <td><?php echo $user->getUsername(); ?></td>
    </tr>
    <tr>
        <td><?php echo $lang["FORM_EDIT_EMAIL_TITLE"]; ?> : </td>
        <td>
            <input class="formEdit inputText" type="text" value="<?php echo $user->getEmail(); ?>" id="email" name="email" />
        </td>
    </tr> 
    <tr>
        <td colspan="2"><?php echo $lang["FORM_EDIT_PASSWORD_TITLE"]; ?> : </td>
    </tr>
    <tr>
        <td><?php echo $lang["FORM_EDIT_PASSWORD_OLD_TITLE"]; ?> : </td>
        <td><input class="inputText" type="password" id="passwordOLD" name="passwordOLD" /></td>
    </tr>
    <tr>
        <td><?php echo $lang["FORM_EDIT_PASSWORD_NEW_TITLE"]; ?> : </td>                
        <td><input class="inputText" type="password" id="passwordNEW" name="passwordNEW" /></td>
    </tr>
    <tr>
        <td><?php echo $lang["FORM_EDIT_PASSWORD_REPEAT_TITLE"]; ?> : </td>         
        <td><input class="inputText" type="password" id="passwordRepeat" name="passwordRepeat" /></td>         
    <tr>
        <td><?php echo $lang["FORM_EDIT_ICON_TITLE"]; ?> : </td>
        <td><?php echo $lang["FORM_EDIT_ICON_UNAVAILABLE"]; ?></td>
    </tr>
        <input type="hidden" name="formValidated" value="1" />
    </table>
</form>    

<p class="boutonStyle editProfileValidate"><?php echo $lang["FORM_EDIT_VALIDATE"]; ?></p>
<p class="boutonStyle close_popup">Annuler</p>


<?php
    }
    else if($action == "edit")
    {
        $email = htmlentities($_POST['email']);
        if(!isEqual($user->getEmail(),$email))
        {
            if($user->editEmail($email))
            {
                echo '<div class="informationBox info">';
                echo $lang["EDIT_EMAIL_SUCCESS"];
                echo '</div>';
            }
            else
            {
                echo '<div class="informationBox warning">';
                echo $lang["EDIT_EMAIL_UNSUCCESS"];
                echo '</div>';
            }
        }

        $passwordNEW = htmlentities($_POST["passwordNEW"]);
        $passwordRepeat = htmlentities($_POST["passwordRepeat"]);
        $passwordOLD = htmlentities($_POST["passwordOLD"]);
        
        if($passwordNEW != "")
        {
            if(isEqual($passwordNEW,$passwordRepeat))
            {
                if($user->editPass($passwordOLD,$passwordNEW))
                {
                    echo '<div class="informationBox info">';
                    echo $lang["EDIT_PASSWORD_SUCCESS"];
                    echo '</div>'; 
                }
            }
            else
            {
                echo '<div class="informationBox warning">';
                echo $lang["EDIT_PASSWORD_NEW_NOTEQUAL"];
                echo '</div>';
            }
        }
    }

?>