<?php
require_once("session.php");
?>
<head>
	<!-- Fonts import here -->
	<link href='https://fonts.googleapis.com/css?family=Bahiana|Barrio|Carter One|Carrois Gothic' rel='stylesheet'>
	<script src='js/jquery-3.2.1.js'></script>
	<script type='text/javascript' src='js/main.js'></script>
	<!-- <script type='text/javascript' src='fitness.js'></script> -->
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<title>Gainz Companion</title>
</head>
<body>
	<div>
	<ul class="navbar">
		<li><a class="active" href="index.php">Home</a></li>
		<li><a href="about.html">About</a></li>
		<li><a href="contact.html">Contact</a></li>
		<div class='dropdown'>
		<li class="main-btn"><button class='dropbtn' onclick="openMenu()">Gainz</button></li>
			<div class='dropdown-content' id='myDropdown'>
				<a href="javascript: void(0)" class="dropdown" onclick="changeView('dashboard')">Dashboard</a>
				<a href="javascript: void(0)" class="dropdown" onclick="changeView('exercises')">Search Exercises</a>
				<a href="javascript: void(0)" class="dropdown">My Workouts</a>
				<a href="logout.php" class="dropdown">Logout</a>
			</div>
		</div>
	</ul>
	</div>
	<div id="main-container">
	</div>
</body>
