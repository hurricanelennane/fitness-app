<?php
require_once("session.php");
?>
<head>
	<!-- Fonts import here -->
	<link href='https://fonts.googleapis.com/css?family=Bahiana|Barrio|Carter One|Carrois Gothic|Barlow Semi Condensed

' rel='stylesheet'>
	<script src='js/jquery-3.2.1.js'></script>
	<script type='text/javascript' src='js/main.js'></script>
	<script type ="text/javascript" src='js/pagedef.js'></script>
	<!-- <script type='text/javascript' src='fitness.js'></script> -->
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<title>Gainz Companion</title>
</head>
<body>
	<div>
	<ul class="navbar">
		<li><a class="nav active" href="index.php">Home</a></li>
		<li><a class="nav" href="about.html">About</a></li>
		<li><a class="nav" href="contact.html">Contact</a></li>
		<div class='dropdown'>
			<li class="main-btn"><button id='main-drop'>Gainz</button></li>
			<div class="dropdown-content" id='myDropdown'>
				<a href="javascript: void(0)" class="dropdown" onclick="changeView('dashboard')">Dashboard</a>
				<a href="javascript: void(0)" class="dropdown" onclick="changeView('exercises')">Search Exercises</a>
				<a href="javascript: void(0)" class="dropdown">My Workouts</a>
				<a href="logout.php" class="dropdown">Logout</a>
			</div>
		</div>
	</ul>
	</div>
	<div class="modal-bg" id="createModal">
			<div class="modal-content">
				<form name="createForm">
					<label>Workout Name: </label><input tabindex=1 type="text" name="name"></input><br>
					<p id="nameWarning" hidden>Name Must be at least one character</p>
					<label>Workout Description: </label><input tabindex=2 type="text" name="description"></input><br>
					<label>Workout Intensity: </label><input tabindex=3 type="text" name="intensity"></input><br>
					<input tabindex=3 type="submit" value="Confirm" id='createSubmit'></input>
				</form>
			</div>
	</div>
	<div id="main-container">
	</div>
</body>
