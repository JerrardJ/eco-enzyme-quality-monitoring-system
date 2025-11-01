<?php 

include("app/database/db.php");
include("app/helpers/validateUser.php");

$table = 'users';

$admin_users = selectAll($table, ['admin' => 1]);

$errors = array();
$id = '';
$username = '';
$admin = '';
$password = '';
$passwordConf = '';

function loginUser($user)
{
    $_SESSION['id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['admin'] = $user['admin'];
    $_SESSION['message'] = 'Your Account Successfully Login';
    $_SESSION['type'] = 'success';

    if ($_SESSION['admin']) {
        header('location: indexDashboard.php');
    } else {
        header('location: indexDashboard.php');
    }
    exit();
}

// REGISTER & ADD USER BUTTON
if (isset($_POST['register-btn']) || isset( $_POST['create-admin'])) {
    $errors = validateUser($_POST);

    if (count($errors) == 0) {
        unset($_POST['register-btn'], $_POST['passwordConf'], $_POST['create-admin']);

        // ENCRYPTION PASSWORD
        $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

        if (isset($_POST['admin'])) {
            $_POST['admin'] = 1;
            $user_id = create($table, $_POST);

            // DISPLAY SUCCESS MESSAGE FOR ADMIN USER PAGE
            $_SESSION['message'] = 'Admin Account Created Successfully!';
            $_SESSION['type'] = 'success';
            header('location: indexUser.php');
            exit();
        } else {
            $_POST['admin'] = 0;
            $user_id = create($table, $_POST);
            $user = selectOne($table, ['id' => $user_id]);
            loginUser($user);
        }
    } else {
        $username = $_POST['username'];
        $admin = isset($_POST['admin']) ? 1 : 0;
        $password = $_POST['password'];
        $passwordConf = $_POST['passwordConf'];
    }
}

// EDIT USER BUTTON
if(isset($_POST['update-user'])) {
    $errors = validateUser($_POST);

    if (count($errors) == 0) {
        $id = $_POST['id'];
        unset($_POST['passwordConf'], $_POST['update-user'], $_POST['id']);

        // ENCRYPTION PASSWORD
        $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $_POST['admin'] = isset($_POST['admin']) ? 1 : 0;
        $count = update($table, $id, $_POST);

        // DISPLAY SUCCESS MESSAGE FOR ADMIN EDIT USER PAGE
        $_SESSION['message'] = 'Admin Account Updated Successfully!';
        $_SESSION['type'] = 'success';
        header('location: indexUser.php');
        exit();

    } else {
        $username = $_POST['username'];
        $admin = isset($_POST['admin']) ? 1 : 0;
        $password = $_POST['password'];
        $passwordConf = $_POST['passwordConf'];
    }
}

// FOR ADMIN USER PAGE
if (isset($_GET['id'])) {
    $user = selectOne($table, ['id'=> $_GET['id']]);

    $id = $user['id'];
    $username = $user['username'];
    $admin = isset($user['admin']) ? 1 : 0;
}

// LOGIN BUTTON
if (isset($_POST['login-btn'])) {
    $errors = validateLogin($_POST);

    if (count($errors) === 0) {
        $user = selectOne($table, ['username'=> $_POST['username']]);

        if ($user && password_verify($_POST['password'], $user['password'])) {
            loginUser($user);
        } else {
            // MESSAGE WILL DISPLAY WHEN PASSWORD INVALID ACCORDING TO DATABASE
            array_push($errors, 'Please Check Again!');
        }
    }
    $username = $_POST['username'];
    $password = $_POST['password'];
}

// DELETE BUTTON FOR ADMIN USER PAGE
if (isset($_GET['delete_id'])) {
    $count = delete($table, $_GET['delete_id']);
    $_SESSION['message'] = 'Admin Account Deleted!';
    $_SESSION['type'] = 'success';
    header('location: indexUser.php');
    exit();
}