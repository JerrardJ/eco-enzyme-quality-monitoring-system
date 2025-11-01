<?php 
include("app/controllers/posts.php"); 

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
    <link rel="stylesheet" href="asset/css/styles.css?v=1.9" type ="text/css">
    <link rel="stylesheet" href="asset/css/styles2.css?v=2.3" type ="text/css">

    <!-- Admin CSS -->
    <link rel="stylesheet" href="asset/css/admin.css?v=2.4" type="text/css">

    <title>Monitoring Panel</title>
</head>

<body>
<?php include("app/include/adminHeader.php"); ?>

    <!-- DASHBOARD START -->
    <div class="admin-wrapper">
        <div class="admin-content">
            <!-- DASHBOARD CONTENT START -->
            <div class="content">
                <h2 class="page-title">Welcome To Eco-Enzyme Monitoring System</h2>
                
                <!-- DISPLAY SUCCESS ONLY START -->
                <?php include("app/include/messages.php"); ?>
                <!-- DISPLAY SUCCESS ONLY END -->

            </div>
            <!-- DASHBOARD CONTENT END -->
        </div>
    </div>
    <!-- DASHBOARD END -->

    <!-- Custom JS -->
    <script src="asset\js\scripts.js"></script>
    <script src="asset/js/scripts2admin.js"></script>


</body>

</html>