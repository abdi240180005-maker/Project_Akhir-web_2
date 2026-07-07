import './bootstrap';

import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';

import 'bootstrap-icons/font/bootstrap-icons.css';

import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

import Chart from 'chart.js/auto';

window.L = L;
window.Chart = Chart;

// Fix icon Leaflet
import markerIcon2x from 'leaflet/dist/images/marker-icon-2x.png';
import markerIcon from 'leaflet/dist/images/marker-icon.png';
import markerShadow from 'leaflet/dist/images/marker-shadow.png';

delete L.Icon.Default.prototype._getIconUrl;

L.Icon.Default.mergeOptions({
    iconRetinaUrl: markerIcon2x,
    iconUrl: markerIcon,
    shadowUrl: markerShadow,
});