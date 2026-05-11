<?php
session_start();
require_once 'includes/functions.php';
init_data();
require_login();

$user = $_SESSION['user'];
$no   = (int)($_GET['no'] ?? 0);
$post = find_post($no);

if ($post && $post['userId'] === $user['id']) {
    $posts = get_posts();
    $posts = array_filter($posts, fn($p) => $p['no'] != $no);
    save_posts(array_values($posts));
}

redirect('list.php');
