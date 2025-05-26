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

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
		integrity="sha512-Avb2QiuDEEvB4bZJYdft2mNjVShBftLdPG8FJ0V7irTLQ8Uo0qcPxh4Plq7G5tGm0rU+1SPhVotteLpBERwTkw=="
		crossorigin="anonymous" referrerpolicy="no-referrer" />

	<link href="css/global.css" rel="stylesheet">
	<link href="css/index.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Overpass&display=swap" rel="stylesheet">
	<!-- Font Awesome Free 6 CDN -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<script src="js/bootstrap.bundle.min.js"></script>

	<!-- Modal style for select movies categories -->
	<style>
		:root {
			--primary-color: #dc3545;
			--dark-color: #2b2b2b;
			--light-color: #ffffff;
			--shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
		}

		body {
			margin: 0;
			font-family: sans-serif;
		}

		/* Modal Overlay */
		.modal-overlay {
			position: fixed;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			background: rgba(0, 0, 0, 0.8);
			display: none;
			justify-content: center;
			align-items: center;
			z-index: 1000;
			backdrop-filter: blur(3px);
		}

		/* Modal Content */
		.modal-content {
			background: var(--light-color);
			padding: 2rem;
			border-radius: 16px;
			width: 90%;
			max-width: 800px;
			max-height: 90vh;
			transform: scale(0.8);
			opacity: 0;
			transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
			box-shadow: var(--shadow);
			border: 2px solid var(--dark-color);
			overflow: hidden;
			display: flex;
			flex-direction: column;
		}

		.modal-content.active {
			transform: scale(1);
			opacity: 1;
		}

		.category-wrapper {
			flex: 1;
			overflow-y: auto;
			margin: 1rem 0;
			padding-right: 0.5rem;
		}

		.category-grid {
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
			gap: 1.5rem;
		}

		.category-card {
			position: relative;
			border: 2px solid var(--dark-color);
			border-radius: 12px;
			padding: 2rem 1.5rem;
			cursor: pointer;
			transition: all 0.3s ease;
			user-select: none;
			background: var(--light-color);
			display: flex;
			flex-direction: column;
			align-items: center;
			text-align: center;
			box-shadow: var(--shadow);
		}

		.category-card:hover {
			transform: translateY(-5px);
			box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
		}

		.category-card input[type="checkbox"] {
			position: absolute;
			opacity: 0;
			height: 0;
			width: 0;
		}

		.category-card.checked {
			border-color: var(--primary-color);
			background: var(--primary-color);
			color: var(--light-color);
		}

		.check-icon {
			position: absolute;
			top: -10px;
			right: -10px;
			width: 32px;
			height: 32px;
			background: var(--light-color);
			border: 2px solid var(--dark-color);
			border-radius: 50%;
			display: flex;
			align-items: center;
			justify-content: center;
			opacity: 0;
			transform: scale(0.5);
			transition: all 0.3s ease;
		}

		.checked .check-icon {
			opacity: 1;
			transform: scale(1);
			background: var(--primary-color);
			border-color: var(--primary-color);
		}

		.check-icon i {
			color: var(--light-color);
			font-size: 16px;
		}

		.category-icon {
			font-size: 2.5rem;
			margin-bottom: 1rem;
			color: var(--dark-color);
			transition: color 0.3s ease;
		}

		.checked .category-icon {
			color: var(--light-color);
		}

		.modal-footer {
			position: sticky;
			bottom: 0;
			background: var(--light-color);
			padding-top: 1rem;
			display: flex;
			justify-content: flex-end;
			gap: 1rem;
			border-top: 1px solid #ccc;
		}

		.btn {
			padding: 0.75rem 2rem;
			border: none;
			border-radius: 8px;
			cursor: pointer;
			font-weight: 600;
			transition: all 0.3s ease;
			text-transform: uppercase;
			letter-spacing: 1px;
			box-shadow: var(--shadow);
		}

		.btn-primary {
			background: var(--primary-color);
			color: var(--light-color);
			border: 2px solid var(--dark-color);
		}

		.btn-primary:hover {
			transform: translateY(-2px);
			background: #c82333;
		}

		.btn-secondary {
			background: var(--dark-color);
			color: var(--light-color);
			border: 2px solid var(--dark-color);
		}

		.btn-secondary:hover {
			background: #1a1a1a;
			transform: translateY(-2px);
		}

		h2 {
			color: var(--dark-color);
			text-align: center;
			margin-bottom: 1rem;
			font-size: 2rem;
		}

		.trigger-btn {
			margin: 3rem auto;
			display: block;
			padding: 1.25rem 3rem;
			font-size: 1.25rem;
			background: var(--primary-color);
			border: 2px solid var(--dark-color);
			color: var(--light-color);
			box-shadow: var(--shadow);
		}
	</style>


</head>

<body>
	<div class="main clearfix position-relative">

		<?php include("common/pages/nav.php"); ?>

		<!-- New realised -->
		<div class="main_2 clearfix">
			<section id="center" class="center_home">
				<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
					<div class="carousel-indicators">
						<button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0"
							class="active" aria-label="Slide 1"></button>
						<button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
							aria-label="Slide 2" class="" aria-current="true"></button>
						<button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
							aria-label="Slide 3"></button>
					</div>
					<div class="carousel-inner">


						<?php
						// get the three latest release movies
						$query = "SELECT id, name, movie_year, tags,age_rating, description, banner FROM movie  
						where NOW() > upload_from AND movie_status=1 LIMIT 3";
						$stmt = $pdo->prepare($query);
						$stmt->execute();
						$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

						$firstIndex = true;

						foreach ($result as $movie) {
							$activeClass = $firstIndex ? 'active' : '';
							?>
							<div class="carousel-item <?= $activeClass ?>">
								<img src="../uploads/movies/<?= $movie['id'] ?>/photos/<?= $movie['banner'] ?>"
									class="d-block w-100" alt="...">
								<div class="carousel-caption d-md-block">
									<h5 class="text-white-50 release ps-2 fs-6">NEW RELEASES</h5>
									<h1 class="font_80 mt-4"><?= $movie['name'] ?></h1>
									<h6 class="text-white">
										<?php if ($movie['age_rating'] == "18+" || $movie['age_rating'] == "R") {
											echo '<span class="rating d-inline-block rounded-circle me-2 col_red " style="color: #dc3545; border-color: #c82333;">' . $movie['age_rating'] . '</span>';
										} else {
											echo '<span class="rating d-inline-block rounded-circle me-2 col_green ">' . $movie['age_rating'] . '</span>';
										}
										?>


										<span class="mx-3"><?= $movie['movie_year'] ?></span>
										<span class="col_red text-capitalize"><?= $movie['tags'] ?></span>
									</h6>
									<p class="mt-4"><?= $movie['description'] ?></p>

									<div class="mt-3 mb-0 ">
										<a href="common/movie_middleware.php?type=movie&id=<?= $movie['id'] ?>"
											class="btn btn-primary"><i class="fa fa-youtube-play me-1"></i> Watch
											Now</a>
									</div>
									<div class="d-flex mt-4">
										<div class="mt-2 mb-0 ">
											<a href="common/movie_middleware.php?type=trailler&id=<?= $movie['id'] ?>" class="btn btn-primary"><i class="fa fa-youtube-play me-1"></i>
												Trailler</a>
										</div>

										<div class="mt-2 mb-0 ms-2 ">
											<a href="common/movie_middleware.php?type=Teaser&id=<?= $movie['id'] ?>" class="btn btn-primary"><i class="fa fa-youtube-play me-1"></i>
												Teaser</a>
										</div>
									</div>



								</div>
							</div>
							<?php
							$firstIndex = false; // After first loop
						}
						?>
					</div>

					<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
						data-bs-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Previous</span>
					</button>
					<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
						data-bs-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Next</span>
					</button>
				</div>
			</section>
		</div>
	</div>






	<!-- Suggest for you  -->
	<section id="stream" class="p_3">
		<div class="container-xl">
			<div class="row stream_1">
				<div class="col-md-12">
					<h1 class="mb-0">Suggest for you</h1>
					<h6 class="col_red d-flex justify-content-end m-auto"><a href="category.php?category=Suggest"> See
							More</a></h6>
				</div>
			</div>
			<div class="row stream_2 mt-4">
				<?php
				$movies = [];
				$filled = 0;

				$where = "1"; // default: select all
				if (!empty($_SESSION['user']['preference'])) {

					$searchTags;
					if ($_SESSION['user']['preference']) {
						global $searchTags;
						$searchTags = explode(',', $_SESSION['user']['preference']);
					} else {
						$searchTags = explode(',', 'action, drama, crime, romantic');
					}

					$conditions = [];
					foreach ($searchTags as $tag) {
						$conditions[] = "tags LIKE '%" . trim($tag) . "%'";
					}

					if (!empty($conditions)) {
						$where = implode(" OR ", $conditions);
					}
				}

				// Fetch movies based on preference
				$sql = "SELECT * FROM movie WHERE $where and NOW() > upload_from AND movie_status=1 LIMIT 4";
				$stmt = $pdo->query($sql);
				$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$filled = count($movies);

				//  If less than 4, fill remaining with random movies (excluding already shown ones)
				if ($filled < 4) {
					$excludeIds = array_column($movies, 'id');
					$placeholders = implode(',', array_fill(0, count($excludeIds), '?'));

					$sqlFill = "SELECT * FROM movie";
					if ($placeholders) {
						$sqlFill .= " WHERE id NOT IN ($placeholders) and NOW() > upload_from AND movie_status=1";
					}
					$sqlFill .= " ORDER BY RAND() LIMIT " . (4 - $filled);

					$stmtFill = $pdo->prepare($sqlFill);
					$stmtFill->execute($excludeIds);
					$moreMovies = $stmtFill->fetchAll(PDO::FETCH_ASSOC);

					$movies = array_merge($movies, $moreMovies); // Combine both
				
					// print_r(($result));
					// exit();
				
					foreach ($movies as $movie) {
						?>
						<div class="col-md-3 pe-0">
							<div class="stream_2im clearfix position-relative">
								<div class="stream_2im1 clearfix">
									<div class="grid clearfix">
										<figure class="effect-jazz mb-0">
											<!-- movieLink -->
											<a href="common/movie_middleware.php?type=movie&id=<?= $movie['id'] ?>"><img
													src="../uploads/movies/<?= $movie['id'] ?>/photos/<?= $movie['poster'] ?>"
													class="w-100" alt="abc"></a>
										</figure>
									</div>
								</div>
								<div class="stream_2im2 position-absolute w-100 h-100 p-3 top-0  clearfix">
									<h6 class="font_14 col_red"><?= $movie['tags'] ?></h6>
									<h4 class="text-white"><?= $movie['name'] ?></h4>
									<h6 class="font_14 mb-0 text-white">
										<!-- movieLink -->
										
										<a class="text-white me-1 font_60 align-middle lh-1" href="common/movie_middleware.php?type=movie&id=<?= $movie['id'] ?>"><i
												class="fa fa-play-circle"></i></a>Warch Now
									</h6>
								</div>
							</div>
						</div>
						<?php
					}

				}
				?>




			</div>
		</div>
	</section>

	<!-- Trending Now -->
	<section id="stream" class="p_3">
		<div class="container-xl">
			<div class="row stream_1">
				<div class="col-md-12">
					<h1 class="mb-0">Trending Now</h1>
					<h6 class="col_red d-flex justify-content-end m-auto">
						<a href="category.php?category=Trending">See More</a>
					</h6>
				</div>
			</div>
			<div class="row stream_2 mt-4">
				<?php
				// Fetch trending movies uploaded in last 7 days, sorted by watch_time
				$sql = "SELECT * FROM movie 
                    WHERE upload_from >= DATE_SUB(NOW(), INTERVAL 7 DAY)  and NOW() > upload_from AND movie_status=1
                    ORDER BY watch_time DESC 
                    LIMIT 4";
				$stmt = $pdo->query($sql);
				$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

				foreach ($movies as $movie) {
					?>
					<div class="col-md-3 pe-0">
						<div class="stream_2im clearfix position-relative">
							<div class="stream_2im1 clearfix">
								<div class="grid clearfix">
									<figure class="effect-jazz mb-0">
										<a href="common/movie_middleware.php?type=movie&id=<?= $movie['id'] ?>">
											<img src="../uploads/movies/<?= $movie['id'] ?>/photos/<?= $movie['poster'] ?>"
												class="w-100" alt="<?= htmlspecialchars($movie['name']) ?>">
										</a>
									</figure>
								</div>
							</div>
							<div class="stream_2im2 position-absolute w-100 h-100 p-3 top-0 clearfix">
								<h6 class="font_14 col_red"><?= htmlspecialchars($movie['tags']) ?></h6>
								<h4 class="text-white"><?= htmlspecialchars($movie['name']) ?></h4>
								<h6 class="font_14 mb-0 text-white">
									<a class="text-white me-1 font_60 align-middle lh-1" href="common/movie_middleware.php?type=movie&id=<?= $movie['id'] ?>"><i
											class="fa fa-play-circle"></i></a>Watch Now
								</h6>
							</div>
						</div>
					</div>

					<?php
				}
				?>
			</div>
		</div>
	</section>


	<!-- All time Block blustter -->
	<section id="stream-best" class="p_3">
		<div class="container-xl">
			<div class="row stream_1">
				<div class="col-md-12">
					<h1 class="mb-0">All time Block blustter</h1>
					<h6 class="col_red d-flex justify-content-end m-auto">
						<a href="category.php?category=AllTimeBest">See More</a>
					</h6>
				</div>
			</div>
			<div class="row stream_2 mt-4">
				<?php
				// Fetch top 4 most viewed movies of all time
				$sql = "SELECT * FROM movie where  NOW() > upload_from AND movie_status=1 ORDER BY watch_time DESC LIMIT 4";
				$stmt = $pdo->query($sql);
				$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

				foreach ($movies as $movie) {
					?>
					<div class="col-md-3 pe-0">
						<div class="stream_2im clearfix position-relative">
							<div class="stream_2im1 clearfix">
								<div class="grid clearfix">
									<figure class="effect-jazz mb-0">
										<a href="common/movie_middleware.php?type=movie&id=<?= $movie['id'] ?>">
											<img src="../uploads/movies/<?= $movie['id'] ?>/photos/<?= $movie['poster'] ?>"
												class="w-100" alt="<?= htmlspecialchars($movie['name']) ?>">
										</a>
									</figure>
								</div>
							</div>
							<div class="stream_2im2 position-absolute w-100 h-100 p-3 top-0 clearfix">
								<h6 class="font_14 col_red"><?= htmlspecialchars($movie['tags']) ?></h6>
								<h4 class="text-white"><?= htmlspecialchars($movie['name']) ?></h4>
								<h6 class="font_14 mb-0 text-white">
									<a class="text-white me-1 font_60 align-middle lh-1" href="common/movie_middleware.php?type=movie&id=<?= $movie['id'] ?>"><i
											class="fa fa-play-circle"></i></a>Watch Now
								</h6>
							</div>
						</div>
					</div>
					<?php
				}
				?>
			</div>
		</div>
	</section>

	<!-- History -->
	<?php
	if (isset($_SESSION['user'])) {
		?>
		<section id="stream-history" class="p_3">
			<div class="container-xl">
				<div class="row stream_1">
					<div class="col-md-12">
						<h1 class="mb-0">Watch History</h1>
						<h6 class="col_red d-flex justify-content-end m-auto">
							<a href="category.php?category=History">See More</a>
						</h6>
					</div>
				</div>
				<div class="row stream_2 mt-4">
					<?php
					$userId = $_SESSION['user']['id'];

					$sql = "SELECT movie.* 
                    FROM watch_history 
                    INNER JOIN movie ON watch_history.movie_id = movie.id 
                    WHERE watch_history.user_id = ? and  NOW() > upload_from AND movie_status=1
                    ORDER BY watch_history.id DESC 
                    LIMIT 4";

					$stmt = $pdo->prepare($sql);
					$stmt->execute([$userId]);
					$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

					foreach ($movies as $movie) {
						?>
						<div class="col-md-3 pe-0">
							<div class="stream_2im clearfix position-relative">
								<div class="stream_2im1 clearfix">
									<div class="grid clearfix">
										<figure class="effect-jazz mb-0">
											<a href="common/movie_middleware.php?type=movie&id=<?= $movie['id'] ?>">
												<img src="../uploads/movies/<?= $movie['id'] ?>/photos/<?= $movie['poster'] ?>"
													class="w-100" alt="<?= htmlspecialchars($movie['name']) ?>">
											</a>
										</figure>
									</div>
								</div>
								<div class="stream_2im2 position-absolute w-100 h-100 p-3 top-0 clearfix">
									<h6 class="font_14 col_red"><?= htmlspecialchars($movie['tags']) ?></h6>
									<h4 class="text-white"><?= htmlspecialchars($movie['name']) ?></h4>
									<h6 class="font_14 mb-0 text-white">
										<a class="text-white me-1 font_60 align-middle lh-1" href="common/movie_middleware.php?type=movie&id=<?= $movie['id'] ?>"><i
												class="fa fa-play-circle"></i></a>Watch Again
									</h6>
								</div>
							</div>
						</div>
						<?php
					} ?>
				</div>
			</div>
		</section>
		<?php
	}
	?>



	<section id="coming_soon" class="p_3">
		<div class="container-xl">
			<div class="row stream_1">
				<div class="col-md-12">
					<h1 class="mb-0">Coming Soon</h1>
					<h6 class="col_red d-flex justify-content-end m-auto">
						<a href="category.php?category=ComingSoon"> See More</a>
					</h6>
				</div>
			</div>
			<div class="row stream_2 mt-4">
				<?php

				$stmt = $pdo->prepare("SELECT * FROM movie WHERE   upload_from > NOW() and movie_status = '1' limit 4 ");
				$stmt->execute();
				$comingMovies = $stmt->fetchAll(PDO::FETCH_ASSOC);

				foreach ($comingMovies as $movie): ?>
					<div class="col-md-3 pe-0">
						<div class="stream_2im clearfix position-relative">
							<div class="stream_2im1 clearfix">
								<div class="grid clearfix">
									<figure class="effect-jazz mb-0">
										<a href="#">
											<img src="../uploads/movies/<?= $movie['id'] ?>/photos/<?= $movie['poster'] ?>"
												class="w-100" alt="coming-soon">
										</a>
									</figure>
								</div>
							</div>
							<div class="stream_2im2 position-absolute w-100 h-100 p-3 top-0 clearfix">
								<h6 class="font_14 col_red"><?= $movie['tags'] ?></h6>
								<h4 class="text-white"><?= $movie['name'] ?></h4>
								<h6 class="font_14 mb-0 text-white">
									<a class="text-white me-1 font_60 align-middle lh-1" href="#">
										<i class="fa fa-clock"></i>
									</a>
									Coming <?= date('M d, Y', strtotime($movie['upload_from'])) ?>
								</h6>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php
	?>


	<section id="price">
		<div class="price_m clearfix pt-5 pb-5 bg_image">
			<div class="container-xl">
				<div class="row stream_1 text-center">
					<div class="col-md-12">
						<h6 class="text-uppercase col_red">START SECURE BROWSING</h6>
						<h1 class="mb-0 font_50 text-white">Ready to Grab the deal?</h1>
					</div>
				</div>
				<div class="row price_1 mt-4">
					<div class="col-md-4">
						<div class="price_1i bg-white p-4 text-center">
							<span class="font_60 col_red lh-1"><i class="fa fa-youtube-play"></i></span>
							<h5>1-month plan</h5>
							<h1 class="font_50 lh-1 mt-3">$8.99</h1>
							<h6 class="fw-normal">Per month</h6>
							<h6 class="text-uppercase mt-3"><a class="button_1 d-block" href="#"> Get The Deal</a></h6>
							<p class="mb-0 mt-3"><i class="fa fa-lock me-1 col_green"></i> 45-days money-back guarantee
							</p>
						</div>
					</div>
					<div class="col-md-4">
						<div class="price_1i bg-white p-4 text-center">
							<span class="font_60 col_red lh-1"><i class="fa fa-youtube-play"></i></span>
							<h5>12-month plan</h5>
							<h1 class="font_50 lh-1 mt-3">$4.99</h1>
							<h6 class="fw-normal">Per month</h6>
							<h5 class="save d-inline-block col_red fs-6 mt-2">Save 63%</h5>
							<p class="mt-2 fs-6"><span class="text-decoration-line-through text-muted">$236.80</span>
								<span class="fw-bold">$83.00</span> for the first 2 years
							</p>
							<h6 class="text-uppercase mt-3"><a class="button_1 d-block" href="#"> Get The Deal</a></h6>
							<p class="mb-0 mt-3"><i class="fa fa-lock me-1 col_green"></i> 45-days money-back guarantee
							</p>
						</div>
					</div>
					<div class="col-md-4">
						<div class="price_1i bg-white p-4 text-center">
							<span class="font_60 col_red lh-1"><i class="fa fa-youtube-play"></i></span>
							<h5>6-month plan</h5>
							<h1 class="font_50 lh-1 mt-3">$6.99</h1>
							<h6 class="fw-normal">per month</h6>
							<h6 class="text-uppercase mt-3"><a class="button_1 d-block" href="#"> Get The Deal</a></h6>
							<p class="mb-0 mt-3"><i class="fa fa-lock me-1 col_green"></i> 45-days money-back guarantee
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>


	<?php

	//check for the user log in first time and chouse for catefory
	if (isset($_SESSION['user'])) {
		if (($_SESSION['user']['is_first_login'] == 1)) {
			?>


			<!-- modal for select multiple categories -->
			<div class="modal-overlay" id="modal">
				<div class="modal-content" id="modalContent">
					<h2>🎬 Select Movie Genres</h2>

					<div class="category-wrapper">
						<div class="category-grid">
							<?php
							$iconMappings = [
								'action' => 'fa-explosion',
								'romantic' => 'fa-heart',
								'drama' => 'fa-masks-theater',
								'adventure' => 'fa-person-hiking',
								'comedy' => 'fa-face-laugh',
								'horror' => 'fa-ghost',
								'sci-fi' => 'fa-robot',
								'thriller' => 'fa-user-secret',
								'fantasy' => 'fa-dragon',
								'mystery' => 'fa-question',
								'documentary' => 'fa-camera',
								'biography' => 'fa-book-open',
								'historical' => 'fa-landmark',
								'war' => 'fa-helmet-battle',
								'musical' => 'fa-music',
								'western' => 'fa-hat-cowboy',
								'crime' => 'fa-handcuffs',
								'superhero' => 'fa-shield-halved',
								'family' => 'fa-house-chimney',
								'animation' => 'fa-film',
								'romantic comedy' => 'fa-heart-circle-check',
								'psychological thriller' => 'fa-brain',
								'noir' => 'fa-moon',
								'suspense' => 'fa-clock',
								'sports' => 'fa-futbol',
								'paranormal' => 'fa-ghost',
								'experimental' => 'fa-flask',
								'dark comedy' => 'fa-face-meh',
								'coming of age' => 'fa-graduation-cap',
								'tragedy' => 'fa-face-sad-tear',
								'satire' => 'fa-comment-exclamation'
							];

							$query = "SELECT * FROM tag";
							$stmt = $pdo->prepare($query);
							$stmt->execute();
							$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

							foreach ($result as $row) {
								$name = strtolower($row['name']);
								$iconClass = $iconMappings[$name] ?? 'fa-circle-question'; // fallback icon
								?>
								<label class="category-card">
									<input type="checkbox" name="category" value="<?= $name ?>">
									<span class="check-icon"><i class="fas fa-check"></i></span>
									<i class="fas <?= $iconClass ?> category-icon"></i>
									<?= htmlspecialchars($row['name']) ?>
								</label>
								<?php
							}
							?>
						</div>
					</div>

					<div class="modal-footer">
						<button class="btn btn-secondary" onclick="closeModal()">Cancel</button>
						<button class="btn btn-primary" onclick="saveSelection()">Save Choices</button>
					</div>
				</div>
			</div>

			<!-- script for modal -->
			<script>
				let selected;
				//open model for select multiple movie cataegory for first time log in
				function openModal() {
					const modal = document.getElementById('modal');
					const modalContent = document.getElementById('modalContent');
					modal.style.display = 'flex';
					setTimeout(() => modalContent.classList.add('active'), 10);
				}

				function closeModal() {
					const modal = document.getElementById('modal');
					const modalContent = document.getElementById('modalContent');
					modalContent.classList.remove('active');
					setTimeout(() => modal.style.display = 'none', 300);
				}

				document.querySelectorAll('.category-card input').forEach(checkbox => {
					checkbox.addEventListener('change', () => {
						const card = checkbox.closest('.category-card');
						card.classList.toggle('checked', checkbox.checked);
					});
				});

				document.getElementById('modal').addEventListener('click', (e) => {
					if (e.target === document.getElementById('modal')) {
						closeModal();
					}
				});

				function saveSelection() {
					const selected = Array.from(document.querySelectorAll('input[name="category"]:checked'))
						.map(checkbox => checkbox.value);
					console.log('Selected categories:', selected);
					setUserPreference(<?= $_SESSION['user']['id'] ?>);
					closeModal();
				}

				function setUserPreference(userId) {
					const selected = Array.from(document.querySelectorAll('input[name="category"]:checked'))
						.map(checkbox => checkbox.value);

					const formData = new FormData();
					formData.append("user_id", userId);
					formData.append("preference", selected.join(",")); // You can use JSON.stringify(selected) if you want to save it as JSON

					fetch("proccess/setUserPreference.php", {
						method: "POST",
						body: formData
					})
						.catch(error => {
							console.error("Error:", error);
						});
				}
			</script>

			<!-- open the modal -->
			<script>openModal();</script>

			<?php

			$update = "UPDATE user SET is_first_login = 0 WHERE id = :id";
			$stmt2 = $pdo->prepare($update);
			$stmt2->bindParam(':id', $_SESSION['user']['id'], PDO::PARAM_INT);


			$stmt2->execute();
			$_SESSION['user']['is_first_login'] = 0;

		}
	}
	?>

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