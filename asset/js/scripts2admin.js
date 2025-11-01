// JS NAVBAR ADMIN
const menuToggle = document.getElementById("menutoggle");
const menu = document.querySelector(".menuAdmin");
const menu2 = document.querySelector(".dropdown-contentAdmin");


menuToggle.addEventListener("click", function() {
    menuToggle.classList.toggle("active");
    menu.classList.toggle('active');
    menu2.classList.toggle('dropdown-contentAdmin');
});