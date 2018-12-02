<template>
    <div id="map">
        <l-map ref="worldMap"
               :zoom="zoom"
               :center="center"
               style="min-height:800px;"
               :minZoom="3"
               :maxZoom="3"
               :options = "{zoomControl: false}"
               :bounds="bounds"
               :max-bounds="maxBounds"
        >
            <l-tile-layer :url="url" :attribution="attribution"></l-tile-layer>
            <l-geo-json
                    :geojson="geojsonRed"
                    :options="geojsonRed.options"
            />
            <l-geo-json
                    :geojson="geojsonGreen"
                    :options="geojsonGreen.options"
            />
            <l-geo-json
                    :geojson="geojsonYellow"
                    :options="geojsonYellow.options"
            />
        </l-map>
    </div>
</template>

<script>
    import Vue2Leaflet from 'vue2-leaflet';
    import L from 'leaflet';
    delete L.Icon.Default.prototype._getIconUrl;

    L.Icon.Default.mergeOptions({
        iconUrl: '',
        iconSize: [52, 23],
        iconAnchor: [26, 23],
        popupAnchor: [1, -34],
    });

    export default {
        name: 'WorldMap',
        components: {
            'l-map': Vue2Leaflet.LMap,
            'l-tile-layer': Vue2Leaflet.LTileLayer,
            'l-polygon': Vue2Leaflet.LPolygon,
            'l-geo-json': Vue2Leaflet.LGeoJson
        },
        props: [
            'greenData',
            'yellowData',
            'redData'
        ],
        data() {
            return {
                zoom: 3,
                center: [20.53, 12.79],
                url: 'https://cartodb-basemaps-{s}.global.ssl.fastly.net/dark_all/{z}/{x}/{y}.png',
                attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
                bounds: L.latLngBounds([[-80.70081290280357, 0], [200.82991732677597, 0]]),
                maxBounds: L.latLngBounds([[-100.70081290280357,-100], [200.82991732677597, 100]]),
                geojsonGreen: {
                    options: {
                        "stroke": "#555555",
                        "stroke-width": 2,
                        "stroke-opacity": 1,
                        color: "#00aa22",
                        weight:1,
                        "fill-opacity": 0.5
                    },
                    "type":"FeatureCollection",
                    "features": JSON.parse(this.greenData),
                },
                geojsonRed: {
                    "type": "FeatureCollection",
                    options: {
                        "stroke": "#555555",
                        "stroke-width": 2,
                        "stroke-opacity": 1,
                        color: "#aa0019",
                        weight: 1,
                        "fill-opacity": 0.5
                    },
                    "features": JSON.parse(this.redData),
                },
                geojsonYellow: {
                    "type": "FeatureCollection",
                    options: {
                        "stroke": "#555555",
                        "stroke-width": 2,
                        "stroke-opacity": 1,
                        color: "#a1aa00",
                        weight: 1,
                        "fill-opacity": 0.5
                    },
                    "features": JSON.parse(this.yellowData),
                }
            }
        },
        mounted() {
        }
    }
</script>
<style>
    @import '~leaflet/dist/leaflet.css';
</style>