<?php
include("Views/Header.php");
include("Views/Sidebar.php");
?>
<div class="content">
	<div class="content_name">
        <div style="float: left; width: 150px; height: 40px;"><?= $viewBag["user"]->firstname . " " . $viewBag["user"]->lastname ?></div>
        <?php include("Views/SearchBar.php"); ?>
    </div>

    <div id="profile_page">
        <div id="profile_sidebar">
            <div id="profile_photo">
                <img alt="Profilbild" src="Resources/ProfilePics/<?= $viewBag["user"]->picture ?>.png" width="200" height="200"/>
            </div>
            <div id="profile_friends">
                <div class="header_1">
                    <?php if($viewBag["user"]->id == $user->id) echo "M"; else echo "S"; ?>eine Freunde: <?= count($model["friends"]) ?>
                </div>
                <div id="friend_list">
                    <?php
                    foreach($model["friends"] as $friend) {
                    ?>
                    <div class="friend_item">
                        <div class="photo_small">
                            <img alt="Profilbild" src="Resources/ProfilePics/<?= $friend->picture ?>.png" style="width: 40px; height: 40px">
                        </div>
                        <div class="friend_name">
                            <a href="?page=Board&user=<?= $friend->id ?>"><?= $friend->firstname . " " . $friend->lastname ?></a><br>
                            <?php echo "<div style=\"color: #999999;\">" . $friend->location . "</div>" ?>
                        </div>
                    </div> <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <div id="profile_content">
            <div id="profile_name">
                <?= $viewBag["user"]->firstname . " " . $viewBag["user"]->lastname ?>
            </div>
            <div id="profile_info">
                <table>
                	<?php if($viewBag["user"]->gender > 0) { ?>
                    <tr>
                        <td><div class="info_description">Geschlecht</div></td>
                        <td><div class="info_content"><?php if($viewBag["user"]->gender == 1) echo "Männlich"; else echo "Weiblich"; ?></div></td>
                    </tr>
                    <?php } ?>
                	<?php if($viewBag["user"]->location != "") { ?>
                    <tr>
                        <td><div class="info_description">Ort</div></td>
                        <td><div class="info_content"><?= $viewBag["user"]->location ?></div></td>
                    </tr>
                    <?php } ?>
                    <?php if($viewBag["user"]->birthdate != "") { ?>
                    <tr>
                        <td><div class="info_description">Geburtstag</div></td>
                        <td><div class="info_content"><?= date("d.m.Y", strtotime($viewBag["user"]->birthdate)) ?></div></td>
                    </tr>
                    <?php } ?>
                    <?php if($viewBag["user"]->course != "") { ?>
                    <tr>
                        <td><div class="info_description">Studiengang</div></td>
                        <td><div class="info_content"><?= $viewBag["user"]->course ?></div></td>
                    </tr>
                    <?php } ?>
                    <?php if($viewBag["user"]->type > 0) { ?>
                    <tr>
                        <td><div class="info_description">Studienform</div></td>
                        <td><div class="info_content"><?php if($viewBag["user"]->type == 1) echo "Vollzeit"; else echo "Teilzeit"; ?></div></td>
                    </tr>
                    <?php } ?>
                    <?php if($viewBag["user"]->expectedGraduation > 0) { ?>
                    <tr>
                        <td><div class="info_description">Voraussichtliches Ende</div></td>
                        <td><div class="info_content"><?= $viewBag["user"]->expectedGraduation ?></div></td>
                    </tr>
                    <?php } ?>
                    <?php if($viewBag["user"]->favouriteBooks != "") { ?>
                    <tr>
                        <td><div class="info_description">Lieblingsbücher</div></td>
                        <td><div class="info_content"><?= $viewBag["user"]->favouriteBooks ?></div></td>
                    </tr>
                    <?php } ?>
                    <?php if($viewBag["user"]->employer != "") { ?>
                    <tr>
                        <td><div class="info_description">Arbeitgeber</div></td>
                        <td><div class="info_content"><?= $viewBag["user"]->employer ?></div></td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
            <div id="sub_block">
                <?php if($viewBag["user"]->id == $user->id) { ?>
                    <div style="margin-bottom: 4px"><a href="?page=Board&action=Edit">Eigenes Profil ändern</a></div>
                <?php } else if(!in_array($viewBag["user"]->id, $user->acceptedFriends)) { ?>
                	<?php if(in_array($viewBag["user"]->id, $user->otherRequests)) { ?>
                    	<div style="margin-bottom: 4px"><a class="clickable" onclick="setFriend(<?= $viewBag["user"]->id ?>, this)">Freundschaftsanfrage annehmen</a></div>
                    <?php } else if(in_array($viewBag["user"]->id, $user->yourRequests)) { ?>
                    	<div style="margin-bottom: 4px"><a class="clickable" onclick="setFriend(<?= $viewBag["user"]->id ?>, this)">Freundschaftsanfrage zurückziehen</a></div>
                    <?php } else { ?>
                    	<div style="margin-bottom: 4px"><a class="clickable" onclick="setFriend(<?= $viewBag["user"]->id ?>, this)">Als Freund hinzufügen</a></div>
                    <?php } } else { ?>
                    	<div style="margin-bottom: 4px"><a class="clickable" onclick="setFriend(<?= $viewBag["user"]->id ?>, this)">Freundschaft zurückziehen</a></div>
                    <?php } ?>
                <div style="font-weight: bold;">Profil erstellt am:</div>
                <div><?= date("d.m.Y", $viewBag["user"]->created) ?></div>
            </div>
            <div id="new_pin_profile">
            <?php if($viewBag["user"]->id == $user->id || in_array($viewBag["user"]->id, $user->acceptedFriends)) { ?>
                <form id="post_pin" action="?page=Board&action=PostPin" method="POST">
                    <div id="new_pin">
                        <div id="textform">
                            <textarea id="post_content" name="content" onclick="resetPostPin()" onblur="checkPostPin()" rows="5" cols="68">Was gibt's neues?</textarea>
                            <input type="hidden" name="user" value="<?= $viewBag["user"]->id ?>" />
                        </div>
                        <div id="button_panel">
                            <div class="button_blue" id="send_pin" style="float: right">
                                <button class="button_" style="width: 106px;" id="send_pin_button">Anpinnen!</button>
                            </div>
                        </div>
                    </div>
                </form>
             <?php } ?>
            </div>
        </div>
        <?php include("Views/Pinboard.php"); ?>
    </div>
</div>

<?php include("Views/Footer.php"); ?>
