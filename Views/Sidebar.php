<div id="sidebar">
	<?php if(isset($user)) { ?>
	<div id="menu">
    	<div class="menu_item"><a href="?page=Start">Meine Neuigkeiten</a></div>
        <div class="menu_item"><a href="?page=Notification">Benachrichtigungen <?php if($viewBag["notificationsCount"] > 0) echo "(" . $viewBag["notificationsCount"] . ")"; ?></a></div>
    	<div class="menu_item"><a href="?page=Board">Meine Pinnwand</a></div>
        <div class="menu_item"><a href="?page=Friends">Meine Freunde</a></div>
        <div class="menu_item"><a href="?page=Start&action=logout">Abmelden</a></div>
	</div>
    <?php } else { ?>
    <div id="quick_login">
    	<form action="?page=Start&action=Login" method="post">
        	<div class="login_field">
            	<label for="email">E-Mail</label>
                <input class="text" name="email" id="email" type="text" size="15" />
            </div>
            <div class="login_field">
                <label for="password">Password</label>
                <input class="text" name="password" id="password" type="password" size="15" />
            </div>
            <div class="login_field">
                <div class="button_blue" id="quick_auth_button">
                    <button class="button_" style="width: 106px;" id="quick_login_button">Login</button>
                </div>
            </div>
		</form>
		<?php if(isset($viewBag["login_error"])) echo $viewBag["login_error"]; ?>
	</div>
    <?php } ?>
</div>