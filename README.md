Solomo Daumen
=============

Mobile Anwendung mit Daumen-hoch/runter-Funktion und Balken-Diagramm. 
Lokale Einbindung kann mit URL-Parametern vorkonfiguriert werden. 
Cookies: Jeder Browser kann nur ein Mal abstimmen. 
".qrcode" am Ende einer URL erzeugt einen entsprechenden QR Code.

## Links

* [Demo mit Sitzungs-ID "gh"](http://sefzig.net/solomo/daumen/gh/)
* [Druckvorlage für Sitzung "gh"](http://sefzig.net/solomo/druck/?zahler=0&prefix=gh&korrektur=L&zeilen=6&spalten=4&template=standard&konfig=0&cta=Bewerte%20dies!&url=http://sefzig.net/solomo/daumen/)

## URL-Parameter

<pre>
http://sefzig.net/solomo/daumen/
?i= // Sitzungs-ID (einmalig, mehrstellig)
</pre>
oder
<pre>
http://sefzig.net/solomo/daumen/*/
</pre>
oder
<pre>
http://sefzig.net/solomo/daumen/*/.qrcode
</pre>

## Einrichtung

* Das Verzeichnis "daten" muss chmod777 sein.
