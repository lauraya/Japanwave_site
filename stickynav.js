
//Instructions qui servent à garder la navbar en haut de la page
 window.onscroll = function() {myFunction()};

var barre = document.getElementById("barre");

var sticky = barre.offsetTop;

function myFunction() {
  if (window.pageYOffset >= sticky) {
    barre.classList.add("sticky")
  } else {
    barre.classList.remove("sticky");
  }
} 
