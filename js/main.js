var templates = {
  exercises : {navbar: "<li><a class='active' href='javascript:void(0)'>Exercises</a></li>\
                 <li><a href='javascript:void(0)'>Workouts</a></li>"},
  dashboard : {navbar: "<li><a class='active' href='javascript:void(0)'>Home</a></li>\
                 <li><a href='javascript:void(0)'>About</a></li>\
                 <li><a href='javascript:void(0)'>Contact</a></li>"}

};

function openMenu() {
    document.getElementById("myDropdown").classList.toggle("show");
}

function changeView(view){
  $(".navbar").children().remove("li");
  $(".navbar").prepend(templates[view].navbar);
}

//Any code not referenced in html goes here
$(document).ready(function(){
  window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {

    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}
});

