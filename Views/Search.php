<?php
include("Views/Header.php");
include("Views/Sidebar.php");
?>
<div class="content">
    <div class="content_name" style="height: 40px; background-color: #E9EDF1; font-weight: bold; color: #2b587a; padding-top: 10px; padding-left: 10px">
        <div style="float: left; width: 150px; height: 40px;">Suchergebnis</div>
        <?php include("Views/SearchBar.php"); ?>
    </div>
    <div id="search_result">
        <div id="search_result_header">
            Suchergebnis: <?= count($model) ?> Person<?php if(count($model) != 1) echo "en" ?> wurde<?php if(count($model) != 1) echo "n" ?> gefunden
        </div>
        <?php foreach($model as $result) { ?>
        <div class="search_result_item">
            <div class="photo_small">
                <img src="Resources/ProfilePics/<?= $result->picture ?>.png" width="40" height="40"/>
            </div>
            <div class="profile_info">
                <a href="?page=Board&user=<?= $result->id ?>"><?= $result->firstname . " " . $result->lastname ?></a>
                <div><?= $result->location ?></div>
                <div style="float: right"><?php if(!in_array($result->id, $user->acceptedFriends)) { ?>
					<?php if(in_array($result->id, $user->otherRequests)) { ?>
                    	<div style="margin-bottom: 4px"><a class="clickable" onclick="setFriend(<?= $result->id ?>, this)">Freundschaftsanfrage annehmen</a></div>
                    <?php } else if(in_array($result->id, $user->yourRequests)) { ?>
                    	<div style="margin-bottom: 4px"><a class="clickable" onclick="setFriend(<?= $result->id ?>, this)">Freundschaftsanfrage zurückziehen</a></div>
                    <?php } else { ?>
                    	<div style="margin-bottom: 4px"><a class="clickable" onclick="setFriend(<?= $result->id ?>, this)">Als Freund hinzufügen</a></div>
                    <?php } } else { ?>
                    	<div style="margin-bottom: 4px"><a class="clickable" onclick="setFriend(<?= $result->id ?>, this)">Freundschaft zurückziehen</a></div>
                        <?php } ?>
                    </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<?php include("Views/Footer.php"); ?>

