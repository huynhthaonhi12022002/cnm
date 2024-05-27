<div class="header">
    <!-- Logo -->
    <div class="header-left">
        <a href="index.php" class="logo">
            <img src="../assets/img/logo.png" width="40" height="40" alt="">
        </a>
    </div>
    <!-- /Logo -->

    <a id="toggle_btn" href="javascript:void(0);">
        <span class="bar-icon">
            <span></span>
            <span></span>
            <span></span>
        </span>
    </a>

    <!-- Header Title -->
    <div class="page-title-box">
        <h3>Dreamguy's Technologies</h3>
    </div>
    <!-- /Header Title -->

    <a id="mobile_btn" class="mobile_btn" href="#sidebar"><i class="fa fa-bars"></i></a>

    <!-- Header Menu -->
    <ul class="nav user-menu">

        <!-- Search -->
        <li class="nav-item">
            <div class="top-nav-search">
                <a href="javascript:void(0);" class="responsive-search">
                    <i class="fa fa-search"></i>
                </a>
                <form action="search.php">
                    <input class="form-control" type="text" placeholder="Search here">
                    <button class="btn" type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>
        </li>
        <!-- /Search -->



        <!-- Notifications -->
        
        <!-- /Notifications -->

        <!-- Message Notifications -->
        
        <!-- /Message Notifications -->

        <?php 
	 $sql = "SELECT * FROM users WHERE id = :id";
	 $query = $dbh->prepare($sql);
	 $query->bindParam(':id', $_SESSION["user_id"]);
	 $query->execute();
	 $result = $query->fetch(PDO::FETCH_ASSOC);
		?>
        <li class="nav-item dropdown has-arrow main-drop">
            <a href="#"  class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <span class="user-img"> <span class="user-img">
                        <?php if (substr($result["avatar"], 0, 5) === 'https'): ?>
                        <img src="<?php echo htmlentities($result["avatar"]); ?>" alt="Avatar">
                        <?php else: ?>
                        <img src="../upload/users/<?php echo htmlentities($result["avatar"]); ?>" alt="Avatar">
                        <?php endif; ?>
                        <span class="status online"></span></span>
            </a>
            <div class="dropdown-menu " data-popper-placement="bottom-end"
                style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate3d(-0.833333px, 61.6667px, 0px);">
                <a class="dropdown-item" href="profile.php">My Profile</a>
                <a class="dropdown-item" href="../logout.php">Logout</a>
                <!-- <a class="dropdown-item" href="#"><?=$_SESSION["user_role"]?> and <?=$_SESSION["user_id"]?> and <?=$_SESSION['employee_id']?></a> -->
            </div>
        </li>

    </ul>
    <!-- /Header Menu -->

    <!-- Mobile Menu -->
    <div class="dropdown mobile-user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i
                class="fa fa-ellipsis-v"></i></a>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="profile.php">My Profile</a>
            <a class="dropdown-item" href="../logout.php">Logout</a>
        </div>
    </div>
    <!-- /Mobile Menu -->

</div>