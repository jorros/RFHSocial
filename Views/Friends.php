<?php
include("Views/Header.php");
include("Views/Sidebar.php");
?>
<div class="content">
	<div class="content_name" style="height: 40px; background-color: #E9EDF1; font-weight: bold; color: #2b587a; padding-top: 10px; padding-left: 10px">
        <div style="float: left; width: 150px; height: 40px;"><?php echo "Meine Freunde" ?></div>
        <?php include("Views/SearchBar.php"); ?>
    </div>
    <div id="friend_page">
        <div class="header_1">Sie haben <?= count($model) ?> Freund<?php if(count($model) != 1) echo "e"; ?></div>
        <div id="friend_items">
        <?php
        foreach($model as $friend) {
        ?>
        <div class="friend_item">
            <div class="photo_small">
                <img alt="Profilbild" src="Resources/ProfilePics/<?= $friend->picture ?>.png" style="width: 40px; height: 40px">
            </div>
            <div class="friend_name">
                <a href="?page=Board&user=<?= $friend->id ?>"><?= $friend->firstname . " " . $friend->lastname ?></a><br>
                <?php echo "<div style=\"color: #999999;\">" . $friend->location . "</div>" ?>
            </div>
            <div class="delete_friend">
                <a href="?page=Friends&action=RemoveFriend&who=<?= $friend->id ?>&g=<?= $viewBag["filter"]["gender"] ?>&l=<?= $viewBag["filter"]["location"] ?>&c=<?= $viewBag["filter"]["course"] ?>">aus der Liste entfernen</a>
            </div>
        </div>
        <?php } ?>
        </div>
        <div id="right_sidebar">
        	<form action="?" method="GET">
            	<input type="hidden" name="page" value="Friends" />
                <div style="font-weight: bold; color: #2b587a; font-size: 13px; margin-bottom: 5px;">Hier können Sie zusätzliche Kriterien angeben</div>
                <div class="sort_description">Geschlecht</div>
                <div class="sort_input"><select name="g">
                                            <option value="">Geschlecht</option>
                                            <option <?php if(isset($viewBag["filter"]["gender"]) && $viewBag["filter"]["gender"] == 1) echo "selected"; ?> value="1">männlich</option>
                                            <option <?php if(isset($viewBag["filter"]["gender"]) && $viewBag["filter"]["gender"] == 2) echo "selected"; ?> value="2">weiblich</option>
                                        </select>
                </div>
                <div class="sort_description">Stadt</div>
                <div class="sort_input"><input type="text" name="l" value="<?php if(isset($viewBag["filter"]["location"])) echo $viewBag["filter"]["location"]; ?>"></div>
                <div class="sort_description">Studiengang</div>
                <div class="sort_input"><select name="c">
                        <option value="">Studiengang</option>
                        <option <?php if(isset($viewBag["filter"]["gender"]) && $viewBag["filter"]["course"] == "Wirtschaftsinformatik") echo "selected" ?> value="Wirtschaftsinformatik">Wirtschaftsinformatik</option>
                        <option <?php if(isset($viewBag["filter"]["gender"]) && $viewBag["filter"]["course"] == "Elektrotechnik") echo "selected" ?> value="Elektrotechnik">Elektrotechnik</option>
                        <option <?php if(isset($viewBag["filter"]["gender"]) && $viewBag["filter"]["course"] == "Maschinenbau") echo "selected" ?> value="Maschinenbau">Maschinenbau</option>
                        <option <?php if(isset($viewBag["filter"]["gender"]) && $viewBag["filter"]["course"] == "Wirtschaftsingenieurwesen") echo "selected" ?> value="Wirtschaftsingenieurwesen">Wirtschaftsingenieurwesen</option>
                        <option <?php if(isset($viewBag["filter"]["gender"]) && $viewBag["filter"]["course"] == "Mediendesign") echo "selected" ?> value="Mediendesign">Mediendesign</option>
                        <option <?php if(isset($viewBag["filter"]["gender"]) && $viewBag["filter"]["course"] == "Medienwirtschaft") echo "selected" ?> value="Medienwirtschaft">Medienwirtschaft</option>
                        <option <?php if(isset($viewBag["filter"]["gender"]) && $viewBag["filter"]["course"] == "Medizinökonomie") echo "selected" ?> value="Medizinökonomie">Medizinökonomie</option>
                        <option <?php if(isset($viewBag["filter"]["gender"]) && $viewBag["filter"]["course"] == "Betriebswirtschaftslehre") echo "selected" ?> value="Betriebswirtschaftslehre">Betriebswirtschaftslehre</option>
                        <option <?php if(isset($viewBag["filter"]["gender"]) && $viewBag["filter"]["course"] == "Wirtschaftspsychologie") echo "selected" ?> value="Wirtschaftspsychologie">Wirtschaftspsychologie</option>
                        <option <?php if(isset($viewBag["filter"]["gender"]) && $viewBag["filter"]["course"] == "Wirtschaftsrecht") echo "selected" ?> value="Wirtschaftsrecht">Wirtschaftsrecht</option>
                    </select>
                </div>
                <div class="button_blue" id="suche_anpassen">
                    <button class="button_" style="width: 116px;">Suche anpassen</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include("Views/Footer.php"); ?>

