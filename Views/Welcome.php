<?php
include("Views/Header.php");
include("Views/Sidebar.php");
?>
    <div class="content">
        <div class="content_name">
            Herzlich Willkommen!
        </div>
        <div id="registration">
            <h3>Registrierung</h3>
        </div>
        <form action="?page=Start&action=Register" method="post">
            <div id="reg_form">

                <table>
                    <tr>
                        <td><label for="firstname">Vorname</label></td>
                        <td><input class="text" id="firstname" name="firstname" type="text" size="15" /></td>
                    </tr>
                    <tr>
                        <td><label for="lastname">Nachname</label></td>
                        <td><input class="text" id="lastname" name="lastname" type="text" size="15" /></td>
                    </tr>
                    <tr>
                        <td><label for="register_email">E-Mail</label></td>
                        <td><input class="text" id="register_email" name="register_email" type="text" size="15" /></td>
                    </tr>
                    <tr>
                        <td><label for="register_password">Password</label></td>
                        <td><input class="text" id="register_password" name="register_password" type="password" size="15" /></td>
                    </tr>
                    <tr>
                        <td><label for="retry_password">Password wiederholen</label></td>
                        <td><input class="text" id="retry_password" name="retry_password" type="password" size="15" /></td>
                    </tr>
                </table>
                <div class="button_blue" id="registrieren">
                    <button class="button_" style="width: 106px;" id="registrieren_button">Registrieren</button>
                </div>
            </div>
            <?php if(isset($viewBag["register_error"])) echo "<script type=\"text/javascript\">alert('".$viewBag['register_error']."')</script>" ?>
        </form>
    </div>
<?php include("Views/Footer.php"); ?>