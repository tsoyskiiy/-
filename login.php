<?php
session_start();
require_once 'includes/functions.php';
init_data();

// Already logged in → go to list
if (!empty($_SESSION['user'])) redirect('list.php');

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = trim($_POST['user_id'] ?? '');
    $pw = $_POST['password'] ?? '';
    $user = find_user($id);
    if ($user && $user['pw'] === $pw) {
        $_SESSION['user'] = $user;
        redirect('list.php');
    } else {
        $error = 'Invalid ID or Password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login</title>
<link rel="stylesheet" href="includes/style.css">
</head>
<body>
<div class="panel">
  <div class="panel-title">Login</div>
  <div class="panel-body">
    <form method="post" action="login.php">
      <div class="form-row">
        <label for="user_id">User ID</label>
        <input type="text" id="user_id" name="user_id"
               value="<?= h($_POST['user_id'] ?? '') ?>">
      </div>
      <div class="form-row">
        <label for="password">Password</label>
        <input type="password" id="password" name="password">
      </div>
      <?php if ($error): ?>
        <div class="msg error"><?= h($error) ?></div>
      <?php endif; ?>
      <div class="btn-row-center">
        <button type="submit" class="btn-full">Login</button>
      </div>
    </form>
    <div class="signup-link">
      No account? <a href="signup.php">Sign Up</a>
    </div>
  </div>
</div>
</body>
</html>
