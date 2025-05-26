<?php
session_start();
if (!isset($_SESSION['admin_data'])) {
    header("location:../login_module/index.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>CineVision | Dashboard</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">


    <?php
    // including css
    include("../common/css/style.html");
    ?>
    <style>
        /* Dashboard Content Styles */
        .dashboard-content {
            padding: 25px;
            color: #fff;
            min-height: calc(100vh - 120px);
            /* Adjust based on your header/footer height */
        }

        .page-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: #fff;
        }

        .admin-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .admin-name {
            font-weight: 500;
        }

        .admin-badge {
            background-color: #e94560;
            color: white;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        /* Stat Cards */
        .stat-card {
            padding: 20px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .bg-dark-red {
            background: linear-gradient(135deg, #e94560, #b32b45);
        }

        .bg-dark-blue {
            background: linear-gradient(135deg, #0f3460, #08203e);
        }

        .bg-dark-purple {
            background: linear-gradient(135deg, #533d8b, #3a2a6d);
        }

        .bg-dark-green {
            background: linear-gradient(135deg, #2d9b78, #1e6f5c);
        }

        .stat-icon {
            font-size: 1.8rem;
            opacity: 0.8;
        }

        .stat-info h3 {
            font-size: 1.5rem;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .stat-info p {
            margin: 0;
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .stat-trend {
            font-size: 0.9rem;
            font-weight: 500;
        }

        .stat-trend.up {
            color: #4ade80;
        }

        .stat-trend.down {
            color: #f87171;
        }

        /* Dashboard Cards */
        .dashboard-card {
            background-color: #16213e;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .card-header {
            padding: 15px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header h3 {
            font-size: 1.2rem;
            margin: 0;
            font-weight: 500;
        }

        .btn-view-all {
            color: #e94560;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .card-body {
            padding: 20px;
        }

        /* Table Styles */
        .table {
            color: #fff;
            margin-bottom: 0;
        }

        .table th {
            border-top: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            font-weight: 500;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table td {
            vertical-align: middle;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .movie-poster {
            width: 50px;
            height: 75px;
            object-fit: cover;
            border-radius: 4px;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .status-badge.active {
            background-color: rgba(74, 222, 128, 0.2);
            color: #4ade80;
        }

        .status-badge.pending {
            background-color: rgba(251, 191, 36, 0.2);
            color: #fbbf24;
        }

        .btn-action {
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.6);
            padding: 5px;
            margin: 0 3px;
            cursor: pointer;
            transition: color 0.2s;
        }

        .btn-action:hover {
            color: #fff;
        }

        .btn-action.edit:hover {
            color: #3b82f6;
        }

        .btn-action.delete:hover {
            color: #ef4444;
        }

        /* Quick Actions */
        .quick-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .quick-action {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            text-decoration: none;
            color: #fff;
            transition: transform 0.2s;
        }

        .quick-action:hover {
            transform: translateY(-3px);
            color: #fff;
        }

        .action-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 8px;
            font-size: 1.2rem;
        }

        .bg-red {
            background-color: #e94560;
        }

        .bg-blue {
            background-color: #3b82f6;
        }

        .bg-purple {
            background-color: #8b5cf6;
        }

        .bg-green {
            background-color: #10b981;
        }

        /* User List */
        .user-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .user-item {
            display: flex;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 12px;
        }

        .user-info h5 {
            font-size: 0.95rem;
            margin: 0;
            font-weight: 500;
        }

        .user-info p {
            font-size: 0.8rem;
            margin: 0;
            opacity: 0.7;
        }

        .user-time {
            margin-left: auto;
            font-size: 0.8rem;
            opacity: 0.6;
        }
    </style>
</head>

<body onload="loadBody()">
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner"
            class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Sidebar Start -->
        <?php
        // including sidebar
        include("../common/sidebar.php");
        ?>

        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class="content" id="content">
            <!-- Navbar Start -->
            <?php
            // including header
            include("../common/header.php");
            ?>
            <!-- Navbar End -->

            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary rounded-top p-4">
                    <div class="dashboard-content">
                        <!-- Page Header -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2 class="page-title">Dashboard Overview</h2>
                            <div class="admin-info">
                                <span class="admin-name"><?= $_SESSION['admin_data']['name'] ?></span>
                                <span class="admin-badge">Admin</span>
                            </div>
                        </div>

                        <!-- Stats Cards -->
                        <?php
                        include('../../common/connection/connection.php');
                        $seletcMovieCount = "SELECT id FROM movie WHERE movie_status = 1";
                        $stmt = $pdo->prepare($seletcMovieCount);
                        $stmt->execute();
                        $MovieData = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        ?>
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="stat-card bg-dark-red">
                                    <div class="stat-icon">
                                        <i class="fas fa-film"></i>
                                    </div>
                                    <div class="stat-info">
                                        <h3><?php echo count($MovieData) ?></h3>
                                        <p>Total Movies</p>
                                    </div>
                                    <div class="stat-trend up">

                                    </div>
                                </div>
                            </div>
                            <?php
                            $seletcPremiumMovieCount = "SELECT id FROM movie WHERE isFree = 0";
                            $stmtPremium = $pdo->prepare($seletcPremiumMovieCount);
                            $stmtPremium->execute();
                            $PremiumMovieData = $stmtPremium->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <div class="col-md-3">
                                <div class="stat-card bg-dark-blue">
                                    <div class="stat-icon">
                                        <i class="fas fa-coins"></i>
                                    </div>
                                    <div class="stat-info">
                                        <h3><?= count($PremiumMovieData) ?></h3>
                                        <p>Premium Movies</p>
                                    </div>
                                    <div class="stat-trend up">
                                    </div>
                                </div>
                            </div>

                            <?php
                            $seletcUpcomingMovieCount = "SELECT id FROM movie WHERE movie_status = 1 AND upload_from > NOW()";
                            $stmtUpcomingCount = $pdo->prepare($seletcUpcomingMovieCount);
                            $stmtUpcomingCount->execute();
                            $MovieDataUpcomingCount = $stmtUpcomingCount->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <div class="col-md-3">
                                <div class="stat-card bg-dark-purple">
                                    <div class="stat-icon">
                                        <i class="fas fa-hourglass-start"></i>
                                    </div>
                                    <div class="stat-info">
                                        <h3><?= count($MovieDataUpcomingCount) ?></h3>
                                        <p>Upcoming movies</p>
                                    </div>
                                    <div class="stat-trend down">
                                    </div>
                                </div>
                            </div>

                            <?php
                            $seletcReleaseMovieCount = "SELECT id FROM movie WHERE movie_status = 1 AND upload_from < NOW()";
                            $stmtReleaseCount = $pdo->prepare($seletcReleaseMovieCount);
                            $stmtReleaseCount->execute();
                            $MovieDataReleaseCount = $stmtReleaseCount->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <div class="col-md-3">
                                <div class="stat-card bg-dark-green">
                                    <div class="stat-icon">
                                        <i class="fas fa-video"></i>
                                    </div>
                                    <div class="stat-info">
                                        <h3><?= count($MovieDataReleaseCount) ?></h3>
                                        <p>Released movie</p>
                                    </div>
                                    <div class="stat-trend up">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Activity and Quick Actions -->
                        <div class="row">
                            <!-- Recent Movies Added -->
                            <div class="col-md-8">
                                <div class="dashboard-card">
                                    <div class="card-header">
                                        <h3>Recently Added Movies</h3>
                                        <a href="#" class="btn-view-all">View All</a>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Poster</th>
                                                        <th>Title</th>
                                                        <th>Genre</th>
                                                        <th>Time Duration</th>
                                                        <th>Edit</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $movieList = "SELECT id,name,poster,tags,duration_minute FROM movie WHERE movie_status=1 ORDER BY id DESC LIMIT 5";
                                                    $stmt_movie_list = $pdo->query($movieList);
                                                    $result_movies = $stmt_movie_list->fetchAll(PDO::FETCH_ASSOC);
                                                    // print_r($result_movies);
                                                    foreach ($result_movies as $MovieData) {
                                                        ?>
                                                        <tr>
                                                            <td><img src="../../uploads/movies/<?php echo $MovieData['id'] ?>/photos/<?php echo $MovieData['poster'] ?>"
                                                                    alt="Movie Poster" class="movie-poster"></td>
                                                            <td><?= $MovieData['name'] ?></td>
                                                            <td><?= $MovieData['tags'] ?></td>
                                                            <td><?= $MovieData['duration_minute'] ?></td>
                                                            <td>
                                                                <a href="step1.php?movieId=<?php echo $MovieData['id'] ?>">
                                                                    <button class="btn-action edit">
                                                                        <i class="fas fa-edit"></i>
                                                                    </button>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Actions -->
                            <div class="col-md-4">
                                <div class="dashboard-card">
                                    <div class="card-header">
                                        <h3>Quick Actions</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="quick-actions">
                                            <a href="add_movie.php" class="quick-action">
                                                <div class="action-icon bg-red">
                                                    <i class="fas fa-plus"></i>
                                                </div>
                                                <span>Add New Movie</span>
                                            </a>
                                            <a href="pending_movie.php" class="quick-action">
                                                <div class="action-icon bg-blue">
                                                    <i class="fas fa-hourglass-start"></i>
                                                </div>
                                                <span>Draf Movies</span>
                                            </a>
                                            <a href="uploaded_movie.php" class="quick-action">
                                                <div class="action-icon bg-purple">
                                                    <i class="fas fa-cloud-upload-alt"></i>
                                                </div>
                                                <span>Released movie</span>
                                            </a>
                                            <a href="#" class="quick-action">
                                                <div class="action-icon bg-green">
                                                    <i class="fas fa-users"></i>
                                                </div>
                                                <span>Add people(casts)</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Recent Users -->
                                <?php
                                $selectUsers = "SELECT * FROM user ORDER BY id DESC LIMIT 3";
                                $stmt_users = $pdo->query($selectUsers);
                                $result_users = $stmt_users->fetchAll(PDO::FETCH_ASSOC);
                                ?>
                                <div class="dashboard-card mt-4">
                                    <div class="card-header">
                                        <h3>3 Recent Users</h3>
                                    </div>
                                    <?php
                                    foreach ($result_users as $user) {
                                        ?>
                                        <div class="card-body">
                                            <div class="user-list">
                                                <div class="user-item">
                                                    <div class="action-icon bg-red m-2">
                                                        <i class="fas fa-user"></i>
                                                    </div>
                                                    <div class="user-info">
                                                        <h5><?= $user['name'] ?></h5>
                                                        <p><?= $user['email'] ?></p>
                                                    </div>
                                                    <?php
                                                    $timestamp = strtotime($user['created_at']);
                                                    ?>
                                                    <span
                                                        class="user-time m-2"><?= date("d M Y, h:i A", $timestamp) ?></span>
                                                </div>

                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Footer Start -->
            <?php
            // including css
            include("../common/footer.php");
            ?>
            <!-- Footer End -->
        </div>
        <!-- Content End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <?php
    // including css
    include("../common/js/script.html");
    ?>
</body>
<script>
    function loadBody() {
        const sidebar_title = document.getElementById('dashboard');
        acivateSideBar(sidebar_title);
    }
</script>

</html>