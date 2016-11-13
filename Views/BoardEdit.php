<?php
include("Views/Header.php");
include("Views/Sidebar.php");
?>
<div class="content">
	<div class="content_name" style="height: 40px; background-color: #E9EDF1; font-weight: bold; color: #2b587a; padding-top: 10px; padding-left: 10px">
        <div style="float: left; width: 150px; height: 40px;"><?= $user->firstname . " " . $user->lastname ?></div>
        <?php include("Views/SearchBar.php"); ?>
    </div>

    <div id="profile_page">
        <div id="profile_sidebar">
            <div id="profile_photo">
                <img alt="Profilbild" src="Resources/ProfilePics/<?= $user->picture ?>.png" width="200" height="200"/>
            </div>
            <div id="profile_friends">
                <div class="header_1">
                    Meine Freunde: <?= count($model["friends"]) ?>
                </div>
                <div id="friend_list">
                    <?php
                    foreach($model["friends"] as $friend) {
                    ?>
                    <div class="friend_item">
                        <div class="photo_small">
                            <img alt="Profilbild" src="Resources/ProfilePics/<?= $friend->picture ?>.png" width="40" height="40">
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
                <?= $user->firstname . " " . $user->lastname ?>
            </div>
            <form action="?page=Board&action=Save" method="POST">
            	<div id="profile_info">
                    <table>
                        <tr>
                            <td><div class="info_description">Geschlecht</div></td>
                            <td><div class="info_content"><select name="gender">
                                        <option value="0">Geschlecht</option>
                                        <option <?php if($user->gender == 1) echo "selected" ?> value="1">männlich</option>
                                        <option <?php if($user->gender == 2) echo "selected" ?> value="2">weiblich</option>
                                    </select></div></td>
                        </tr>
                        <tr>
                            <td><div class="info_description">Vorname</div></td>
                            <td><div class="info_content"><input name="firstname" type="text" value="<?= $user->firstname ?>"/> </div></td>
                        </tr>
                        <tr>
                            <td><div class="info_description">Nachname</div></td>
                            <td><div class="info_content"><input name="lastname" type="text" value="<?= $user->lastname ?>"/> </div></td>
                        </tr>
                        <tr>
                            <td><div class="info_description">Ort</div></td>
                            <td><div class="info_content"><input name="location" type="text" value="<?= $user->location ?>"/> </div></td>
                        </tr>
                        <tr>
                            <td><div class="info_description">Geburtstag</div></td>
                            <td><div class="info_content"><input name="birthdate" type="text" value="<?= date("d.m.Y", strtotime($user->birthdate)) ?>"/> </div></td>
                        </tr>
                        <tr>
                            <td><div class="info_description">Studiengang</div></td>
                            <td><div class="info_content"><select name="course">
                            <option value="">Studiengang</option>
                            <option <?php if($user->course == "Wirtschaftsinformatik") echo "selected" ?> value="Wirtschaftsinformatik">Wirtschaftsinformatik</option>
                            <option <?php if($user->course == "Elektrotechnik") echo "selected" ?> value="Elektrotechnik">Elektrotechnik</option>
                            <option <?php if($user->course == "Maschinenbau") echo "selected" ?> value="Maschinenbau">Maschinenbau</option>
                            <option <?php if($user->course == "Wirtschaftsingenieurwesen") echo "selected" ?> value="Wirtschaftsingenieurwesen">Wirtschaftsingenieurwesen</option>
                            <option <?php if($user->course == "Mediendesign") echo "selected" ?> value="Mediendesign">Mediendesign</option>
                            <option <?php if($user->course == "Medienwirtschaft") echo "selected" ?> value="Medienwirtschaft">Medienwirtschaft</option>
                            <option <?php if($user->course == "Medizinökonomie") echo "selected" ?> value="Medizinökonomie">Medizinökonomie</option>
                            <option <?php if($user->course == "Betriebswirtschaftslehre") echo "selected" ?> value="Betriebswirtschaftslehre">Betriebswirtschaftslehre</option>
                            <option <?php if($user->course == "Wirtschaftspsychologie") echo "selected" ?> value="Wirtschaftspsychologie">Wirtschaftspsychologie</option>
                            <option <?php if($user->course == "Wirtschaftsrecht") echo "selected" ?> value="Wirtschaftsrecht">Wirtschaftsrecht</option>
                        </select></div></td>
                        </tr>
                        <tr>
                            <td><div class="info_description">Studienform</div></td>
                            <td><div class="info_content"><select name="type">
                                                            <option value="0">Studienform</option>
                                                            <option <?php if($user->type == 1) echo "selected" ?> value="1">Vollzeit</option>
                                                            <option <?php if($user->type == 2) echo "selected" ?> value="2">Teilzeit</option>
                                                          </select> </div></td>
                        </tr>
                        <tr>
                            <td><div class="info_description">Voraussichtliches Ende</div></td>
                            <td><div class="info_content"><input name="expectedGraduation" type="text" value="<?= $user->expectedGraduation ?>"/> </div></td>
                        </tr>
                        <tr>
                            <td><div class="info_description">Lieblingsbücher</div></td>
                            <td><div class="info_content"><input name="favouriteBooks" type="text" value="<?= $user->favouriteBooks ?>"/> </div></td>
                        </tr>
                        <tr>
                            <td><div class="info_description">Arbeitgeber</div></td>
                            <td><div class="info_content"><input name="employer" type="text" value="<?= $user->employer ?>"/></div></td>
                        </tr>
                        <tr>
                            <td><div class="info_description">Passwort ändern</div></td>
                            <td><div class="info_content"><input name="password" type="password" value=""/></div></td>
                        </tr>
                        <tr>
                            <td><div class="info_description">Passwort wiederholen</div></td>
                            <td><div class="info_content"><input name="password2" type="password" value=""/></div></td>
                        </tr>
                    </table>
                </div>
                <div id="sub_block">
                    <div style="margin-bottom: 4px"><a style="color: #ff5400    " href="?page=Board">Änderung abbrechen</a></div>
                    <div style="font-weight: bold;">Profil erstellt am:</div>
                    <div><?= date("d.m.Y", $user->created) ?></div>
                </div>
                <div class="button_blue" id="save_changes" style="margin-top: 15px; float: right;">
                	<button class="button_" style="width: 146px;">Änderungen speichern</button>
                </div>
            </form>
            <div id="upload_block">
            	<form action="?page=Board&action=SavePicture" method="POST" enctype="multipart/form-data">
                	<input type="hidden" name="MAX_FILE_SIZE" value="500000" />
                    <div class="info_description">Profilbild hochladen</div>
                    <div class="info_content"><input name="picture" type="file" /></div>
                    <button style="width: 116px;">Hochladen</button>
                </form>
            </div>
        </div>
        <?php include("Views/Pinboard.php"); ?>
    </div>
</div>

<?php include("Views/Footer.php"); ?>

