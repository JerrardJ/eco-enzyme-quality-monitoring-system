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
    <link rel="stylesheet" href="asset/css/styles2.css?v=1.4" type ="text/css">

    <!-- Admin CSS -->
    <link rel="stylesheet" href="asset/css/admin.css?v=2.0" type="text/css">

    <title>Admin Panel - Manage Account</title>
</head>

<body>
<?php include("app/include/adminHeader.php"); ?>

    <!-- ADMIN USER PAGE START -->
    <div class="admin-wrapper">
        <div class="admin-content">

            <!-- BUTTON GROUP START -->
            <div class="button-group">
                <a href="createUser.php" class="btn btn-big">Add Account</a>
                <a href="indexUser.php" class="btn btn-big">Manage Account</a>
            </div>
            <!-- BUTTON GROUP END -->

            <!-- ADMIN USER PAGE CONTENT START -->
            <div class="content">
                <h2 class="page-title">Manage Account</h2>
                
                <!-- DISPLAY SUCCESS ONLY START -->
                <?php include("app/include/messages.php"); ?>
                <!-- DISPLAY SUCCESS ONLY END -->

                <!-- TABLE ADMIN USER PAGE START -->
                <table class="mejauser">
                    <thead>
                        <th>No.</th>
                        <th>Username</th>
                        <th colspan="2">Action</th>
                        
                    </thead>
                    <tbody>
                        <!-- LOOP COMMAND FOR ADMIN USER CONTENT START -->
                        <th><br></th>
                        <?php foreach($admin_users as $key => $user): ?>
                        <?php if($key %2 == 0):?>
                            <tr class="tabelwarna">
                        <?php else: ?>
                            <tr>
                        <?php endif;?>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo $user['username']; ?></td>
                                <td><a href="editUser.php?id=<?php echo $user['id']; ?>" class="edit">Edit</a></td>
                                <td><a href="indexUser.php?delete_id=<?php echo $user['id']; ?>" class="delete">Delete</a></td>
                            </tr>
                            
                        <?php endforeach; ?>
                        <!-- LOOP COMMAND FOR ADMIN USER CONTENT END -->
                        <!-- <button class="tomboltop hiddentop" title="Ke atas"><i class="bi bi-arrow-up"></i></button> -->
                    </tbody>
                </table>
                <!-- TABLE ADMIN USER PAGE END -->
            </div>
            <!-- ADMIN USER PAGE CONTENT END -->
        </div>
    </div>
    <!-- ADMIN USER PAGE END -->

    <!-- Custom JS -->
    <script src="asset\js\scripts.js"></script>
    <script src="asset\js\scripts2admin.js"></script>

</body>

</html>