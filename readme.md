Mapplic Maps fork
-----------------

* Description
* Requirements
* Features
* Installation
* References
* Demo

Description
-----------------
Mapplic Maps integrates the third party Javascript library mapplic from https://www.mapplic.com/
and is from now ready for drupal 9. This third party library mapplic is not free.
You must purchase it: https://www.mapplic.com/pricing/ [ in 2019 24 $ ]
--
This Module is a fork of: https://www.drupal.org/project/mapplic_maps (which did not work for me)
This is preset / prepared for German users mainly.

3 Controller are prepared:
welt
europa
deutschland
bundeslaender
startup laender

for other countries or regions copy controller and adopt wording scheme.
I know this could be better solved with variables, but I had no time for this.


Requirements
-----------------
Modules:
- dynamic_entity_reference

Taxonomy:
- landmark

Content Typ:
- mapplic maps landmark

Block:
- block layout

- permissions

All configurable contents are importable with the yml file
which have to be moved from mapplic_maps/config/install/ folder
to your config sync folder
drush cim to import


Features
-----------------
Provides three Blocks with four  maps: Bundeslaender, Germany, europe & World
Makes use of one content type: landmark to edit & place
landmarks with:

- title
- description (body)
- svg id
- pin
- thumbnail image
- backgroud color
- zoom
- pos x
- pos y
- link


Installation
-----------------

1. Unpack in the *modules* folder `/modules/contrib/`
  1.1 remove files from:   /mapplic_maps/config/install and copy to your /config/sync folder
  1.2 and enable in `/admin/modules`

#mapplic block has one dependency: "dynamic_entity_reference"

2. Purchase! the mapplic jQuery here: https://www.mapplic.com/ and download ZIP file.
Extract the ZIP-File: 'codecanyon-6275001-mapplic-custom-interactive-map-jquery-plugin.zip' (or similar)
to subdir of the mapplic_maps module:  /modules/contrib/mapplic_maps/libraries/mapplic_maps/
/html/ is enough, no need for the /docs/ folder

  2.1 When you like to use the prepared German map controller: Bundesländer Deutschland, Europa, Welt
  you should:
  mapplic_maps\maps\data
    - copy the /mapplic_maps/maps/data/bundeslaender.json to deutschland.json and translate the names
    - copy the /mapplic_maps/maps/data/germany.json to deutschland.json and translate the names
    - copy the /mapplic_maps/maps/data/europe.json to europa.json and translate the names
    - copy the /mapplic_maps/maps/data/world.json to welt.json and translate the names

  2.2 Do the same with the maps:
  modules\contrib\mapplic_maps\libraries\mapplic_maps\html\maps\germany.svg
  modules\contrib\mapplic_maps\libraries\mapplic_maps\html\maps\germany-mini.svg etc.

3. In order to see data on any map you must import the config/sync files

  3.1 contenty typ: 'mapplic_landmark' with all fields

  3.2 taxonomy:     'landmark'         with at least one label for the map you would like to use:
    - France for France,
    - Deutschland for Deutschland
    - World for world etc.

  3.3 Block layout:
  under /admin/structure/block you must enable at least one map block to activate a map.

4. visit `/admin/config/services/mapplic_maps` and enter your own configuration details.
  Default is deutschland.json (which must be copied and translated first)

5. Add Landmarks here: /node/add/mapplic_landmark
  In order to get the right coordinates: pos x and pos y you need to open the map you wnat to add your landmark to:
  You will see the data on top of this map moving around your mouse. "*Activate developer mode*" must be activated in /admin/config/services/mapplic_maps/ for this!

Author/Maintainer
-----------------

- [Konrad Tadesse](https://www.drupal.org/user/526656/)
