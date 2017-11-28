<?php
require_once("session.php");
?>
<head>
	<script type='text/javascript' src='fitness.js'></script>
	<!-- Fonts import here -->
	<link href='https://fonts.googleapis.com/css?family=Bahiana|Barrio|Carter One|Carrois Gothic' rel='stylesheet'>
	<script src='jquery-3.2.1.js'></script>
	<!-- <script type='text/javascript' src='fitness.js'></script> -->
	<link rel="stylesheet" type="text/css" href="main.css">
	<title>Gainz Companion</title>
</head>
<body>
	<div>
	<ul class="navbar">
		<li><a class="active" href="index.html">Home</a></li>
		<li><a href="about.html">About</a></li>
		<li><a href="contact.html">Contact</a></li>
		<li><a href="gallery.html">Gallery</a></li>
		<div class='dropdown'>
		<li class="main-btn"><button class='dropbtn' onclick="openMenu()">Gainz</button></li>
			<div class='dropdown-content' id='myDropdown'>
				<a href='#'>Link 1</a>
				<a href='#'>Link 2</a>
				<a href='#'>Link 3</a>
			</div>
		</div>
	</ul>
	</div>
</body>
