<?php
include("Views/Header.php");
include("Views/Sidebar.php");
?>

<div class="content_pin">
    <div class="content_name" style="height: 40px; background-color: #E9EDF1; font-weight: bold; color: #2b587a; padding-top: 10px; padding-left: 10px">
        <div style="float: left; width: 150px; height: 40px;">Suchergebnis</div>
        <div style="float: left;">
            <div class="search_field" style="width: 280px; float: left;">
                <form id="searchForm" method="GET" action="#">
                    <input onclick="reset_field(this)" onblur="check_field(this)" id="search_word" style="width: 230px;" type="text" name="search_word" value="Suchen..."/>
            </div>
            </form>
            <div class="button_blue" id="start_search" style="float: left">
                <button class="button_" style="width: 50px;" id="start_search_button">Go!</button>
            </div>
        </div>
    </div>
    <div id="search_result">
        <div id="search_result_header">
            Suchergebnis: <?php echo "14521" ?> Resultate wurde gefunden
        </div>
        <div class="search_result_item">
            <div class="photo_small">

            </div>
            <div class="profil_info">
                <a href="#">Markus Viehmann</a>
                <div>Moskau</div>
            </div>
        </div>
        <div class="add_friend">
            <a href="#">zu den Freunden hinzufügen</a>
        </div>
    </div>
</div>

<?php include("Views/Footer.php"); ?>

