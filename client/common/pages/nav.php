<div class="main_1 clearfix position-absolute top-0 w-100">
    <section id="header">
        <nav class="navbar navbar-expand-md navbar-light <?= isset($bg) ? 'bg-dark' : '' ?> " id="navbar_sticky">
            <div class="container-xl">
                <a class="navbar-brand fs-2 p-0 fw-bold text-white m-0 me-5" href="index.php"><i
                        class="fa fa-youtube-play me-1 col_red"></i> Cinevision </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mb-0">

                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="about.php">About </a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                GENREs
                            </a>
                            <ul class="dropdown-menu drop_1" aria-labelledby="navbarDropdown"
                                style="max-height: 400px; overflow-y: auto;">
                                <?php

                                $query = "SELECT * from tag";
                                $stmt = $pdo->prepare($query);
                                $stmt->execute();
                                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($result as $row) {
                                    ?>
                                    <li><a class="dropdown-item" href="category.php?genres=<?= $row['id'] ?>">
                                            <?= $row['name'] ?></a></li>
                                    <?php
                                }
                                ?>
                        </li>
                    </ul>
                    </li>

                    </ul>
                    <ul class="navbar-nav mb-0 ms-auto">
                        <li class="nav-item dropdown">

                            <ul class="dropdown-menu drop_1 drop_o p-3" aria-labelledby="navbarDropdown"
                                data-bs-popper="none">
                                <li>
                                    <div class="input-group p-2">
                                        <input type="text" class="form-control border-0" placeholder="Search Here">
                                        <span class="input-group-btn">
                                            <button class="btn btn-primary bg-transparent border-0 fs-5" type="button">
                                                <i class="fa fa-search col_red"></i> </button>
                                        </span>
                                    </div>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="account.php"><i
                                    class="fa fa-user fs-4 align-middle me-1 lh-1 col_red"></i> Account </a>
                        </li>
                        <?php
                        if (isset($_SESSION['user'])) {
                            ?>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php"><i
                                        class="fa fa-out fs-4 align-middle me-1 lh-1 col_red"></i> Log out </a>
                            </li>
                            <?php
                        }
                        ?>

                    </ul>
                </div>
            </div>
        </nav>
    </section>
</div>