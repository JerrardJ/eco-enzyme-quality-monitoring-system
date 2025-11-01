<?php 
    include("app/controllers/users.php"); 
    
    if(empty($_SESSION['username'])){
        header('location: login.php');
    }
    if(!empty($_SESSION['username'])){
        $usernames = $_SESSION['username'];
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css?family=Candal|Lora" rel="stylesheet">

    <!-- Icons Installation -->
    <script src="https://kit.fontawesome.com/8bab192097.js" crossorigin="anonymous"></script>
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="asset/css/styles2.css?v=1.6" type ="text/css">

    <!-- Admin CSS -->
    <link rel="stylesheet" href="asset\css\admin.css?v=2.7">

    <title>Admin Panel - Edit Account</title>
</head>

<body>
<?php include("app/include/adminHeader.php"); ?>
    <!-- EDIT USER START -->
    <div class="admin-wrapper">
        <div class="admin-content">

            <!-- BUTTON GROUP START -->
            <div class="button-group">
                <a href="createUser.php" class="btn btn-big">Add Account</a>
                <a href="indexUser.php" class="btn btn-big">Manage Account</a>
            </div>
            <!-- BUTTON GROUP END -->


            <!-- EDIT USER CONTENT START -->
            <div class="content">
                <h2 class="page-title">Edit Account</h2>

                <!-- DISPLAY ERROR ONLY START -->
                <?php include("app/helpers/warn.php"); ?>
                <!-- DISPLAY ERROR ONLY END -->

                <!-- FORM EDIT USER START -->
                <form action="editUser.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div>
                        <label>Username</label><br>
                        <input type="text" name="username" readonly value="<?php echo $username; ?>" class="text-input">
                    </div>
                    <div>
                         <label>Password</label><br>
                        <input type="text" name="password" value="<?php echo $password; ?>" class="text-input">
                    </div>
                    <div>
                        <label>Re-enter Password</label><br>
                        <input type="text" name="passwordConf" value="<?php echo $passwordConf; ?>" class="text-input">
                    </div>
                    <div>
                        <?php if(isset($admin) && $admin == 1): ?>
                            <label><br>
                                <input type="checkbox" name="admin" checked>
                                Admin
                            </label><br>
                        <?php else: ?>
                            <label><br>
                                <input type="checkbox" name="admin">
                                Admin
                            </label><br>
                        <?php endif; ?>
                    </div>
                    <div>
                        <button type="submit" name="update-user" class="btn btn-big">Submit</button>
                    </div>
                </form>
                <!-- FORM EDIT USER END -->
            </div>
            <!-- EDIT USER CONTENT END -->
        </div>
    </div>
    <!-- EDIT USER END -->

    <!-- Custom JS -->
    <script src="asset\js\scripts.js"></script>
</body>

</html>