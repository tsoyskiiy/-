<?php
session_start();
require_once 'includes/functions.php';
init_data();
require_login();

$user  = $_SESSION['user'];
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pw      = $_POST['password'] ?? '';
    $title   = trim($_POST['title']   ?? '');
    $content = trim($_POST['content'] ?? '');

    if ($pw !== $user['pw']) {
        $error = 'Incorrect password.';
    } elseif (!$title) {
        $error = 'Title is required.';
    } elseif (!$content) {
        $error = 'Content is required.';
    } else {
        $posts   = get_posts();
        $posts[] = [
            'no'      => next_post_no(),
            'userId'  => $user['id'],
            'name'    => $user['name'],
            'title'   => $title,
            'content' => $content,
            'date'    => date('Y-m-d'),
        ];
        save_posts($posts);
        redirect('list.php');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Bulletin Board – Write</title>
<link rel="stylesheet" href="includes/style.css">
</head>
<body>
<div class="panel wide">
  <div class="panel-title">Bulletin Board &gt; Writing</div>
  <div class="panel-body">
    <form method="post" action="write.php">
      <div class="form-row">
        <label>Name</label>
        <input type="text" value="<?= h($user['name']) ?>" readonly>
      </div>
      <div class="form-row">
        <label for="password">Password</label>
        <input type="password" id="password" name="password">
      </div>
      <div class="form-row">
        <label for="title">Title</label>
        <input type="text" id="title" name="title"
               value="<?= h($_POST['title'] ?? '') ?>">
      </div>
      <div class="form-row" style="align-items:flex-start;">
        <label for="content" style="padding-top:4px;">Content</label>
        <textarea id="content" name="content"><?= h($_POST['content'] ?? '') ?></textarea>
      </div>
      <?php if ($error): ?>
        <div class="msg error"><?= h($error) ?></div>
      <?php endif; ?>
      <div class="btn-row">
        <button type="submit" class="btn">Save</button>
        <a href="list.php"><button type="button" class="btn">List</button></a>
        <a href="logout.php"><button type="button" class="btn">Logout</button></a>
      </div>
    </form>
  </div>
</div>
</body>
</html>
