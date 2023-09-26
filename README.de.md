REDAXO-AddOn: systags
=====================

Das systags-Addon ist die Basis zur systemweiten Verwaltung von Tags aller Art.

So können Artikel, Yform Datensätze, Medien, Slices - was immer ihr braucht - mit Tags versehen werden.

Dabei können die Tags dynamisch erstellt werden. Wenn man einfach einen Text ins Tags-Feld eingibt, erscheint eine Auswahl von bereits vorhandenen Tags. Aus dieser Liste kann man dann einen auswählen. Wenn der eingetragene Tag noch nicht vorhanden ist, so wird er angelegt.

Voraussetzungen
---------------

Das Addon benötigt yform für die Verwaltung.


Installation
------------

Das AddOn wird in der AddOn Verwaltung installiert.


Einrichtung
-----------

Bei yform Datensätzen muss für die Verwendung von Tags ein Feld angelegt werden. Das Feld bekommt den Typ Choice Select Multiple. Mit diesen Optionen:

`SELECT id value, name_1 label FROM rex_sys_tags`

Bei den Attributen für das Element wird eingetragen `{"class":"systagselect form-control"}`

Bei Verwendung von Tags in Artikeln wird ein Meta Value angelegt. Feldtyp wird Select. Bei den Optionen wird `SELECT name_1 label, id FROM rex_sys_tags ORDER BY name_1` eingetragen. Bei den Feldattributen wird `multiple="multiple"  class="systagselect form-control"` eingetragen.


Kategorisierung von Tags
------------------------

In manchen Fällen ist es wünschenswert, dass Tags zusätzlich kategorisiert werden. Dies ist möglich, indem in der Tabelle [Tags Kategorien] die gewünschten Kategorien angelegt werden. In der Tabelle [Tags] können für bereits vorhandene Tags die Kategorien zugeordnet werden.


Verwendung der Tags
-------------------

Sind die Tags zugeordnet, können sie vielfältig verwendet werden. Egal ob Tagcloud, Filter, selektive Ausgabe von Inhalten. Der Verwendung sind keine Grenzen gesetzt.

Viel Spaß!