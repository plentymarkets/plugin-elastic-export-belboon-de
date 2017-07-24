# User Guide für das ElasticExportBelboonDE Plugin

<div class="container-toc"></div>

## 1 Bei Belboon.de registrieren

Das Affiliate-Netzwerk belboon ist spezialisiert auf die Umsetzung Ihrer Performance-Marketing-Maßnahmen.

## 2 Das Format BelboonDE-Plugin in plentymarkets einrichten

Um dieses Format nutzen zu können, benötigen Sie das Plugin Elastic Export.

Auf der Handbuchseite [Daten exportieren](https://www.plentymarkets.eu/handbuch/datenaustausch/daten-exportieren/#4) werden die einzelnen Formateinstellungen beschrieben.

In der folgenden Tabelle finden Sie spezifische Hinweise zu den Einstellungen, Formateinstellungen und empfohlenen Artikelfiltern für das Format **BelboonDE-Plugin**.
<table>
    <tr>
        <th>
            Einstellung
        </th>
        <th>
            Erläuterung
        </th>
    </tr>
    <tr>
        <td class="th" colspan="2">
            Einstellungen
        </td>
    </tr>
    <tr>
        <td>
            Format
        </td>
        <td>
            <b>BelboonDE-Plugin</b> wählen.
        </td>        
    </tr>
    <tr>
        <td>
            Bereitstellung
        </td>
        <td>
            <b>URL</b> wählen.
        </td>        
    </tr>
    <tr>
        <td>
            Dateiname
        </td>
        <td>
            Der Dateiname muss auf <b>.csv</b> oder <b>.txt</b> enden, damit Belboon.de die Datei erfolgreich importieren kann.
        </td>        
    </tr>
    <tr>
        <td class="th" colspan="2">
            Artikelfilter
        </td>
    </tr>
    <tr>
        <td>
            Aktiv
        </td>
        <td>
            <b>Aktiv</b> wählen.
        </td>        
    </tr>
    <tr>
        <td>
            Märkte
        </td>
        <td>
            Eine oder mehrere Auftragsherkünfte wählen. Die gewählten Auftragsherkünfte müssen an der Variante aktiviert sein, damit der Artikel exportiert wird.
        </td>        
    </tr>
    <tr>
        <td class="th" colspan="2">
            Formateinstellungen
        </td>
    </tr>
    <tr>
        <td>
            Auftragsherkunft
        </td>
        <td>
            Die Auftragsherkunft wählen, die beim Auftragsimport zugeordnet werden soll.
        </td>        
    </tr>
    <tr>
        <td>
            Angebotspreis
        </td>
        <td>
            Diese Option ist für dieses Format nicht relevant.
        </td>        
    </tr>
    <tr>
        <td>
            MwSt.-Hinweis
        </td>
        <td>
            Diese Option ist für dieses Format nicht relevant.
        </td>        
    </tr>
</table>


## 3 Übersicht der verfügbaren Spalten

<table>
    <tr>
        <th>
            Spaltenbezeichnung
        </th>
        <th>
            Erläuterung
        </th>
    </tr>
    <tr>
        <td>
            Merchant_ProductNumber
        </td>
        <td>
            <b>Pflichtfeld</b><br>
            <b>Beschränkung:</b> nur Zahlen erlaubt, max. 20 Zeichen<br>
            <b>Inhalt:</b> Die Varianten-ID der Variante.
        </td>        
    </tr>
    <tr>
        <td>
            EAN_Code
        </td>
        <td>
            <b>Inhalt:</b> Entsprechend der Formateinstellung <b>Barcode</b>.
        </td>        
    </tr>
    <tr>
        <td>
            Product_Title
        </td>
        <td>
            <b>Pflichtfeld</b><br>
            <b>Inhalt:</b> Entsprechend der Formateinstellung <b>Artikelname</b>.
        </td>        
    </tr>
    <tr>
        <td>
            Brand
        </td>
        <td>
            <b>Inhalt:</b> Der <b>Name des Herstellers</b> des Artikels. Der <b>Externe Name</b> unter <b>Einstellungen » Artikel » Hersteller</b> wird bevorzugt, wenn vorhanden.
        </td>        
    </tr>
    <tr>
        <td>
            Price
        </td>
        <td>
            <b>Pflichtfeld</b><br>
            <b>Beschränkung:</b> max 999.999,99 <br>
            <b>Inhalt:</b> Der <b>Verkaufspreis</b> der Variante.
        </td>        
    </tr>
    <tr>
        <td>
            Price_old
        </td>
        <td>
            <b>Beschränkung:</b> max 999.999,99 <br>
            <b>Inhalt:</b> Der <b>Verkaufspreis</b> vom Preis-Typ <b>UVP</b> der Variante, wenn dieser höher ist als der Preis.
        </td>        
    </tr>
    <tr>
        <td>
            Currency
        </td>
        <td>
            <b>Pflichtfeld</b><br>
            <b>Inhalt:</b> Der ISO-Code der <b>Währung</b> des Preises.
        </td>        
    </tr>
    <tr>
        <td>
            Valid_From
        </td>
        <td>
            <b>Inhalt:</b> Das <b>Erscheinungsdatum</b> der Variante. 
        </td>        
    </tr>
    <tr>
        <td>
            Valid_To
        </td>
        <td>
            <b>Inhalt:</b> Das Datum aus der Einstellung <b>Verfügbar bis</b> der Variante.
        </td>        
    </tr>
    <tr>
        <td>
            DeepLink_URL
        </td>
        <td>
            <b>Pflichtfeld</b><br>
            <b>Inhalt:</b> Der <b>URL-Pfad</b> des Artikels abhängig vom gewählten <b>Mandanten</b> in den Formateinstellungen.
        </td>        
    </tr>
    <tr>
        <td>
            Image_Small_URL
        </td>
        <td>
            <b>Pflichtfeld</b><br>
            <b>Inhalt:</b> URL zu dem Bild in der Vorschaugröße gemäß der Formateinstellungen <b>Bild</b>. Variantenbilder werden vor Artikelbildern priorisiert.
        </td>        
    </tr>
    <tr>
        <td>
            Image_Small_WIDTH
        </td>
        <td>
            <b>Pflichtfeld</b><br>
            <b>Beschränkung:</b> max 11 Zeichen<br>
            <b>Inhalt:</b> Breite des Bildes aus <b>Image_Small_URL</b>.
        </td>        
    </tr>
    <tr>
        <td>
            Image_Small_HEIGHT
        </td>
        <td>
            <b>Pflichtfeld</b><br>
            <b>Beschränkung:</b> max 11 Zeichen<br>
            <b>Inhalt:</b> Höhe des Bildes aus <b>Image_Small_URL</b>.
        </td>        
    </tr>
    <tr>
        <td>
            Image_Large_URL
        </td>
        <td>
            <b>Pflichtfeld</b><br>
            <b>Inhalt:</b> URL zu dem Bild gemäß der Formateinstellungen <b>Bild</b>. Variantenbilder werden vor Artikelbildern priorisiert. 
        </td>        
    </tr>
    <tr>
        <td>
            Image_Large_WIDTH
        </td>
        <td>
            <b>Pflichtfeld</b><br>
            <b>Beschränkung:</b> max 11 Zeichen<br>
            <b>Inhalt:</b> Breite des Bildes aus <b>Image_Large_WIDTH</b>.
        </td>        
    </tr>
    <tr>
        <td>
            Image_Large_HEIGHT
        </td>
        <td>
            <b>Pflichtfeld</b><br>
            <b>Beschränkung:</b> max 11 Zeichen<br>
            <b>Inhalt:</b> Höhe des Bildes aus <b>Image_Large_WIDTH</b>.
        </td>        
    </tr>
    <tr>
        <td>
            Merchant Product Category
        </td>
        <td>
            <b>Inhalt:</b> Der <b>Kategoriepfad der Standardkategorie</b> für den in den Formateinstellungen definierten <b>Mandanten</b>.
        </td>        
    </tr>
    <tr>
        <td>
            Keywords
        </td>
        <td>
            <b>Inhalt:</b> Die Meta-Keywords des Artikels aus dem <b>Tab: Texte</b>.
        </td>        
    </tr>
    <tr>
        <td>
            Product_Description_Short
        </td>
        <td>
            <b>Pflichtfeld</b><br>
            <b>Inhalt:</b> Entsprechend der Formateinstellung <b>Vorschautext</b>.
        </td>        
    </tr>
    <tr>
        <td>
            Product_Description_Long
        </td>
        <td>
            <b>Inhalt:</b> Entsprechend der Formateinstellung <b>Beschreibung</b>.
        </td>        
    </tr>
    <tr>
        <td>
            Last_Update
        </td>
        <td>
            <b>Inhalt:</b> Datum der letzten Aktualisierung der Variante.
        </td>        
    </tr>
    <tr>
        <td>
            Shipping
        </td>
        <td>
            <b>Pflichtfeld</b><br>
            <b>Inhalt:</b> Entsprechend der Formateinstellung <b>Versandkosten</b>.
        </td>        
    </tr>
    <tr>
        <td>
            Availability
        </td>
        <td>
            <b>Pflichtfeld</b><br>
            <b>Inhalt:</b> Der Name der Artikelverfügbarkeit der Variante oder die Übersetzung gemäß der Formateinstellung <b>Artikelverfügbarkeit überschreiben</b>.
        </td>        
    </tr>
    <tr>
        <td>
            Unit_Price
        </td>
        <td>
            <b>Inhalt:</b> Die <b>Grundpreisinformation</b> im Format "Preis / Einheit". (Beispiel: 10,00 EUR / Kilogramm)
        </td>        
    </tr>
</table>

## 4 Lizenz

Das gesamte Projekt unterliegt der GNU AFFERO GENERAL PUBLIC LICENSE – weitere Informationen finden Sie in der [LICENSE.md](https://github.com/plentymarkets/plugin-elastic-export-belboon-de/blob/master/LICENSE.md).
