<?php
session_start();
require_once 'includes/functions.php';
init_data();
require_login();

$user  = $_SESSION['user'];
$posts = get_posts();
// Sort descending by post number
usort($posts, fn($a,$b) => $b['no'] - $a['no']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Bulletin Board – List</title>
<link rel="stylesheet" href="includes/style.css">
</head>
<body>
<div class="panel wide">
  <div class="panel-title">Bulletin Board &gt; List View</div>
  <div class="panel-body">
    <table>
      <thead>
        <tr>
          <th style="width:38px;">No.</th>
          <th>Title</th>
          <th style="width:70px;">Name</th>
          <th style="width:82px;">Date</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($posts): ?>
          <?php foreach ($posts as $p): ?>
          <tr>
            <td><?= h($p['no']) ?></td>
            <td><a class="post-link" href="view.php?no=<?= (int)$p['no'] ?>"><?= h($p['title']) ?></a></td>
            <td><?= h($p['name']) ?></td>
            <td><?= h($p['date']) ?></td>
          </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="4" style="text-align:center;padding:12px;color:#888;">No posts yet.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>

    <div class="btn-row" style="margin-top:14px;">
      <a href="write.php"><button class="btn">Write</button></a>
      <a href="logout.php"><button class="btn">Logout</button></a>
    </div>
  </div>
</div>
</body>
</html>
