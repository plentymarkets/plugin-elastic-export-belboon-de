# User Guide für das ElasticExportBelboonDE Plugin

<div class="container-toc"></div>

## 1 Bei Belboon.de registrieren

Das Affiliate-Netzwerk belboon ist spezialisiert auf die Umsetzung Ihrer Performance-Marketing-Maßnahmen.

## 2 Das Format BelboonDE-Plugin in plentymarkets einrichten

Mit der Installation dieses Plugins erhalten Sie das Exportformat **BelboonDE-Plugin**, mit dem Sie Daten über den elastischen Export zu belboon übertragen. Um dieses Format für den elastischen Export nutzen zu können, installieren Sie zunächst das Plugin **Elastic Export** aus dem plentyMarketplace, wenn noch nicht geschehen. 

Sobald beide Plugins in Ihrem System installiert sind, kann das Exportformat **BelboonDE-Plugin** erstellt werden. Weitere Informationen finden Sie auch auf der Handbuchseite [Datenformate für Preissuchmaschinen exportieren](https://knowledge.plentymarkets.com/basics/datenaustausch/export-import/daten-exportieren#30).

Neues Exportformat erstellen:

1. Öffnen Sie das Menü **Daten » Elastischer Export**.
2. Klicken Sie auf **Neuer Export**.
3. Nehmen Sie die Einstellungen vor. Beachten Sie dazu die Erläuterungen in Tabelle 1.
4. **Speichern** Sie die Einstellungen.
→ Eine ID für das Exportformat **BelboonDE-Plugin** wird vergeben und das Exportformat erscheint in der Übersicht **Exporte**.

In der folgenden Tabelle finden Sie Hinweise zu den einzelnen Formateinstellungen und empfohlenen Artikelfiltern für das Format **BelboonDE-Plugin**.

| **Einstellung**                                     | **Erläuterung** |
| :---                                                | :--- |
| **Einstellungen**                                   | |
| **Name**                                            | Name eingeben. Unter diesem Namen erscheint das Exportformat in der Übersicht im Tab **Exporte**. |
| **Typ**                                             | Typ **Artikel** aus der Dropdown-Liste wählen. |
| **Format**                                          | **BelboonDE-Plugin** wählen. |
| **Limit**                                           | Zahl eingeben. Wenn mehr als 9999 Datensätze an belboon übertragen werden sollen, wird die Ausgabedatei wird für 24 Stunden nicht noch einmal neu generiert, um Ressourcen zu sparen. Wenn mehr mehr als 9999 Datensätze benötigt werden, muss die Option **Cache-Datei generieren** aktiv sein. |
| **Cache-Datei generieren**                          | Häkchen setzen, wenn mehr als 9999 Datensätze an belboon übertragen werden sollen. Um eine optimale Perfomance des elastischen Exports zu gewährleisten, darf diese Option bei maximal 20 Exportformaten aktiv sein. |
| **Bereitstellung**                                  | **URL** wählen. |
| **Dateiname**                                       | Der Dateiname muss auf **.csv** oder **.txt** enden, damit belboon die Datei erfolgreich importieren kann. |
| **Token, URL**                                      | Wenn unter **Bereitstellung** die Option **URL** gewählt wurde, auf **Token generieren** klicken. Der Token wird dann automatisch eingetragen. Die URL wird automatisch eingetragen, wenn unter **Token** der Token generiert wurde. |
| **Artikelfilter**                                   | |
| **Artikelfilter hinzufügen**                        | Artikelfilter aus der Dropdown-Liste wählen und auf **Hinzufügen** klicken. Standardmäßig sind keine Filter voreingestellt. Es ist möglich, alle Artikelfilter aus der Dropdown-Liste nacheinander hinzuzufügen.<br/> **Varianten** = **Alle übertragen**, **Nur Hauptvarianten übertragen**, oder **Keine Hauptvarianten übertragen** wählen.<br/> **Märkte** = Eine oder mehrere Auftragsherkünfte wählen. Die gewählten Auftragsherkünfte müssen an der Variante aktiviert sein, damit der Artikel exportiert wird.<br/> **Währung** = Währung wählen.<br/> **Kategorie** = Aktivieren, damit der Artikel mit Kategorieverknüpfung übertragen wird. Es werden nur Artikel, die dieser Kategorie zugehören, übertragen.<br/> **Bild** = Aktivieren, damit der Artikel mit Bild übertragen wird. Es werden nur Artikel mit Bildern übertragen.<br/> **Mandant** = Mandant wählen.<br/> **Bestand** = Wählen, welche Bestände exportiert werden sollen.<br/> **Markierung 1 - 2** = Markierung wählen.<br/> **Hersteller** = Einen, mehrere oder ALLE Hersteller wählen.<br/> **Aktiv** = **Aktiv** wählen. Nur aktive Varianten werden übertragen. |
| **Formateinstellungen**                             | |
| **Produkt-URL**                                     | Wählen, ob die URL des Artikels oder der Variante an belboon übertragen wird. Varianten-URLs können nur in Kombination mit dem Ceres Webshop übertragen werden. |
| **Mandant**                                         | Mandant wählen. Diese Einstellung wird für den URL-Aufbau verwendet. |
| **URL-Parameter**                                   | Suffix für die Produkt-URL eingeben, wenn dies für den Export erforderlich ist. Die Produkt-URL wird dann um die eingegebene Zeichenkette erweitert, wenn weiter oben die Option **übertragen** für die Produkt-URL aktiviert wurde. |
| **Auftragsherkunft**                                | Aus der Dropdown-Liste die Auftragsherkunft wählen, die beim Auftragsimport zugeordnet werden soll. |
| **Marktplatzkonto**                                 | Marktplatzkonto aus der Dropdown-Liste wählen. Die Produkt-URL wird um die gewählte Auftragsherkunft erweitert, damit die Verkäufe später analysiert werden können. |
| **Sprache**                                         | Sprache aus der Dropdown-Liste wählen. |
| **Artikelname**                                     | **Name 1**, **Name 2** oder **Name 3** wählen. Die Namen sind im Tab **Texte** eines Artikels gespeichert.<br/> Im Feld **Maximale Zeichenlänge (def. Text)** optional eine Zahl eingeben, wenn Tracdelight eine Begrenzung der Länge des Artikelnamen beim Export vorgibt. |
| **Vorschautext**                                    | Wählen, ob und welcher Text als Vorschautext übertragen werden soll.<br/> Im Feld **Maximale Zeichenlänge (def. Text)** optional eine Zahl eingeben, wenn belboon eine Begrenzung der Länge des Vorschautextes beim Export vorgibt.<br/> Option **HTML-Tags entfernen** aktvieren, damit die HTML-Tags beim Export entfernt werden.<br/> Im Feld **Erlaubte HTML-Tags, kommagetrennt (def. Text)** optional die HTML-Tags eingeben, die beim Export erlaubt sind. Wenn mehrere Tags eingegeben werden, mit Komma trennen. |
| **Beschreibung**                                    | Wählen, welcher Text als Beschreibungstext übertragen werden soll.<br/> Im Feld **Maximale Zeichenlänge (def. Text)** optional eine Zahl eingeben, wenn Tracdelight eine Begrenzung der Länge der Beschreibung beim Export vorgibt.<br/> Option **HTML-Tags entfernen** aktivieren, damit die HTML-Tags beim Export entfernt werden.<br/> Im Feld **Erlaubte HTML-Tags, kommagetrennt (def. Text)** optional die HTML-Tags eingeben, die beim Export erlaubt sind. Wenn mehrere Tags eingegeben werden, mit Komma trennen. |
| **Zielland**                                        | Zielland aus der Dropdown-Liste wählen. |
| **Barcode**                                         | ASIN, ISBN oder eine EAN aus der Dropdown-Liste wählen. Der gewählte Barcode muss mit der oben gewählten Auftragsherkunft verknüpft sein. Andernfalls wird der Barcode nicht exportiert. |
| **Bild**                                            | **Position 0** oder **Erstes Bild** wählen, um dieses Bild zu exportieren.<br/> **Position 0** = Ein Bild mit der Position 0 wird übertragen.<br/> **Erstes Bild** = Das erste Bild wird übertragen. |
| **Bildposition des Energieetiketts**                | Diese Option ist für dieses Format nicht relevant. |
| **Bestandspuffer**                                  | Der Bestandspuffer für Varianten mit der Beschränkung auf den Netto-Warenbestand. |
| **Bestand für Varianten ohne Bestandsbeschränkung** | Der Bestand für Varianten ohne Bestandsbeschränkung. |
| **Bestand für Varianten ohne Bestandsführung**      | Der Bestand für Varianten ohne Bestandsführung. |
| **Währung live umrechnen**                          | Aktivieren, damit der Preis je nach eingestelltem Lieferland in die Währung des Lieferlandes umgerechnet wird. Der Preis muss für die entsprechende Währung freigegeben sein. |
| **Verkaufspreis**                                   | Brutto- oder Nettopreis aus der Dropdown-Liste wählen. |
| **Angebotspreis**                                   | Diese Option ist für dieses Format nicht relevant. |
| **UVP**                                             | Aktivieren, um den UVP zu übertragen. |
| **Versandkosten**                                   | Aktivieren, damit die Versandkosten aus der Konfiguration übernommen werden. Wenn die Option aktiviert ist, stehen in den beiden Dropdown-Listen Optionen für die Konfiguration und die Zahlungsart zur Verfügung.<br/> Option **Pauschale Versandkosten übertragen** aktivieren, damit die pauschalen Versandkosten übertragen werden. Wenn diese Option aktiviert ist, muss im Feld darunter ein Betrag eingegeben werden. |
| **MwSt.-Hinweis**                                   | Diese Option ist für dieses Format nicht relevant. |
| **Artikelverfügbarkeit**                            | Option **überschreiben** aktivieren und in die Felder **1** bis **10**, die die ID der Verfügbarkeit darstellen, Artikelverfügbarkeiten eintragen. Somit werden die Artikelverfügbarkeiten, die im Menü **System » Artikel » Verfügbarkeit** eingestellt wurden, überschrieben. |

_Tab. 1: Einstellungen für das Datenformat **BelboonDE-Plugin**_

## 3 Verfügbare Spalten der Exportdatei

| **Spaltenbezeichnung**    | **Erläuterung** |
| :---                      | :--- |
| Merchant_ProductNumber    | **Pflichtfeld**<br/> **Beschränkung**: nur Zahlen erlaubt, max. 20 Zeichen<br/> Die Varianten-ID der Variante. |
| EAN_Code                  | Entsprechend der Formateinstellung **Barcode**. |
| Product_Title             | **Pflichtfeld**<br/> Entsprechend der Formateinstellung **Artikelname**. |
| Brand                     | Der Name des Herstellers des Artikels. Der **Externe Name** unter **System » Artikel » Hersteller** wird bevorzugt, wenn vorhanden. |
| Price                     | **Pflichtfeld**<br/> **Beschränkung**: max. 999.999,99<br/> Der Verkaufspreis der Variante. |
| Price_old                 | **Beschränkung**: max. 999.999,999<br/> Der Verkaufspreis vom Preistyp **UVP** der Variante, wenn dieser höher ist als der Preis. |
| Currency                  | **Pflichtfeld**<br/> Der ISO-Code der Währung des Preises. |
| Valid_From                | Das Erscheinungsdatum der Variante. |
| Valid_To                  | Das Datum aus der Einstellung **Verfügbar bis** der Variante. |
| DeepLink_URL              | **Pflichtfeld**<br/> Der URL-Pfad des Artikels abhängig vom gewählten **Mandanten** in den Formateinstellungen. |
| Image_Small_URL           | **Pflichtfeld**<br/> URL zu dem Bild in der Vorschaugröße gemäß der Formateinstellungen **Bild**. Variantenbilder werden vor Artikelbildern priorisiert. |
| Image_Small_WIDTH         | **Pflichtfeld**<br/> **Beschränkung**: max. 11 Zeichen<br/> Breite des Bildes aus Image_Small_URL. |
| Image_Small_HEIGHT        | **Pflichtfeld**<br/> **Beschränkung**: max. 11 Zeichen<br/> Höhe des Bildes aus Image_Small_URL. |
| Image_Large_URL           | **Pflichtfeld**<br/> URL zu dem Bild gemäß der Formateinstellungen **Bild**. Variantenbilder werden vor Artikelbildern priorisiert. |
| Image_Large_WIDTH         | **Pflichtfeld**<br/> **Beschränkung**: max. 11 Zeichen<br/> Breite des Bildes aus Image_Large_WIDTH. |
| Image_Large_HEIGHT        | **Pflichtfeld**<br/> **Beschränkung**: max. 11 Zeichen<br/> Höhe des Bildes aus Image_Large_WIDTH. |
| Merchant Product Category | Der Kategoriepfad der Standardkategorie für den in den Formateinstellungen definierten **Mandanten**. |
| Keywords                  | Die Meta-Keywords des Artikels aus dem Tab **Texte**. |
| Product_Description_Short | **Pflichtfeld**<br/>  Entsprechend der Formateinstellung **Vorschautext**. |
| Product_Description_Long  | Entsprechend der Formateinstellung **Beschreibung**. |
| Last_Update               | Datum der letzten Aktualisierung der Variante. |
| Shipping                  | **Pflichtfeld**<br/> Entsprechend der Formateinstellung **Versandkosten**. |
| Availability              | **Pflichtfeld**<br/> Der Name der Artikelverfügbarkeit der Variante oder die Übersetzung gemäß der Formateinstellung **Artikelverfügbarkeit überschreiben**. |
| Unit_Price                | Die Grundpreisinformation im Format "Preis / Einheit" (Beispiel: 10,00 EUR / Kilogramm). |

## 4 Lizenz

Das gesamte Projekt unterliegt der GNU AFFERO GENERAL PUBLIC LICENSE – weitere Informationen finden Sie in der [LICENSE.md](https://github.com/plentymarkets/plugin-elastic-export-belboon-de/blob/master/LICENSE.md).
