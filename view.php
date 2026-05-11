<?php
session_start();
require_once 'includes/functions.php';
init_data();
require_login();

$user = $_SESSION['user'];
$no   = (int)($_GET['no'] ?? 0);
$post = find_post($no);
if (!$post) redirect('list.php');

$is_owner = ($user['id'] === $post['userId']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Bulletin Board – View</title>
<link rel="stylesheet" href="includes/style.css">
</head>
<body>
<div class="panel wide">
  <div class="panel-title">Bulletin Board &gt; Viewing Content</div>
  <div class="panel-body">

    <div class="view-header">
      <span>Title: <strong><?= h($post['title']) ?></strong></span>
      <span><?= h($post['name']) ?> &nbsp;|&nbsp; <?= h($post['date']) ?></span>
    </div>

    <div class="view-body"><?= h($post['content']) ?></div>

    <div class="btn-row" style="margin-top:20px;">
      <a href="list.php"><button class="btn">List</button></a>
      <?php if ($is_owner): ?>
        <a href="edit.php?no=<?= $no ?>"><button class="btn">Edit</button></a>
        <a href="delete.php?no=<?= $no ?>"
           onclick="return confirm('Delete this post?')"><button class="btn">Delete</button></a>
      <?php endif; ?>
      <a href="write.php"><button class="btn">Write</button></a>
      <a href="logout.php"><button class="btn">Logout</button></a>
    </div>

  </div>
</div>
</body>
</html>
