<?php
include("Views/Header.php");
include("Views/Sidebar.php");
?><div id="feed">
<div class="content">
	<div class="content_name" style="height: 40px; background-color: #E9EDF1; font-weight: bold; color: #2b587a; padding-top: 10px; padding-left: 10px">
        <div style="float: left; width: 150px; height: 40px;">Meine Neuigkeiten</div>
        <?php include("Views/SearchBar.php"); ?>
    </div>
    <!-- Hier sind die Neuigkeiten -->
    <form id="post_pin" action="?page=Start&action=PostPin" method="POST">
        <div id="new_pin">
            <div id="textform">
                <textarea id="post_content" name="content" onclick="resetPostPin()" onblur="checkPostPin()" rows="5" cols="100">Was gibt's neues?</textarea>
            </div>
            <div id="button_panel">
                <div class="button_blue" id="send_pin" style="float: right">
                    <button class="button_" style="width: 106px;" id="send_pin_button">Anpinnen!</button>
                </div>
            </div>
        </div>
    </form>
    <?php 
    if(!isset($model))
        echo "Keine Pins in deinem Feed. Such dir Freunde!";
    else
        foreach($model as $pin) {	
    ?>
    <div id="pin_<?= $pin->id ?>" class="article">
        <div id="like_buttons" class="article_buttons"><?php if(array_key_exists($user->id, $pin->likes) || array_key_exists($user->id, $pin->dislikes)) { ?><a class="clickable" onclick="unlike(<?= $pin->id ?>)">Zurücknehmen</a><?php } else { ?><a onclick="like(<?= $pin->id ?>)" class="like clickable"></a><a class="dislike clickable" onclick="dislike(<?= $pin->id ?>)"></a><?php } ?></div>
        <div class="picture">
            <img alt="Profilbild" src="Resources/ProfilePics/<?= $pin->fromUser->picture ?>.png" style="width: 80px; height: 80px;">
        </div>
        <div class="owner_name">
            <a href="?page=Board&user=<?= $pin->fromUser->id ?>"><?= $pin->fromUser->firstname . " " . $pin->fromUser->lastname ?></a>
            <?php if($pin->fromUser->id != $pin->toUser->id) { ?>
            => <a href="?page=Board&user=<?= $pin->toUser->id ?>"><?= $pin->toUser->firstname . " " . $pin->toUser->lastname ?></a>
            <?php } ?>
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
    <div class="popup__overlay" onclick="closePopup();"></div>
        <div class="popup">
            <div id="who_liked" title="Who liked it">
                <div id="popup_header_liked">Diese Leute haben es geliked:</div>
                <div id="popup_header_disliked">Diese Leute haben es disliked:</div>
                <div id="who_liked_list"></div>
            </div>
    	</div>
</div>
</div>
<?php include("Views/Footer.php"); ?>

