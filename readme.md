Mapplic Maps
===========

Mapplic Maps integrates the third party Javascript library mapplic  from https://www.mapplic.com/ 
to drupal 8. This third party library mapplic is not free. 
You mst purchase it: https://www.mapplic.com/pricing/ [ in 2019 24 $ ]

This Module is a fork of: https://www.drupal.org/project/mapplic_maps which di not work for me
This is prepared for German useres mainly.


Instructions
------------

1. Unpack in the *modules* folder (currently in the root of your Drupal 8 installation) and enable in `/admin/modules`.
mapplic block has one dependency: "dynamic_entity_reference"

2. Purchase! the mapplic jQuery here: https://www.mapplic.com/ and download ZIP file.
Extract the ZIP-File: 'codecanyon-6275001-mapplic-custom-interactive-map-jquery-plugin.zip' (or similar) 
to subdir of the mapplic_maps module:  /modules/contrib/mapplic_maps/libraries/mapplic_maps/
/html/ is enough, no need for the /docs/ folder

2.1 When you like to use the prepared German map controller: Deutschland, Europa, Welt 
- you should copy the germany.json to deutschland.json and translate the names
- you should copy the europe.json to europa.json and translate the names
- you should copy the world.json to welt.json and translate the names

2.2 do the same with the maps: germany.svg germany-mini.svg etc. 

3. In order to see data on any map you must install:
    you will need: 

3.1 contenty typ: 'mapplic_landmark' with all fields

3.2 taxonomy:     'landmark'         with at least one label for the map you would like to use:
- France for France, 
- Deutschland für Deutschland 
- World for world etc. 

3.3 Block layout:
under /admin/structure/block you must enable at least one map block to activate a map.

4. visit `/admin/config/services/mapplic_maps` and enter your own configuration details.
default is deutschland.json (which must be copied and translated first)

5. Add Landmarks here: /node/add/mapplic_landmark
In order to get the right coordinates: pos x and pos y you need to open the map you wnat to add your landmark to:
    You will see the data on top of this map moving around your mouse. "*Activate developer mode*" must be activated in /admin/config/services/mapplic_maps/ for this!


Attention
---------
Most bugs have been ironed out, holes covered, features added. 
This module is a work in progress. 
Please report bugs and suggestions, ok?
