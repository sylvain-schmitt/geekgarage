/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.scss in this case)
import './styles/leaflet.css';
import './styles/MarkerCluster.css';
import './styles/MarkerCluster.Default.css';
import { Tooltip, Toast, Popover } from 'bootstrap';
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';
import './map';
var myModal = document.getElementById('modal-contact')
var myInput = document.getElementById('myInput')

myModal.addEventListener('shown.bs.modal', function () {
  myInput.focus()
})

let mainNavLinks = document.querySelectorAll(".nav-link");

window.addEventListener("scroll", event => {
  let fromTop = window.scrollY;

  mainNavLinks.forEach(link => {
    let section = document.querySelector(link.hash);
    
    if (
        section.offsetTop <= fromTop &&
        section.offsetTop + section.offsetHeight > fromTop
        ) {
            link.classList.add("active");
    } else {
      link.classList.remove("active");
    }
  });
});

document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();

        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});
