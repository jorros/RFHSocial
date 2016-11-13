<?php
include("Views/Header.php");
include("Views/Sidebar.php");
?>
<div class="content">
	<div class="content_name" style="height: 40px; background-color: #E9EDF1; font-weight: bold; color: #2b587a; padding-top: 10px; padding-left: 10px">
        <div style="float: left; width: 150px; height: 40px;">Meine Benachrichtigungen</div>
        <?php include("Views/SearchBar.php"); ?>
    </div>
    <div id="notification">
    	<?php 
		if(count($model) > 0)
		{
			foreach($model as $notification) { ?>
        <div class="notification_item <?php if(!$notification->seen) echo "highlighted"; ?>">
            <div class="photo_small">
                <img alt="Profilbild" style="width: 40px; height: 40px" src="Resources/ProfilePics/<?= $notification->sender->picture ?>.png">
            </div>
            <div class="friend_name">
                <a href="?page=Board&user=<?= $notification->sender->id ?>"><?= $notification->sender->firstname . " " . $notification->sender->lastname ?></a>
                <br>
                <div style="color: #999999; font-weight: bold"><?php switch($notification->type)
				{
					case 1:
					echo "hat einen Pin auf deiner Pinnwand hinterlassen";
					break;
					
					case 2:
					echo "gefällt ein Pin von dir";
					break;
					
					case 3:
					echo "missfällt ein Pin von dir";
					break;
					
					case 4:
					echo "möchte dich als Freund hinzufügen";
					break;
				}?></div>
            </div>
            <div class="short_pin_or_request"><?php switch($notification->type) 
			{
				case 1:
				echo 'Ein Pin wurde auf deiner Pinnwand hinterlassen<a style="text-decoration: none; font-weight: normal" href="?page=Notification&action=Pin&id=' . $notification->reference->id . '"> zum Pin</a>';
				break;
				
				case 2:
				echo 'Hier ist ein Pin, der dem anderen gefällt...<a style="text-decoration: none; font-weight: normal" href="?page=Notification&action=Pin&id=' . $notification->reference->id . '"> zum Pin</a>';
				break;
				
				case 3:
				echo 'Hier ist ein Pin, der dem anderen missfällt...<a style="text-decoration: none; font-weight: normal" href="?page=Notification&action=Pin&id=' . $notification->reference->id . '"> zum Pin</a>';
				break;
				
				case 4:
				if(in_array($notification->sender->id, $user->acceptedFriends))
					echo 'Du hast diese Anfrage bestätigt.';
				else if(in_array($notification->sender->id, $user->otherRequests))
					echo '<a style="color: green;" href="?page=Notification&action=AcceptRequest&id=' . $notification->reference . '">Zustimmen</a><br><a style="color: #ff5400" href="?page=Notification&action=DeclineRequest&id=' . $notification->reference . '">Absagen</a>';
				else
					echo 'Du hast diese Anfrage nicht bestätigt.';
				break;
			} ?></div>
            <div class="date"><?= date("d.m.Y H:i", $notification->timestamp) ?></div>
        </div>
        <?php }
		} else echo "Du hast keine Benachrichtigungen";
		 ?>
    </div>
</div>

<?php include("Views/Footer.php"); ?>

