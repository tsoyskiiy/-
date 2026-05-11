<?php
session_start();
require_once 'includes/functions.php';
init_data();

$msg       = '';
$msg_type  = 'error';
$id_ok     = false; 

if (!isset($_SESSION['signup_id_checked'])) $_SESSION['signup_id_checked'] = false;
if (!isset($_SESSION['signup_checked_id'])) $_SESSION['signup_checked_id'] = '';

if (isset($_POST['action']) && $_POST['action'] === 'check') {
    $id = trim($_POST['user_id'] ?? '');
    if (!$id) {
        $msg = 'Please enter a User ID.';
    } elseif (find_user($id)) {
        $msg      = 'This ID is already taken.';
        $msg_type = 'error';
        $_SESSION['signup_id_checked'] = false;
        $_SESSION['signup_checked_id'] = '';
    } else {
        $msg      = 'This ID is available.';
        $msg_type = 'success';
        $_SESSION['signup_id_checked'] = true;
        $_SESSION['signup_checked_id'] = $id;
    }
}


if (isset($_POST['action']) && $_POST['action'] === 'save') {
    $id    = trim($_POST['user_id'] ?? '');
    $pw    = $_POST['password'] ?? '';
    $pw2   = $_POST['password2'] ?? '';
    $name  = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if (!$_SESSION['signup_id_checked'] || $_SESSION['signup_checked_id'] !== $id) {
        $msg = 'Please check ID availability first.';
    } elseif (!$pw) {
        $msg = 'Password is required.';
    } elseif ($pw !== $pw2) {
        $msg = 'Passwords do not match.';
    } elseif (!$name) {
        $msg = 'Name is required.';
    } elseif (!$email) {
        $msg = 'Email is required.';
    } else {
        $users = get_users();
        $users[] = ['id'=>$id,'pw'=>$pw,'name'=>$name,'email'=>$email];
        save_users($users);
        $_SESSION['signup_id_checked'] = false;
        $_SESSION['signup_checked_id'] = '';
        $_SESSION['signup_success'] = true;
        redirect('login.php');
    }
}

$prev_id    = h($_POST['user_id'] ?? '');
$prev_name  = h($_POST['name']    ?? '');
$prev_email = h($_POST['email']   ?? '');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Sign Up</title>
<link rel="stylesheet" href="includes/style.css">
</head>
<body>
<div class="panel">
  <div class="panel-title">Sign Up</div>
  <div class="panel-body">

    <?php if ($msg): ?>
      <div class="msg <?= $msg_type ?>"><?= h($msg) ?></div>
    <?php endif; ?>


    <form method="post" action="signup.php" style="margin-bottom:0;">
      <div class="uid-row">
        <label for="user_id">User ID</label>
        <input type="text" id="user_id" name="user_id" value="<?= $prev_id ?>">
        <button type="submit" name="action" value="check" class="btn">Duplicate Check</button>
      </div>
   
      <input type="hidden" name="name"      value="<?= $prev_name ?>">
      <input type="hidden" name="email"     value="<?= $prev_email ?>">
    </form>


    <form method="post" action="signup.php">
      <input type="hidden" name="user_id" value="<?= $prev_id ?>">
      <div class="form-row">
        <label for="password">Password</label>
        <input type="password" id="password" name="password">
      </div>
      <div class="form-row">
        <label for="password2">Password Confirm</label>
        <input type="password" id="password2" name="password2">
      </div>
      <div class="form-row">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="<?= $prev_name ?>">
      </div>
      <div class="form-row">
        <label for="email">Email</label>
        <input type="text" id="email" name="email" value="<?= $prev_email ?>">
      </div>
      <div class="btn-row">
        <button type="submit" name="action" value="save" class="btn">Save</button>
        <a href="login.php"><button type="button" class="btn">Cancel</button></a>
      </div>
    </form>

  </div>
</div>
</body>
</html>
