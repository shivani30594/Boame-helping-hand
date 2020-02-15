<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1">

	<title>BOAME Web Application</title>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo ADMIN_IMAGES?>BOAME-transparent.png" />
	<link href="<?php echo ADMIN_CSS ?>bootstrap.min.css" rel="stylesheet"><!--bootstrap css-->
	<link href="<?php echo ADMIN_CSS ?>font-awesome.min.css" rel="stylesheet"><!--font-awesome css-->
	
	<link rel="stylesheet" type="text/css" href="<?php echo ADMIN_CSS ?>style.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo ADMIN_CSS ?>responsive.css"/>
	
	<script src="<?php echo ADMIN_JS ?>jquery.min.js"></script><!--jquery js-->
	<script src="<?php echo ADMIN_JS ?>bootstrap.min.js"></script><!--bootstrap js-->
</head>
<body>
	<div class="container">
		<div class="comming-soon">
			<div class="logo">
				<img src="<?php echo ADMIN_IMAGES ?>BOAME--1_jpg.png"/>
			</div>
			<div class="timer-wrapper">
				<p id="demo"></p>
			</div>
			<div class="video-wrapper">
				<video autoplay id="comming_soon_video" onclick="pauseVid()"> 
				<source src="<?php echo ADMIN_VIDEOS ?>videoplayback.mp4" type="video/mp4" >
				Your browser does not support the video tag.
				</video>
			</div>
		</div>
	</div>
<script>
var vid = document.getElementById("comming_soon_video"); 
var flag = 1;
function pauseVid() {
	if (flag == 1)
	{
    	vid.pause(); 
    	flag = 0;
	}
	else
	{
		vid.play(); 
		flag = 1;
	}
} 
	// Set the date we're counting down to
	var countDownDate = new Date("March 28, 2018 15:37:25").getTime();
	// Update the count down every 1 second
	var x = setInterval(function() {
    // Get todays date and time
    var now = new Date().getTime();
    // Find the distance between now an the count down date
    var distance = countDownDate - now;
    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    // Output the result in an element with id="demo"
    document.getElementById("demo").innerHTML = "<div><span class='first_child'>" + days +"</span>"+ "<span class='last_child'> Days </span></div> " + "<div><span class='first_child'>" + hours + "</span>"+ "<span class='last_child'> Hours </span></div>"
    + "<div><span class='first_child'>" + minutes + "</span>" +"<span class='last_child'> Minutes </span></div> "  + "<div><span class='first_child'>" + seconds + "</span>" + "<span class='last_child'> Seconds </span></div> ";
    // if (distance < 0) {
    //    //clearInterval(x);
    //    document.location.replace('https://boame.net/home/index');
    //   // document.getElementById("demo").innerHTML = "COMMING SOON";
    // }
}, 1000);
</script>
</body>
</html>