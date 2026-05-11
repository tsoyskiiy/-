<?php
define('USERS_FILE', __DIR__ . '/../data/users.json');
define('POSTS_FILE', __DIR__ . '/../data/posts.json');

/* ── Bootstrap data files ── */
function init_data() {
    if (!file_exists(USERS_FILE)) {
        $users = [
            ['id'=>'User1','pw'=>'abc101','name'=>'Kim1','email'=>'Mail1'],
            ['id'=>'User2','pw'=>'abc102','name'=>'Kim2','email'=>'Mail2'],
            ['id'=>'User3','pw'=>'abc103','name'=>'Kim3','email'=>'Mail3'],
            ['id'=>'User4','pw'=>'abc104','name'=>'Kim4','email'=>'Mail4'],
        ];
        file_put_contents(USERS_FILE, json_encode($users, JSON_PRETTY_PRINT));
    }
    if (!file_exists(POSTS_FILE)) {
        $posts = [
            ['no'=>1,'userId'=>'User1','name'=>'Kim1','title'=>'Title1','content'=>'Hello1','date'=>'2024-03-15'],
            ['no'=>2,'userId'=>'User2','name'=>'Kim2','title'=>'Title2','content'=>'Hello2','date'=>'2024-03-26'],
            ['no'=>3,'userId'=>'User3','name'=>'Kim3','title'=>'Title3','content'=>'Hello3','date'=>'2024-03-27'],
            ['no'=>4,'userId'=>'User4','name'=>'Kim4','title'=>'Title4','content'=>'Hello4','date'=>'2024-04-07'],
        ];
        file_put_contents(POSTS_FILE, json_encode($posts, JSON_PRETTY_PRINT));
    }
}

/* ── Users ── */
function get_users() {
    return json_decode(file_get_contents(USERS_FILE), true) ?? [];
}
function save_users($users) {
    file_put_contents(USERS_FILE, json_encode(array_values($users), JSON_PRETTY_PRINT));
}
function find_user($id) {
    foreach (get_users() as $u) if ($u['id'] === $id) return $u;
    return null;
}

/* ── Posts ── */
function get_posts() {
    return json_decode(file_get_contents(POSTS_FILE), true) ?? [];
}
function save_posts($posts) {
    file_put_contents(POSTS_FILE, json_encode(array_values($posts), JSON_PRETTY_PRINT));
}
function find_post($no) {
    foreach (get_posts() as $p) if ($p['no'] == $no) return $p;
    return null;
}
function next_post_no() {
    $posts = get_posts();
    return $posts ? max(array_column($posts, 'no')) + 1 : 1;
}

/* ── Helpers ── */
function h($s) { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }
function redirect($url) { header("Location: $url"); exit; }
function require_login() {
    if (empty($_SESSION['user'])) redirect('login.php');
}
