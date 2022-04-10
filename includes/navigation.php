<!-- Navigation Section -->
<nav class="navbar navbar-expand-md bg-white">
    <p class="navbar-brand">A B2B Store</p>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <i class="fas fa-bars"></i>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="collapsibleNavbar">
        <ul class="navbar-nav">
            <?php
            if ($_SESSION['category'] == "guest") {
                echo "
                    <li class='nav-item'>
                        <a class='nav-link' href='../index.php'>Home</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='../products.php'>Products</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='../login.php'>Login</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='../signup.php'>Register</a>
                    </li>
                ";
            } else if ($_SESSION['category'] == "customer") {
                echo "
                    <li class='nav-item'>
                        <a class='nav-link' href='../index.php'>Home</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='../products.php'>Products</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='../trending.php'>Trending Today</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='../cart.php'>Cart</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='../orders.php'>Orders</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='../profile.php'>Profile</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='../logout.php'>Logout</a>
                    </li>
                ";
            } else if ($_SESSION['category'] == "seller") {
                echo "
                    <li class='nav-item'>
                        <a class='nav-link' href='../index.php'>Home</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='#!'>Dashboard</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='../shop.php?query=Manage'>Shop</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='../profile.php'>Profile</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='../logout.php'>Logout</a>
                    </li>
                ";
            } else if ($_SESSION['category'] == "admin") {
                echo "
                    <li class='nav-item'>
                        <a class='nav-link' href='#!'>Admin</a>
                    </li>
                ";
            } else {
                echo null;
            }
            ?>
        </ul>
    </div>
</nav>