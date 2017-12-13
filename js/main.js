function createWorkoutView(workout){
  var view = $($.parseHTML(' <div class="workout" id="w'+workout.id+'"></div>')).append(
  $.parseHTML('<span class="wtext">'+workout.name+'</span>')).append(
  $.parseHTML('<span class="wtext">'+workout.description+'</span>')).append(
  $.parseHTML('<div class="dropdown-content list-item"></div>'));
  var options = $.parseHTML('<button class="options">Options</button>');
  $(options).click(function(event){
  var id =$(event.target).parent().get(0).id.replace("w","");
  var e = event;
     $.ajax({
        cache: false,
        type: "OPTIONS",
        url: "http://localhost:8888/services/Workout.php/"+id,
        success: function (resp) {
          var options = $.parseJSON(resp);
          var dropcontainer = $(e.target).siblings(".dropdown-content");
          dropcontainer.empty();
          for(i=0; i<options.length; i++){
            dropcontainer.append(options[i]);
          }
          dropcontainer.toggle();
        },
        error: function(xhr, textStatus, errorThrown){
          alert(textStatus);
        }
      });
  });
  view.append(options);
  return view;

}
var templates = {
  exercises : {navbar: "<li><a class='nav active' href='javascript:void(0)'>Exercises</a></li>\
                 <li><a class='nav' href='javascript:void(0)'>Workouts</a></li>\
                 <li><a class='nav' id='createBtn' href='javascript:void(0)'>Create</a></li>",
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
function openMenu(event) {
    $("#myDropdown").toggle(true);
}

function changeView(view){
  $(".navbar").children().remove("li");
  $("#main-container").empty();
  $(".navbar").prepend(templates[view].navbar);
  templates[view].collectView();
  if(view == "exercises"){
    $("#createBtn").click(function(event){
      $("#createModal").fadeIn(500);
    });
  }
}
/*
function initHandlers(){
    $(".options").click(function(event){
    var id = event.target.id.replace("w","");
     $.ajax({
        cache: false,
        type: "OPTIONS",
        url: "http://localhost:8888/services/Workout.php/"+id,
        success: function (resp) {
          var options = $.parseJSON(resp);
          var dropcontainer = $(event.target).siblings(".dropdown-content");
          for(i=0; i<options.length; i++){
            dropcontainer.append(options.get(i));
          }
        },
        error: function(xhr, textStatus, errorThrown){
          alert(textStatus);
        }
      });
  });
  $("a.nav").click(function(event){
    changeView($(event.target).text().toLowerCase());
  });
}
*/

//Any code not referenced in html goes here
$(document).ready(function(){

  window.onclick = function(event) {
    $(".dropdown-content").toggle(false);
  }

  $("#main-drop").click(function(event){
    event.stopPropagation();
    $("#myDropdown").toggle(true);
  });

  $("form[name='createForm']").submit(function(event){
    event.preventDefault();
    var nameBox = $("input[name='name']");
    var descBox = $("input[name='description']");
    var intensityBox = $("input[name='intensity']");

     $.ajax({
            cache: false,
            type: "POST",
            url: "http://localhost:8888/services/Workout.php/",
            data: JSON.stringify({name: nameBox.val(),
                                  description: descBox.val(),
                                  intensity: intensityBox.val()}),
            contentType: "application/json; charset=utf-8",
            success: function (resp) {
              if(resp){
                alert(resp);
                $("#main-container").prepend(createWorkoutView(JSON.parse(resp)));
                $("#createModal").fadeOut(500);
              }
              else{
                alert("Add failed");
              }
            },
          error: function(xhr, textStatus, errorThrown){
            alert("Add failed due to errror. Error: "+textStatus);
          }
        });
  });
});

