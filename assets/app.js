/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.scss in this case)
import './styles/app.scss';
import { Tooltip, Toast, Popover } from 'bootstrap';

// start the Stimulus application
import './bootstrap';

let arrayMarkers = [];

// On initialise la carte
let carte = L.map('map').setView([47.6333, 6.1667], 11);

// On charge les "tuiles"
L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
    // Il est toujours bien de laisser le lien vers la source des données
    attribution: 'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
    minZoom: 1,
    maxZoom: 20
}).addTo(carte);

let markers = L.markerClusterGroup();

// On personnalise le marqueur
let icone = L.icon({
    iconUrl: "images/marker/mark.png",
    iconSize: [50, 50],
    iconAnchor: [25, 60],
    popupAnchor: [0, -60]
})

let xmlhttp = new XMLHttpRequest();

xmlhttp.onreadystatechange = () => {
    // La transaction est terminée ?
    if(xmlhttp.readyState == 4){
        // Si la transaction est un succès
        if(xmlhttp.status == 200){
            // On traite les données reçues
            let donnees = JSON.parse(xmlhttp.responseText)
            console.log(donnees)
            // On boucle sur les données (ES8)
            Object.entries(donnees.agences).forEach(agence => {
                console.log(agence)
                // Ici j'ai une seule agence
                // On crée un marqueur pour l'agence
                let marker = L.marker([agence[1].lat, agence[1].lon], {icon: icone})
                marker.bindPopup("<img class='online' src='https://www.onlineformapro.com/wp-content/uploads/2020/01/logo-03.svg' ><h5 class='text-center'>"+agence[1].city+"</h5><ul class='list-group list-group-flush'><li class='list-group-item'>"+agence[1].address+"</li><li class='list-group-item'>"+agence[1].number+"</li><li class='list-group-item'>"+agence[1].mail+"</li><li class='list-group-item'>"+agence[1].comment+"</li></ul><div class='btnMapContact d-grid gap-2 col-12 mx-auto'><a href="+agence[1].city+" type='button' class='btn btn-outline-danger'>Nous Contacter</a></div>");

                markers.addLayer(marker); // On ajoute le marqueur au groupe
                // On ajoute le marqueur au tableau
                arrayMarkers.push(marker);
            })

        }else{
            console.log(xmlhttp.statusText);
        }
        // On regroupe les marqueurs dans un groupe Leaflet
        let groupe = new L.featureGroup(arrayMarkers);

        // On adapte le zoom au groupe
        carte.fitBounds(groupe.getBounds().pad(0.5));

        carte.addLayer(markers);
    }
}

xmlhttp.open("GET", "http://localhost:8000/map/mapinfo");
xmlhttp.send(null);