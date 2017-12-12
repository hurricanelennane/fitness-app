function createWorkoutView(workout){
  return $($.parseHTML(' <div class="workout" id="w'+workout.id+'"></div>')).append(
  $.parseHTML('<span class="wtext">'+workout.name+'</span>')).append(
  $.parseHTML('<span class="wtext">'+workout.description+'</span>')).append(
  $.parseHTML('<button class="options">Options</button>'));
}
var templates = {
  exercises : {navbar: "<li><a class='nav active' href='javascript:void(0)'>Exercises</a></li>\
                 <li><a class='nav' href='javascript:void(0)'>Workouts</a></li>",
                collectView: function(){
                      $.ajax({
                        cache: false,
                        type: "GET",
                        url: "http://localhost:8888/services/Workout.php/",
                        success: function (resp) {
                          var workouts = $.parseJSON(resp);
                          if(workouts){
                            var workoutDivs = [];
                            for(i=0; i<workouts.length; i++){
                              workoutDivs.push(createWorkoutView(workouts[i]));
                            }
                            $("#main-container").append(workoutDivs);
                          }
                          else{
                            alert("Workout retrevial failed");
                          }
                        },
                        error: function(xhr, textStatus, errorThrown){
                          alert("Username lookup failed");
                        }
                      });
                } },
  dashboard : {navbar: "<li><a class='nav active' href='javascript:void(0)'>Home</a></li>\
                 <li><a class='nav' href='about.html'>About</a></li>\
                 <li><a class='nav' href='javascript:void(0)'>Contact</a></li>"},
  contact : {navbar:"<li><a class='nav' href='javascript:void(0)'>Home</a></li>\
                 <li><a class='nav' href='about.html'>About</a></li>\
                 <li><a class='nav active' href='javascript:void(0)'>Contact</a></li>",
             collectView: function(){
              $("#main-container").html(ABOUT_PAGE);
             }} 

};
function openMenu() {
    document.getElementById("myDropdown").classList.toggle("show");
}

function changeView(view){
  $(".navbar").children().remove("li");
  $("#main-container").empty();
  $(".navbar").prepend(templates[view].navbar);
  templates[view].collectView();

}

//Any code not referenced in html goes here
$(document).ready(function(){
  window.onclick = function(event) {
    if (!event.target.matches('#main-drop')) {

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
  $(".options").click(function(event){
    var id = event.target.id.replace("w","");
     $.ajax({
        cache: false,
        type: "OPTIONS",
        url: "http://localhost:8888/services/Workout.php/"+id,
        success: function (resp) {
          var options = $.parseJSON(resp);
          $(event.target).siblings(".dropdown-content");
        },
        error: function(xhr, textStatus, errorThrown){
          alert(textStatus);
        }
      });
  });
  $("a.nav").click(function(event){
    changeView($(event.target).text().toLowerCase());
  });
});

