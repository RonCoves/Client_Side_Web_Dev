<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">Rock, Paper and Scissor</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0 ">
            <?php
                if(isset($_SESSION["user_loggedin"])){
            ?>
            <li class="nav-item">
                <a class="nav-link text-success">You: <span id="userPoints"><?php echo points("user"); ?></span></a>
            </li>
            <li class="nav-item px-4 d-none d-md-block">
                <a class="nav-link text-dark">vs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-danger">Computer: <span id="computerPoints"><?php echo points("computer"); ?></span></a>
            </li>
            <?php } ?>
        </ul>
        <div class="d-flex">
            <?php
            if(isset($_SESSION["user_loggedin"])){
            ?>
                <a href="logout.php" class="btn btn-sm btn-danger">Logout</a>
            <?php }else{ ?>
                <a href="#" class="btn btn-sm btn-success" type="button" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
            <?php } ?>
        </div>
        </div>
    </div>
    </nav>
    <?php
    if(isset($error)){
    ?>
    <div class="alert alert-danger alert-dismissible"  role="alert">
    <?php echo $error; ?> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php } ?>
    <?php
    if(isset($msg)){
    ?>
    <div class="alert alert-success alert-dismissible" role="alert">
    <?php echo $msg; ?> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php } ?>

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Login</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="" method="post" id="register" style="display: none">
            <input type="text" class="form-control mb-2" placeholder="First Name" name="first_name" required>
            <input type="text" class="form-control mb-2" placeholder="Last Name" name="last_name" required>
            <input type="text" class="form-control mb-2" placeholder="Username" name="username" required>
            <input type="email" class="form-control mb-2" placeholder="Email" name="email" required>
            <input type="password" class="form-control mb-2" placeholder="Password" name="password" required>
            <input type="password" class="form-control mb-2" placeholder="Confirm Password" name="confirm_password" required>
            <button type="submit" class="btn btn-sm btn-success mb-2" name="register">Register</button>
            <button type="button" class="btn btn-sm btn-primary mb-2" id="loginBtn">Login</button>
            </form>
            <form action="" method="post" id="login">
            <input type="text" class="form-control mb-2" placeholder="Username/Email" name="username" required>
            <input type="password" class="form-control mb-2" placeholder="Password" name="password" required>
            <button type="submit" class="btn btn-sm btn-success mb-2" name="login">Login</button>
            <button type="button" class="btn btn-sm btn-primary mb-2" id="regBtn">Register</button>
            </form>
        </div>
        </div>
    </div>
    </div>