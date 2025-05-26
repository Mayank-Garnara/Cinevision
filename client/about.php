<?php
session_start();
include("../common/connection/connection.php");
include("common/function.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Play Show - About Us</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/global.css" rel="stylesheet">
	<link href="css/about.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Overpass&display=swap" rel="stylesheet">
	<script src="js/bootstrap.bundle.min.js"></script>
</head>

<body>

	<div class="main clearfix position-relative">
	<?php include("common/pages/nav.php"); ?>
		<div class="main_about clearfix">
			<section id="center" class="center_blog">
				<div class="container-xl">
					<div class="row center_o1">
						<div class="col-md-12">
							<h2 class="text-white">About Play Show</h2>
							<h6 class="mb-0 mt-3 fw-normal col_red"><a class="text-light" href="#">Home</a> <span
									class="mx-2 text-muted">/</span> About Us</h6>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>

	
	<section id="feature" class="p_3">
		<div class="container-xl">
			<div class="feature_1 row">
				<div class="col-md-6">
					<div class="feature_1l clearfix">
						<h5 class="col_red">YOUR ULTIMATE STREAMING EXPERIENCE</h5>
						<h1>WHY CHOOSE PLAY SHOW?</h1>
						<p>Play Show is a premium streaming platform dedicated to bringing you the best in entertainment. With thousands of movies, TV shows, and exclusive originals, we're committed to delivering exceptional quality and an unparalleled viewing experience.</p>
						<p>Since our launch in 2015, we've grown to become one of the most trusted streaming services, serving millions of satisfied subscribers worldwide with cutting-edge technology and a constantly expanding library.</p>
						<div class="feature_1li1 row">
							<div class="col-md-6">
								<div class="feature_1li1l clearfix">
									<h4>4K Ultra HD</h4>
									<p>Experience crystal-clear streaming with our advanced adaptive bitrate technology...</p>
								</div>
							</div>
							<div class="col-md-6">
								<div class="feature_1li1l clearfix">
									<h4>Multi-Device</h4>
									<p>Watch seamlessly across all your devices with synchronized progress tracking...</p>
								</div>
							</div>
						</div>
						<p class="mb-0">We're constantly innovating to bring you the best features, from personalized recommendations to offline viewing, ensuring you never miss a moment of your favorite content.</p>
					</div>
				</div>
				
			</div>
		</div>
	</section>



	<!-- Rest of your existing footer code remains the same -->
	<?php include("common/pages/footer.html") ?>

	<script>
		window.onscroll = function () { myFunction() };

		var navbar_sticky = document.getElementById("navbar_sticky");
		var sticky = navbar_sticky.offsetTop;
		var navbar_height = document.querySelector('.navbar').offsetHeight;

		function myFunction() {
			if (window.pageYOffset >= sticky + navbar_height) {
				navbar_sticky.classList.add("sticky")
				document.body.style.paddingTop = navbar_height + 'px';
			} else {
				navbar_sticky.classList.remove("sticky");
				document.body.style.paddingTop = '0'
			}
		}
	</script>

</body>
</html>