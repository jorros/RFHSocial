		<div id="profile_pinnwand">
            <div class="header_1"><?php if($viewBag["user"]->id == $user->id) echo "M"; else echo "S"; ?>eine Pinwand</div>
            <?php
            if(!isset($model["pins"]))
			{
				if($viewBag["user"]->id == $user->id)
            		echo "Zurzeit befinden sich keine Pins auf deiner Pinnwand!";
				else
					echo "Zurzeit befinden sich keine Pins auf seiner Pinnwand!";
			}
            else
            foreach($model["pins"] as $pin) {
            ?>
            <div id="pin_<?= $pin->id ?>" class="article">
                <div id="like_buttons" class="article_buttons"><?php if(array_key_exists($user->id, $pin->likes) || array_key_exists($user->id, $pin->dislikes)) { ?><a class="clickable" onclick="unlike(<?= $pin->id ?>)">Zurücknehmen</a><?php } else { ?><a class="like clickable" onclick="like(<?= $pin->id ?>)"></a><a class="dislike clickable" onclick="dislike(<?= $pin->id ?>)"></a><?php } ?></div>
                <div class="picture">
                    <img alt="Profilbild" src="Resources/ProfilePics/<?= $pin->fromUser->picture ?>.png" style="width: 80px; height: 80px;">
                </div>
                <div class="owner_name">
                    <a href="?page=Board&user=<?= $pin->fromUser->id ?>"><?= $pin->fromUser->firstname . " " . $pin->fromUser->lastname ?></a>
                </div>
                <div class="content_pin">
                    <?= $pin->content ?>
                </div>
                <div class="date">
                    <div id="like" class="likes_count" onclick="showLikedList(<?= $pin->id ?>);"><?= "<div class=\"likes_count_number\">" . count($pin->likes) . "</div> Personen haben das geliked" ?></div>
                    <div id="dislike" class="likes_count" onclick="showDislikedList(<?= $pin->id ?>)"><?= "<div class=\"likes_count_number\">" . count($pin->dislikes) . "</div>Personen haben das disliked " ?></div>
                    <?= date("d.m.Y H:i", $pin->timestamp) ?>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="popup__overlay" onclick="closePopup();"></div>
        <div class="popup">
            <div id="who_liked" title="Who liked it">
                <div id="popup_header_liked">Diese Leute haben es geliked:</div>
                <div id="popup_header_disliked">Diese Leute haben es disliked:</div>
                <div id="who_liked_list"></div>
            </div>
    	</div>