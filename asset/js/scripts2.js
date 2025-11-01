// JS NAVBAR
const menuToggle = document.getElementById("menutoggle");
const menu = document.querySelector(".menu");
const menudrop = document.querySelector('.dropdown-content');

menuToggle.addEventListener("click", function() {
    menuToggle.classList.toggle("active");
    menu.classList.toggle('active');
    menudrop.classList.toggle('dropdown-content');
});