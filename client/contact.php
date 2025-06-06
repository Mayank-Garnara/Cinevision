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
	<title>Play Show</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/global.css" rel="stylesheet">
	<link href="css/account.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Overpass&display=swap" rel="stylesheet">
	<script src="js/bootstrap.bundle.min.js"></script>

</head>

<body>

	<div class="main clearfix position-relative">
		<!-- <div class="main_1 clearfix position-absolute top-0 w-100">
			<section id="header">
				<nav class="navbar navbar-expand-md navbar-light" id="navbar_sticky">
					<div class="container-xl">
						<a class="navbar-brand fs-2 p-0 fw-bold text-white m-0 me-5" href="index.html"><i
								class="fa fa-youtube-play me-1 col_red"></i> Play Show </a>
						<button class="navbar-toggler" type="button" data-bs-toggle="collapse"
							data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
							aria-expanded="false" aria-label="Toggle navigation">
							<span class="navbar-toggler-icon"></span>
						</button>
						<div class="collapse navbar-collapse" id="navbarSupportedContent">
							<ul class="navbar-nav mb-0">

								<li class="nav-item">
									<a class="nav-link" aria-current="page" href="index.html">Home</a>
								</li>

								<li class="nav-item">
									<a class="nav-link" href="about.html">About </a>
								</li>

								<li class="nav-item dropdown">
									<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
										data-bs-toggle="dropdown" aria-expanded="false">
										Blog
									</a>
									<ul class="dropdown-menu drop_1" aria-labelledby="navbarDropdown">
										<li><a class="dropdown-item" href="blog.html"> Blog</a></li>
										<li><a class="dropdown-item border-0" href="blog_detail.html"> Blog Detail</a>
										</li>
									</ul>
								</li>

								<li class="nav-item dropdown">
									<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
										data-bs-toggle="dropdown" aria-expanded="false">
										Pages
									</a>
									<ul class="dropdown-menu drop_1" aria-labelledby="navbarDropdown">
										<li><a class="dropdown-item" href="account.html"> My Account</a></li>
										<li><a class="dropdown-item border-0" href="contact.html"> Contact</a></li>
									</ul>
								</li>

								<li class="nav-item">
									<a class="nav-link" href="team.html">Team</a>
								</li>

								<li class="nav-item">
									<a class="nav-link active" href="contact.html">Contact</a>
								</li>


							</ul>
							<ul class="navbar-nav mb-0 ms-auto">
								<li class="nav-item dropdown">
									<a class="nav-link dropdown-toggle dropdown_search" href="#" id="navbarDropdown"
										role="button" data-bs-toggle="dropdown" aria-expanded="true">
										<i class="fa fa-search"></i>
									</a>
									<ul class="dropdown-menu drop_1 drop_o p-3" aria-labelledby="navbarDropdown"
										data-bs-popper="none">
										<li>
											<div class="input-group p-2">
												<input type="text" class="form-control border-0"
													placeholder="Search Here">
												<span class="input-group-btn">
													<button class="btn btn-primary bg-transparent border-0 fs-5"
														type="button">
														<i class="fa fa-search col_red"></i> </button>
												</span>
											</div>
										</li>
									</ul>
								</li>
								<li class="nav-item dropdown">
									<a class="nav-link dropdown-toggle dropdown_search" href="#" id="navbarDropdown"
										role="button" data-bs-toggle="dropdown" aria-expanded="true">
										<i class="fa fa-bell-o"></i>
									</a>
									<ul class="dropdown-menu drop_1 drop_o drop_o1 p-0" aria-labelledby="navbarDropdown"
										data-bs-popper="none">
										<li class="bg_red text-white p-3 fw-bold">
											Notification <span
												class="bg-white col_red span_1  rounded-circle d-inline-block me-1">3</span>
										</li>
										<li class="p-3 pb-0">
											<div class="row">
												<div class="col-md-2 pe-0 col-2"><i
														class="fa fa-circle col_red font_8"></i></div>
												<div class="col-md-10 ps-0 col-10">
													<a class="fw-normal text-capitalize" href="#">Semper</a> download
													2000+ Simple Line Icons and Explore<br>
													<span class="text-muted font_14">2 Days</span>
												</div>
											</div>
										</li>
										<hr>
										<li class="p-3 pt-0">
											<div class="row">
												<div class="col-md-2 pe-0 col-2"><i
														class="fa fa-circle col_red font_8"></i></div>
												<div class="col-md-10 ps-0 col-10">
													Added new movie <a class="fw-normal text-capitalize"
														href="#">Porta</a> Cheatsheet to Start Using With Your
													Projects.<br>
													<span class="text-muted font_14">3 Days</span>
												</div>
											</div>
										</li>
									</ul>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="account.html"><i
											class="fa fa-user fs-4 align-middle me-1 lh-1 col_red"></i> Account </a>
								</li>
							</ul>
						</div>
					</div>
				</nav>
			</section>

		</div> -->
		
		<?php include("common/pages/nav.php") ?>
		<div class="main_contact clearfix">
			<section id="center" class="center_blog">
				<div class="container-xl">
					<div class="row center_o1">
						<div class="col-md-12">
							<h2 class="text-white">Contact</h2>
							<h6 class="mb-0 mt-3 fw-normal col_red"><a class="text-light" href="#">Home</a> <span
									class="mx-2 text-muted">/</span> Contact</h6>
						</div>
					</div>
				</div>
			</section>
		</div>

	</div>

	<section id="contact" class="p_3">
		<div class="container-xl">
			<div class="row contact_1 m-0 mb-5">
				<div class="col-md-4">
					<div class="contact_1i row">
						<div class="col-md-2">
							<div class="contact_1il">
								<span class="col_red fs-1"><i class="fa fa-building"></i></span>
							</div>
						</div>
						<div class="col-md-10">
							<div class="contact_1ir">
								<h5>250 Sixth Avenue, 31th floor Old York, NZ 11113-1279 USA</h5>
								<h6 class="mb-0">Find Us</h6>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="contact_1i row">
						<div class="col-md-2">
							<div class="contact_1il">
								<span class="col_red fs-1"><i class="fa fa-phone"></i></span>
							</div>
						</div>
						<div class="col-md-10">
							<div class="contact_1ir">
								<h5>1-234-567-8900</h5>
								<h6 class="mb-0">Make a call</h6>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="contact_1i row">
						<div class="col-md-2">
							<div class="contact_1il">
								<span class="col_red fs-1"><i class="fa fa-envelope-o"></i></span>
							</div>
						</div>
						<div class="col-md-10">
							<div class="contact_1ir">
								<h5>info@gmail.com</h5>
								<h6 class="mb-0">Drop us a line</h6>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row contact_2">
				<div class="col-md-6">
					<div class="contact_2l">
						<div class="blog_1d3i row">
							<div class="col-md-6">
								<div class="blog_1d3il">
									<input placeholder="Name" class="form-control" type="text">
								</div>
							</div>
							<div class="col-md-6">
								<div class="blog_1d3il">
									<input placeholder="Enter Email" class="form-control" type="text">
								</div>
							</div>
						</div>
						<div class="blog_1d3i  row">
							<div class="col-md-12">
								<div class="blog_1d3il">
									<input placeholder="Your Phone" class="form-control mt-4" type="text">
								</div>
							</div>

						</div>
						<div class="blog_1d3i  row">
							<div class="col-md-12">
								<div class="blog_1d3il">
									<textarea placeholder="Write a Message"
										class="form-control form_text mt-4"></textarea>
									<h5 class="mt-4"><a class="button_1" href="#">Send Message </a></h5>
								</div>
							</div>

						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="contact_2r">
						<iframe
							src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d114964.53925916665!2d-80.29949920266738!3d25.782390733064336!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88d9b0a20ec8c111%3A0xff96f271ddad4f65!2sMiami%2C+FL%2C+USA!5e0!3m2!1sen!2sin!4v1530774403788"
							height="420" style="border:0; width:100%;" allowfullscreen=""></iframe>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section id="contact_h" class="p_3 bg-light">
		<div class="container-xl">
			<div class="row contact_h_1">
				<div class="col-md-6">
					<div class="contact_h_1l">
						<div class="grid clearfix">
							<figure class="effect-jazz mb-0">
								<a href="#"><img src="img/25.jpg" class="w-100" alt="abc"></a>
							</figure>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="contact_h_1r bg-white">
						<h3>Feel Free to Contact Us</h3>
						<p class="mb-3">Distinctively exploit optimal alignments for intuitive coordinate business
							applications technologies</p>
						<input class="form-control mt-3" placeholder="Name" type="text">
						<input class="form-control mt-3" placeholder="Phone" type="text">
						<input class="form-control mt-3" placeholder="Email" type="text">
						<select name="categories" class="form-select mt-3" required="">
							<option value="">Choose Service Type</option>
							<option>Computer</option>
							<option>Business</option>
							<option>Chemistry</option>
							<option>Physics</option>
							<option>Photoshop</option>
							<option>Management</option>
						</select>
						<h6 class="mb-0 mt-4"><a class="button_1 d-block text-center" href="#">REQUEST FOR SUBMIT</a>
						</h6>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section id="footer" class="p_3 bg_dark">
		<div class="container-xl">
			<div class="row footer_1 text-center">
				<div class="col-md-12">
					<h1 class="text-white">Start for your first 30 days.</h1>
					<p class="text-light">Ready to watch? Enter your email to create or restart your membership.</p>
					<div class="input-group w-50 m-auto">
						<input type="text" class="form-control rounded-0 fs-6" placeholder="Type your e-mail address">
						<span class="input-group-btn">
							<button class="btn btn-primary bg_red rounded-0 bg_red fw-bold" type="button">
								GET STARTED </button>
						</span>
					</div>
				</div>
			</div>
			<div class="row footer_2 mt-4 pt-4">
				<div class="col-md-4">
					<div class="footer_2i">
						<h5 class="text-white">Questions? Call 0850-380-6444</h5>
						<p class="text-muted mt-3">Format for custom post types that are not book or you can use else if
							to specify a second post type the same way as above.</p>
						<select name="categories" class="form-select mt-4 bg-transparent w-50 rounded-0 fw-bold"
							required="">
							<option value="">English</option>
							<option>French</option>
							<option>Hindi</option>
							<option>American</option>
							<option>German</option>
						</select>
					</div>
				</div>
				<div class="col-md-2">
					<div class="footer_2i">
						<h5 class="text-uppercase col_red mb-3">Play Show</h5>
						<ul class="mb-0 row">
							<li class="col-md-12 col-6 p-0"><a class="text-muted" href="#">Play Show</a></li>
							<li class="mt-2 col-md-12 col-6 p-0"><a class="text-muted" href="#">Devices</a></li>
							<li class="mt-2 col-md-12 col-6 p-0"><a class="text-muted" href="#">Tips</a></li>
							<li class="mt-2 col-md-12 col-6 p-0"><a class="text-muted" href="#">Contact</a></li>
							<li class="mt-2 col-md-12 col-6 p-0"><a class="text-muted" href="#">Legal Notices</a></li>
							<li class="mt-2 col-md-12 col-6 p-0"><a class="text-muted" href="#">Our Terms</a></li>
						</ul>
					</div>
				</div>
				<div class="col-md-2">
					<div class="footer_2i">
						<h5 class="text-uppercase col_red mb-3">SUPPORT</h5>
						<ul class="mb-0 row">
							<li class="col-md-12 col-6 p-0"><a class="text-muted" href="#">Help Center</a></li>
							<li class="mt-2 col-md-12 col-6 p-0"><a class="text-muted" href="#">FAQ</a></li>
							<li class="mt-2 col-md-12 col-6 p-0"><a class="text-muted" href="#">Account</a></li>
							<li class="mt-2 col-md-12 col-6 p-0"><a class="text-muted" href="#">Privacy Policy</a></li>
							<li class="mt-2 col-md-12 col-6 p-0"><a class="text-muted" href="#">Media Center</a></li>
							<li class="mt-2 col-md-12 col-6 p-0"><a class="text-muted" href="#">Support</a></li>
						</ul>
					</div>
				</div>
				<div class="col-md-4">
					<div class="footer_2i">
						<h5 class="text-uppercase col_red mb-3">Newsletter</h5>
						<p class="text-muted mt-3">Format for custom post types that are not book or you can use else if
							to specify a second post type the same way as above.</p>
						<input class="form-control mt-3 bg-transparent rounded-0" placeholder="Enter Your Email"
							type="text">
						<h6 class="mb-0 text-uppercase mt-4"><a class="button" href="#"><i
									class="fa fa-location-arrow me-1"></i> SUBMIT NOW</a></h6>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section id="footer_b">
		<div class="container-xl">
			<div class="row footer_b1 text-center">
				<div class="col-md-12">
					<p class="mb-0 text-muted">© 2013 Your Website Name. All Rights Reserved | Design by <a
							class="col_red" href="http://www.templateonweb.com">TemplateOnWeb</a></p>
				</div>
			</div>
		</div>
	</section>

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