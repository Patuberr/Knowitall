const hamburger = document.getElementById("hamburger");
const navMenu = document.querySelector(".nav-menu");
const navLink = document.querySelectorAll(".nav-link");

hamburger.addEventListener("click", mobileMenu);

function mobileMenu() {
    hamburger.classList.toggle("active");
    navMenu.classList.toggle("active");
}

navLink.forEach(n => n.addEventListener("click", closeMenu));

function closeMenu() {
    hamburger.classList.remove("active");
    navMenu.classList.remove("active");
}

function login(session) {
    if (session == 1) {
        window.location.href = '/panel';
    } else {
        if (document.getElementById("login_form").style.display == "block") {
            document.querySelector(".form.login").style.animation = "popout .3s";
            setTimeout(() => {  document.querySelector(".form.login").style.display = "none"; }, 290);
        } else if(document.getElementById("register_form").style.display == "block") {
            document.getElementById("register_form").style.animation = "popout .3s";
            setTimeout(() => {document.getElementById("register_form").style.display = "none"; }, 290);
        } else {
            document.getElementById("login_form").style.display = "block";
            document.getElementById("register_form").style.display = "none";
            document.getElementById("login_form").style.animation = "popup .3s";
        }
    }
};

function openRegister() {
    document.getElementById("login_form").style.display = "none";
    document.getElementById("register_form").style.display = "block";
}

function closeLogin(number) {
    if (number == 1) {
        document.querySelector(".form.login").style.animation = "popout .3s";
        setTimeout(() => {  document.querySelector(".form.login").style.display = "none"; }, 290);
    } else if (number == 2) {
        document.getElementById("register_form").style.animation = "popout .3s";
        setTimeout(() => {      document.getElementById("register_form").style.display = "none"; }, 290);
    } else if (number == 4) {
        document.getElementById("status-weetjes-form").style.animation = "popout .3s";
        setTimeout(() => {       document.getElementById("status-weetjes-form").style.display = "none"; }, 290);
    } else if (number == 5) {
        document.getElementById("weetjes-aanmaken-form").style.animation = "popout .3s";
        setTimeout(() => {       document.getElementById("weetjes-aanmaken-form").style.display = "none"; }, 290);
    } else if (number == 6) {
        document.getElementById("ingestuurde-weetjes-form").style.animation = "popout .3s";
        setTimeout(() => {       document.getElementById("ingestuurde-weetjes-form").style.display = "none"; }, 290);
    } else if (number == 7) {
        document.getElementById("overzicht-weetjes-form").style.animation = "popout .3s";
        setTimeout(() => {       document.getElementById("overzicht-weetjes-form").style.display = "none"; }, 290);
    } else if (number == 8) {
        document.getElementById("gebruikers-form").style.animation = "popout .3s";
        setTimeout(() => {       document.getElementById("gebruikers-form").style.display = "none"; }, 290);
    }

};

function togglePassword(number) {
    let eye = document.querySelector(`#eye_${number}`);
    var x = document.querySelector(`#id_password_${number}`);
    if (x.type === "password") {
      x.type = "text";
      eye.setAttribute('name', 'eye-off-outline')
      
    } else {
      x.type = "password";
      eye.setAttribute('name', 'eye-outline')
    }
  } 

function OpenWeetjesAanmaken() {
    document.getElementById("status-weetjes-form").style.display = "none";
    document.getElementById("ingestuurde-weetjes-form").style.display = "none";
    document.getElementById("overzicht-weetjes-form").style.display = "none";
    document.getElementById("gebruikers-form").style.display = "none";
    document.getElementById("weetjes-aanmaken-form").style.animation = "popup .3s";
    document.getElementById("weetjes-aanmaken-form").style.display = "block";
}

function openStatusWeetjes() {
    document.getElementById("weetjes-aanmaken-form").style.display = "none";
    document.getElementById("ingestuurde-weetjes-form").style.display = "none";
    document.getElementById("overzicht-weetjes-form").style.display = "none";
    document.getElementById("gebruikers-form").style.display = "none";    
    document.getElementById("status-weetjes-form").style.animation = "popup .3s";
    document.getElementById("status-weetjes-form").style.display = "block";
}

function openIngestuurdeWeetjes() {
    document.getElementById("weetjes-aanmaken-form").style.display = "none";
    document.getElementById("status-weetjes-form").style.display = "none";
    document.getElementById("overzicht-weetjes-form").style.display = "none";
    document.getElementById("gebruikers-form").style.display = "none";     
    document.getElementById("ingestuurde-weetjes-form").style.animation = "popup .3s";
    document.getElementById("ingestuurde-weetjes-form").style.display = "block";
}

function openOverzichtWeetjes() {
    document.getElementById("weetjes-aanmaken-form").style.display = "none";
    document.getElementById("status-weetjes-form").style.display = "none";
    document.getElementById("ingestuurde-weetjes-form").style.display = "none";
    document.getElementById("gebruikers-form").style.display = "none";
    document.getElementById("overzicht-weetjes-form").style.animation = "popup .3s";
    document.getElementById("overzicht-weetjes-form").style.display = "block";
}

function openGebruikers() {
    document.getElementById("weetjes-aanmaken-form").style.display = "none";
    document.getElementById("status-weetjes-form").style.display = "none";
    document.getElementById("ingestuurde-weetjes-form").style.display = "none";
    document.getElementById("overzicht-weetjes-form").style.display = "none";
    document.getElementById("gebruikers-form").style.animation = "popup .3s";
    document.getElementById("gebruikers-form").style.display = "block";
}

