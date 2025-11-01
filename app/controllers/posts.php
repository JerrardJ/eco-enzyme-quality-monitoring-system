<?php 

include("app/database/db.php");
include("app/helpers/validatePost.php");

$table = 'posts';

$posts = selectAll($table);

$errors = array();
$id = "";
$title = "";
$description = "";
$published = "";

// FOR ADMIN POST ONLY  
if (isset($_GET['id'])) {
    $post = selectOne($table, ['id'=> $_GET['id']]);
    
    $id = $post['id'];
    $title = $post['title'];
    $description = $post['description'];
    $published = $post['published'];
}

// DELETE BUTTON FOR ADMIN POST PAGE
if (isset($_GET['delete_id'])) {
    $count = delete($table, $_GET['delete_id']);

    // DISPLAY SUCCESS MESSAGE FOR GENERAL ADMIN PAGE
    $_SESSION['message'] = 'Post Deleted Successfully!';
    $_SESSION['type'] = 'success';
    header('location: indexPost.php');
    exit();
}

// PUBLISH IN CREATE POST
if (isset($_GET['published']) && isset($_GET['p_id'])) {
    $published = $_GET['published'];
    $p_id = $_GET['p_id'];
    $count = update($table, $p_id, ['published' => $published]);

    // DISPLAY SUCCESS MESSAGE FOR CREATE POST
    $_SESSION['message'] = 'Post Status Publish Changed!';
    $_SESSION['type'] = 'success';
    header('location: indexPost.php');
    exit();
}

// ADD POST BUTTON
if (isset($_POST['add-post'])) {
    // dd($_FILES['image']['name']);
    if (!empty($_FILES['image'])) {
        $image_name = time() . '_' . $_FILES['image']['name'];
        $destination = "asset/images/" . $image_name;
        $result = move_uploaded_file($_FILES['image']['tmp_name'], $destination);

        if($result) {
            $_POST['image'] = $image_name;
        } else {
            array_push($errors, "Failed Upload!");
        }

    } else {
        array_push($errors,'Image Required!');
    }
    if (count($errors) == 0) {
        unset($_POST['add-post']);
        $_POST['user_id'] = $_SESSION['id'];
        $_POST['published'] = isset($_POST['published']) ? 1 : 0;

        // DISPLAY SUCCESS MESSAGE FOR CREATE POST
        $post_id = create($table, $_POST);
        $_SESSION['message'] = 'Post Created Successfully!';
        $_SESSION['type'] = 'success';
        header('location: indexPost.php');
        exit();
    } else {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $published = isset($_POST['published']) ? 1 : 0;
    }
}

// EDIT POST BUTTON
if (isset($_POST['update-post'])) {
    $errors = validatePost($_POST);

    if (!empty($_FILES['image']['name'])) {
        $image_name = time() . '_' . $_FILES['image']['name'];
        $destination = "asset/images/" . $image_name;

        $result = move_uploaded_file($_FILES['image']['tmp_name'], $destination);

        if($result) {
            $_POST['image'] = $image_name;
        } else {
            array_push($errors, "Failed Upload!");
        }

    } else {
        array_push($errors, "Image Required!");
    }
    if (count($errors) == 0) {
        $id = $_POST['id'];
        unset($_POST['update-post'], $_POST['id']);
        $_POST['user_id'] = $_SESSION['id'];
        $_POST['published'] = isset($_POST['published']) ? 1 : 0;

        // DISPLAY SUCCESS MESSAGE FOR EDIT POST
        $post_id = update($table, $id, $_POST);
        $_SESSION['message'] = 'Post Updated Successfully!';
        $_SESSION['type'] = 'success';
        header('location: indexPost.php');
        exit();
    } else {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $published = isset($_POST['published']) ? 1 : 0;
    }

}