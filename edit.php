<?php
session_start();
require_once 'includes/functions.php';
init_data();
require_login();

$user  = $_SESSION['user'];
$no    = (int)($_REQUEST['no'] ?? 0);
$post  = find_post($no);
if (!$post || $post['userId'] !== $user['id']) redirect('list.php');

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
        $posts = get_posts();
        foreach ($posts as &$p) {
            if ($p['no'] == $no) {
                $p['title']   = $title;
                $p['content'] = $content;
                break;
            }
        }
        save_posts($posts);
        redirect('view.php?no=' . $no);
    }
}

// Prefill from existing post on GET
$title   = $_POST['title']   ?? $post['title'];
$content = $_POST['content'] ?? $post['content'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Bulletin Board – Edit</title>
<link rel="stylesheet" href="includes/style.css">
</head>
<body>
<div class="panel wide">
  <div class="panel-title">Bulletin Board &gt; Editing</div>
  <div class="panel-body">
    <form method="post" action="edit.php?no=<?= $no ?>">
      <div class="form-row">
        <label>Name</label>
        <input type="text" value="<?= h($post['name']) ?>" readonly>
      </div>
      <div class="form-row">
        <label for="password">Password</label>
        <input type="password" id="password" name="password">
      </div>
      <div class="form-row">
        <label for="title">Title</label>
        <input type="text" id="title" name="title" value="<?= h($title) ?>">
      </div>
      <div class="form-row" style="align-items:flex-start;">
        <label for="content" style="padding-top:4px;">Content</label>
        <textarea id="content" name="content"><?= h($content) ?></textarea>
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
