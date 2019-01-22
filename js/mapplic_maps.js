Drupal.behaviors.InitializeMapplic = {
    attach: function (context, settings) {
        console.log(drupalSettings.mapplic_maps);
        var mapplic = jQuery("#mapplic_maps").mapplic({
            source: drupalSettings.mapplic_maps.source,
            clearbutton: drupalSettings.mapplic_maps.clearbutton,
            sidebar: drupalSettings.mapplic_maps.sidebar,
            mapfill: drupalSettings.mapplic_maps.mapfill,
            width: drupalSettings.mapplic_maps.map_width,
            height: drupalSettings.mapplic_maps.map_height,
            minimap: drupalSettings.mapplic_maps.minimap,
            maxscale: drupalSettings.mapplic_maps.maxscale,
            locations: drupalSettings.mapplic_maps.locations,
            fullscreen: drupalSettings.mapplic_maps.fullscreen,
            hovertip: drupalSettings.mapplic_maps.hovertip,
            search: drupalSettings.mapplic_maps.search,
            animate: drupalSettings.mapplic_maps.animate,
            developer: drupalSettings.mapplic_maps.developer,
            zoom: drupalSettings.mapplic_maps.zoom,
            lightbox: false,
            zoombuttons: drupalSettings.mapplic_maps.zoombuttons,

        });
        console.log(mapplic);
    }
};
