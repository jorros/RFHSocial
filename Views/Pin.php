<?php
include("Views/Header.php");
include("Views/Sidebar.php");
?>
<div class="content">
	<div class="content_name" style="height: 40px; background-color: #E9EDF1; font-weight: bold; color: #2b587a; padding-top: 10px; padding-left: 10px">
        <div style="float: left; width: 150px; height: 40px;">Meine Neuigkeiten</div>
        <?php include("Views/SearchBar.php"); ?>
    </div>
    <?php 
    if(!isset($model))
        echo "Pin existiert nicht mehr.";
    else
    {	
    ?>
    <div id="pin_<?= $model->id ?>" class="article">
        <div id="like" class="article_buttons"><?php if(array_key_exists($user->id, $model->likes) || array_key_exists($user->id, $model->dislikes)) { ?><a onclick="unlike(<?= $model->id ?>)" href="#">Zurücknehmen</a><?php } else { ?><a onclick="like(<?= $model->id ?>)" class="like" href="#"></a><a class="dislike" onclick="dislike(<?= $model->id ?>)" href="#"></a><?php } ?></div>
        <div class="picture">
            <img alt="Profilbild" src="Resources/ProfilePics/<?= $model->fromUser->picture ?>.png" style="width: 80px; height: 80px;">
        </div>
        <div class="owner_name">
            <a href="?page=Board&user=<?= $model->fromUser->id ?>"><?= $model->fromUser->firstname . " " . $model->fromUser->lastname ?></a>
            <?php if($model->fromUser->id != $model->toUser->id) { ?>
            => <a href="?page=Board&user=<?= $model->toUser->id ?>"><?= $model->toUser->firstname . " " . $model->toUser->lastname ?></a>
            <?php } ?>
        </div>
        <div class="content_pin">
            <?= $model->content ?>
        </div>
        <div class="date">
            <div id="like" class="likes_count" onclick="showLikedList(<?= $model->id ?>);"><?= "<div class=\"likes_count_number\">" . count($model->likes) . "</div> Personen haben das geliked" ?></div>
            <div id="dislike" class="likes_count" onclick="showDislikedList(<?= $model->id ?>)"><?= "<div class=\"likes_count_number\">" . count($model->dislikes) . "</div>Personen haben das disliked " ?></div>
            <?= date("d.m.Y H:i", $model->timestamp) ?>
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

<?php include("Views/Footer.php"); ?>

