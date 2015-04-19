<?php 
require "header.php";

if(isset($_SESSION["login"]))
{
    $user = new User($db, $lang);
    $user->connect();

    if(isset($_POST["formValidated"]))
    {
        if(isset($_POST["email"]))
        {
            $email = htmlentities($_POST["email"]);
            if(!isEqual($user->getEmail(),$email))
            {
                if($user->editEmail($email))
                {
                    echo '<div class="informationBox info">';
                    echo $lang["EDIT_EMAIL_SUCCESS"];
                    echo '</div>';
                }
                /*else
                {
                    echo '<div class="informationBox warning">';
                    echo $lang["EDIT_EMAIL_UNSUCCESS"];
                    echo '</div>';
                }*/
            }
        }
        
        if(isset($_POST["passwordNEW"]))
        {
            $passwordNEW = htmlentities($_POST["passwordNEW"]);
            $passwordRepeat = htmlentities($_POST["passwordRepeat"]);
            $passwordOLD = htmlentities($_POST["passwordOLD"]);
            
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

<html>
<head>
    <title>Banana Flux - Welcome</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"></meta>
</head>
<link href="style2.css" rel="stylesheet" type="text/css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" type="text/javascript" charset="utf-8"></script>
<script src="scripts/modernizr.custom.js"></script>
<script type="text/javascript" charset="utf-8">

    var formLoaded = false;
    
    function loadForm()
    { 
        if(!formLoaded) 
        {
            $('.formContent').css('display', 'none');
            $('.formEdit').css('display', 'table-cell');
            $('.formEditRow').css('display','table-row');
        }
        else
        {
            $('.formContent').css('display', 'table-cell');
            $('.formEdit').css('display', 'none');
            $('.formEditRow').css('display','none');
        }
        formLoaded = !formLoaded;
    }
</script>
<body>

    <div id="profil">

        <h1>Mon profil
            <img class="editButton" onclick="loadForm()" width="20" height="20" src="http://www.lastrose.com/media/iconmonstr-edit-10-icon-300x300.png" /></h1> 
        <img src="<?php echo $user->getIcon(); ?>" width="150" height="150" class="image"/>
        <form method="post" name="editProfileForm" action="<?php echo $self_url; ?>">
            <table class="text">
            <tr>
                <td><?php echo $lang["FORM_EDIT_USERNAME_TITLE"]; ?> : </td>
                <td><?php echo $user->getUsername(); ?></td>
            </tr>
            <tr>
                <td><?php echo $lang["FORM_EDIT_EMAIL_TITLE"]; ?> : </td>
                <td>
                    <p class="formContent"><?php echo $user->getEmail(); ?></p>
                    <input class="formEdit inputText" type="text" value="<?php echo $user->getEmail(); ?>" id="email" name="email" />
                </td>
            </tr> 
            <tr class="formEditRow">
                <td colspan="2" class="formEdit"><?php echo $lang["FORM_EDIT_PASSWORD_TITLE"]; ?> : </td>
            </tr>
            <tr class="formEditRow">
                <td class="formEdit"><?php echo $lang["FORM_EDIT_PASSWORD_OLD_TITLE"]; ?> : </td>
                <td class="formEdit"><input class="inputText" type="password" id="passwordOLD" name="passwordOLD" /></td>
            </tr>
            <tr class="formEditRow">
                <td class="formEdit"><?php echo $lang["FORM_EDIT_PASSWORD_NEW_TITLE"]; ?> : </td>                
                <td class="formEdit"><input class="inputText" type="password" id="passwordNEW" name="passwordNEW" /></td>
            </tr>
            <tr class="formEditRow">
                <td class="formEdit"><?php echo $lang["FORM_EDIT_PASSWORD_REPEAT_TITLE"]; ?> : </td>         
                <td class="formEdit"><input class="inputText" type="password" id="passwordRepeat" name="passwordRepeat" /></td>         
            <tr>
                <td><?php echo $lang["FORM_EDIT_ICON_TITLE"]; ?> : </td>
                <td><?php echo $lang["FORM_EDIT_ICON_UNAVAILABLE"]; ?></td>
            </tr>
            <tr class="buttonSubmit">
                <td colspan="2"><input class="formEdit" type="submit" value="<?php echo $lang["FORM_EDIT_VALIDATE"]; ?>"/></td>
                <input type="hidden" name="formValidated" value="1" />
            </tr>
        </table>
        </form>

</div>
</body>
</html>

<?php   
}
?>