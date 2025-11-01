<?php include("app/controllers/users.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css?family=Candal|Lora" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Icons Installation -->
    <script src="https://kit.fontawesome.com/8bab192097.js" crossorigin="anonymous"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="asset/css/styles.css?v=1.9" type ="text/css">
    <link rel="stylesheet" href="asset/css/styles2.css?v=2.4" type ="text/css">



    <title>Login</title>
</head>

<body>
    <?php include("app/include/header.php"); ?>

    <!-- LOGIN PAGE CONTENT START -->
    <div class="auth-content">

        <!-- FORM LOGIN PAGE START -->
        <form action="login.php" method="post">
            <h2 class="form-title">Login Page</h2>

            <!-- DISPLAY ERROR ONLY START -->
            <?php include("app/helpers/warn.php"); ?>
            <!-- DISPLAY ERROR ONLY ERROR -->

            <div>
                <label for="signin" class="form-label">Username</label><br>
                <input type="text" name="username" value="<?php echo $username; ?>" id="signin" class="text-input form-control">
            </div>
            <div>
                <label for="sandi" class="form-label">Password</label><br>
                <input type="password" name="password" value="<?php echo $password; ?>"  id="sandi" class="text-input form-control">
            </div>
            <div>
                <button type="submit" name="login-btn" class="btn btn-big btn btn-primary mt-3">Login</button>
            </div>
            <!-- <p>Dont have an account? <a style="text-decoration:none; color:blue;" href="register.php"><b>Sign Up</b></a></p> -->
        </form>
        <!-- FORM LOGIN PAGE END -->
    </div>
    <!-- LOGIN PAGE CONTENT END -->

    <!-- Custom JS -->
    <script src="asset\js\scripts.js"></script>
    <script src="asset/js/scripts2.js"></script>

</body>

</html>