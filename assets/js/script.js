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

function login() {


    // if(getCookie("Login-admin")) {
    //     const response = confirm("Hi I see this is an admin login, do you want to go to your user panel or to the admin panel. Click 'OK' to go to the admin panel. Click on 'Cancel' to go to the user panel.");


    //     if (response) {
    //         window.location.href = "./panel/";
    //     } else {
    //         window.location.href = "./myaccount/";
    //     }
    // } else if(getCookie("Login")){
    //     window.location.href = "./myaccount/";
    // }

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

};

function openRegister() {
    document.getElementById("login_form").style.display = "none";
    document.getElementById("register_form").style.display = "block";
}

function closeLogin(number) {
    if (number == 1) {
        document.querySelector(".form.login").style.animation = "popout .3s";
        setTimeout(() => {  document.querySelector(".form.login").style.display = "none"; }, 290);
    }
    else if (number == 2) {
        document.getElementById("register_form").style.animation = "popout .3s";
        setTimeout(() => {      document.getElementById("register_form").style.display = "none"; }, 290);
    }
    else if (number == 4) {
        document.getElementById("weetjes-aanmaken-form").style.animation = "popout .3s";
        setTimeout(() => {       document.getElementById("weetjes-aanmaken-form").style.display = "none"; }, 290);
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

function OpenStatusWeetjes() {
    document.getElementById("weetjes-aanmaken-form").style.display = "none";
    document.getElementById("weetjes-aanmaken-form").style.display = "block";
}

