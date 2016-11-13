<?php
include("Views/Header.php");
include("Views/Sidebar.php");
?>
<div class="content">
    <div class="content_name" style="height: 40px; background-color: #E9EDF1; font-weight: bold; color: #2b587a; padding-top: 10px; padding-left: 10px">
        <div style="float: left; width: 150px; height: 40px;">Diese Seite wurde leider nicht gefunden</div>
        <?php include("Views/SearchBar.php"); ?>
    </div>
    <div id="error">
       <h1>OOOOOPS..... Diese Seite wurde leider nicht gefunden (404)</h1>
       <div id="smile">
           <img alt="Trauriger Smiley" src="Resources/Images/traurig_smile.jpg"/>
       </div>
    </div>
</div>
<?php include("Views/Footer.php"); ?>

