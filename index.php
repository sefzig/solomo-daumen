<?php 

 /* Funktionen laden
  * 
  * folgt
  */
    require("php/funktionen.php");
    
 /* Voting-Script Referenz
  * 
  * URL-Parameter als Datenbank-ID
  */
    $daumen = $_GET["i"];
    
 /* Htaccess-Verzeichnisse
  * 
  * folgt
  */
    $rootplus = $_GET["rootplus"]; 
    if ($rootplus == 1) { $root = "../"; }
    else if ($rootplus == 2) { $root = "../../"; }
    else if ($rootplus == 3) { $root = "../../../"; }
    else { $root = ""; }
    

?><html xmlns:fb="http://ogp.me/ns/fb#">
  <head>
    <meta content="IE=edge" http-equiv="X-UA-Compatible" />
    <title>Solomo Daumen</title>
    <!-- Allgemeine Einstellungen -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- Mobile Optimierung -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?=$root?>css/index.css" type="text/css">
    <style></style>
    <!-- Javascript -->
    <script type="text/javascript" src="<?=$root?>js/jquery.js"></script>
    <script type="text/javascript" src="<?=$root?>js/jqBarGraph.js"></script>
    <script type="text/javascript" src="<?=$root?>js/index.js"></script>
    <script></script>
  </head>
  <body>
    <div id="umschliessung">
      <div id="kopf">
        <h1>Solomo<br />Daumen<br />0.1</h1>
        <img src="img/kopf.png" border="0" />
      </div>
      <div class="voting_wrapper" id="<?=$daumen?>">
        <table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0"><tr><td width="100%" height="100%" align="center" valign="center">
          <div class="voting_btn">
            <img class="up_button"   src="<?=$root?>img/daumen_up.png"   border="0" />
          </div>
          <div class="voting_btn">
            <img class="down_button" src="<?=$root?>img/daumen_down.png" border="0" />
          </div>
        </td></tr></table>
        <div class="resultate">
          Daumen hoch: <span class="up_votes"></span><br/>
          Daumen runter: <span class="down_votes"></span><br/>
        </div>
      </div>
      <div class="diagramm">
        <table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
          <tr>
            <td id="diagramm_up" valign="bottom">
              <div></div>
              &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
            </td>
            <td width="20"></td>
            <td id="diagramm_down" valign="bottom">
              <div></div>
              &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
            </td>
          </tr>
        </table>
      </div>
      <div class="ergebnis">
        <table width="100%" height="10" cellspacing="0" cellpadding="0" border="0">
          <tr>
            <td id="ergebnis_up" width="50%" valign="bottom">
              <div></div>
              &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
            </td>
            <td id="ergebnis_down" width="50%" valign="bottom">
              <div></div>
              &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
            </td>
          </tr>
        </table>
      </div>
      <div id="fuss">
        <div id="meldung">Sefzig.net 2014</div>
      </div>
    </div>
  </body>
</html>