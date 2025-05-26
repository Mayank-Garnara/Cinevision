<?php
session_start();
include("../common/connection/connection.php"); // connect PDO here

$erroMessage='';
$category = $_GET['category'] ?? '';
$genreId = $_GET['genres'] ?? null;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$limit = 8;
$offset = ($page - 1) * $limit;

$movies = [];
$total = 0;

if ($category == 'Suggest') {
    $where = "1";
    $tags = [];
    if (!empty($_SESSION['user']['preference'])) {
        $tags = explode(',', $_SESSION['user']['preference']);
        $conditions = [];
        foreach ($tags as $tag) {
            $conditions[] = "tags LIKE ?";
        }
        $where = implode(" OR ", $conditions);
    }

    $sql = "SELECT * FROM movie WHERE $where and  NOW() > upload_from AND movie_status=1 LIMIT $limit OFFSET $offset";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array_map(fn($t) => "%" . trim($t) . "%", $tags));
    $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $countStmt = $pdo->prepare("SELECT COUNT(*) FROM movie WHERE $where");
    $countStmt->execute(array_map(fn($t) => "%" . trim($t) . "%", $tags));
    $total = $countStmt->fetchColumn();

} elseif ($category == 'AllTimeBest') {
    $sql = "SELECT * FROM movie where  NOW() > upload_from AND movie_status=1 ORDER BY watch_time DESC LIMIT $limit OFFSET $offset";
    $stmt = $pdo->query($sql);
    $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $total = $pdo->query("SELECT COUNT(*) FROM movie")->fetchColumn();

} elseif ($category == 'Trending') {
    $sql = "SELECT * FROM movie where  NOW() > upload_from AND movie_status=1 ORDER BY id DESC LIMIT $limit OFFSET $offset";
    $stmt = $pdo->query($sql);
    $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $total = $pdo->query("SELECT COUNT(*) FROM movie")->fetchColumn();

} elseif ($category == 'ComingSoon') {
    $sql = "SELECT * FROM movie WHERE   upload_from > NOW() and movie_status = '1' ";
    $stmt = $pdo->query($sql);
    $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $total = $pdo->query("SELECT COUNT(*) FROM movie")->fetchColumn();

} elseif ($category == 'History') {
    $sql = "SELECT movie.* FROM watch_history 
            JOIN movie ON movie.id = watch_history.movie_id 
            WHERE watch_history.user_id = ? 
            ORDER BY watch_history.id DESC 
            LIMIT $limit OFFSET $offset";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['user']['id']]);
    $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $countStmt = $pdo->prepare("SELECT COUNT(*) FROM watch_history WHERE user_id = ?");
    $countStmt->execute([$_SESSION['user']['id']]);
    $total = $countStmt->fetchColumn();

} elseif ($genreId) {
    $tagStmt = $pdo->prepare("SELECT name FROM tag WHERE id = ? ");
    $tagStmt->execute([$genreId]);
    $tagName = $tagStmt->fetchColumn();

    if ($tagName) {
        $sql = "SELECT * FROM movie WHERE  tags LIKE ? and  NOW() > upload_from AND movie_status=1 LIMIT $limit OFFSET $offset";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['%' . $tagName . '%']);

        if($stmt->rowCount() <= 0)
        {
            global $erroMessage;
            $erroMessage = 'No movies found in '.$tagName . ' category';
        }
        $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $countStmt = $pdo->prepare("SELECT COUNT(*) FROM movie WHERE tags LIKE ?");
        $countStmt->execute(['%' . $tagName . '%']);
        $total = $countStmt->fetchColumn();
    }
}

$isAjax = isset($_GET['ajax']) && $_GET['ajax'] == '1';

if ($isAjax) {
    ob_start();
}
?>
<?php if (!$isAjax): ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title><?= htmlspecialchars($category) ?> Movies</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Cinevision </title>
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
        <style>
            body {
                background-color:rgb(230, 224, 224);
                color: #fff;
            }

            .movie-card {
                background-color: #1e1e1e;
                border: none;
                border-radius: 12px;
                overflow: hidden;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .movie-card:hover {
                transform: scale(1.03);
                box-shadow: 0 6px 20px rgba(255, 255, 255, 0.15);
            }

            .movie-card img {
                height: 250px;
                object-fit: cover;
                border-top-left-radius: 12px;
                border-top-right-radius: 12px;
            }

            .movie-card .card-body {
                padding: 1rem;
            }

            .movie-card .card-title {
                font-size: 1.2rem;
                margin-bottom: 0.5rem;
                font-weight: bold;
            }

            .movie-card .card-text {
                font-size: 0.85rem;
                color: #ccc;
            }

            .movie-card .btn-danger {
                background-color: #e50914;
                border: none;
            }

            .movie-card .btn-danger:hover {
                background-color: #bf0810;
            }

            .pagination .page-link {
                background-color: #2c2c2c;
                color: #fff;
                border: none;
            }

            .pagination .active .page-link {
                background-color: #e50914;
                color: #fff;
            }
        </style>
    </head>

    <body>
        <?php
        $bg = "black";
        include("common/pages/nav.php");
        ?>

        <?php
            if(strlen( $erroMessage) > 0)
            {
                ?>
                <h1 style="margin-top: 120px; color: #1e1e1e;"><?=$erroMessage?></h1>
                <?php
                exit;
            }
        ?>
        <div class="container py-5" style="margin-top: 80px;">
            <h2 class="mb-4 text-capitalize" style="color: #1e1e1e;">Movies in <?= htmlspecialchars($category) ?> </h2>
            <div id="movie-container">
            <?php endif; ?>
            <div class="row g-4">
                <?php foreach ($movies as $movie): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="card movie-card">
                            <img src="../uploads/movies/<?= $movie['id'] ?>/photos/<?= $movie['poster'] ?>"
                                class="card-img-top" alt="<?= $movie['name'] ?>">
                            <div class="card-body">
                                <h5 class="card-title text-white"><?= $movie['name'] ?></h5>
                                <p class="card-text">Tags: <?= $movie['tags'] ?></p>
                                <?= $category=="ComingSoon" ? '<a href="common/movie_middleware.php?type=trailler&id='.$movie['id'] .'" class="btn btn-danger btn-sm"><i class="fa fa-play"></i> Watch Trailler</a>'
                                 : 
                                 '<a href="common/movie_middleware.php?type=movie&id='.$movie['id'] .'" class="btn btn-danger btn-sm"><i class="fa fa-play"></i> Watch Now</a>' ;
                                    

                                ?>
                      
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php $totalPages = ceil($total / $limit);
            if ($totalPages > 1): ?>
                <nav class="mt-5">
                    <ul class="pagination justify-content-center">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                <a class="page-link pagination-link"
                                    href="?category=<?= urlencode($category) ?>&page=<?= $i ?><?= $genreId !== null ? '&genres=' . urlencode($genreId) : '' ?>">
                                    <?= $i ?> </a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            <?php endif; ?>
            <?php if (!$isAjax): ?>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('.pagination-link').forEach(link => {
                    link.addEventListener('click', function (e) {
                        e.preventDefault();
                        fetch(this.href + '&ajax=1')
                            .then(res => res.text())
                            .then(html => {
                                document.getElementById('movie-container').innerHTML = html;
                            });
                    });
                });
            });
        </script>
    </body>

    </html>
<?php endif; ?>