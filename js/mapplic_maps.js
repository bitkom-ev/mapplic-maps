Drupal.behaviors.InitializeMapplic = {
    attach: function (context, settings) {
        console.log(drupalSettings.mapplic_maps);
        var mapplic = jQuery("#mapplic_maps").mapplic({
            action: 'tooltip',
            animate: drupalSettings.mapplic_maps.animate,
            clearbutton: drupalSettings.mapplic_maps.clearbutton,
            height: drupalSettings.mapplic_maps.map_height,
            hovertip: drupalSettings.mapplic_maps.hovertip,
            lightbox: false,
            locations: drupalSettings.mapplic_maps.locations,
            mapfill: drupalSettings.mapplic_maps.mapfill,
            maxscale: drupalSettings.mapplic_maps.maxscale,
            source: drupalSettings.mapplic_maps.source,
            sidebar: drupalSettings.mapplic_maps.sidebar,
            width: drupalSettings.mapplic_maps.map_width,
            minimap: drupalSettings.mapplic_maps.minimap,
            fullscreen: drupalSettings.mapplic_maps.fullscreen,
            search: drupalSettings.mapplic_maps.search,
            developer: drupalSettings.mapplic_maps.developer,
            zoom: drupalSettings.mapplic_maps.zoom,
            zoombuttons: drupalSettings.mapplic_maps.zoombuttons,
        });
     //console.log(mapplic);
    }
};
