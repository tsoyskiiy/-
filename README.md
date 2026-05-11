# Bulletin Board – PHP Version

## Requirements
- PHP 7.4+ (with `json` extension, enabled by default)
- A web server: Apache, Nginx, or PHP's built-in server

## Setup

1. Copy the `bulletin_board_php/` folder to your web server's document root
   (e.g. `htdocs/` for XAMPP or `www/` for WAMP).

2. Make sure the `data/` folder is **writable** by PHP:
   ```
   chmod 755 data/
   ```
   On Windows (XAMPP/WAMP) this is usually automatic.

3. Open your browser and go to:
   ```
   http://localhost/bulletin_board_php/
   ```

## Quick start with PHP built-in server
```
cd bulletin_board_php
php -S localhost:8000
```
Then open http://localhost:8000

## Pre-loaded test accounts

| User ID | Password | Name  | Email |
|---------|----------|-------|-------|
| User1   | abc101   | Kim1  | Mail1 |
| User2   | abc102   | Kim2  | Mail2 |
| User3   | abc103   | Kim3  | Mail3 |
| User4   | abc104   | Kim4  | Mail4 |

Each user already has one post. Data is stored in `data/users.json` and `data/posts.json`.

## File structure
```
bulletin_board_php/
├── index.php          → redirects to login
├── login.php          → (1) Login screen
├── signup.php         → (2) Sign Up screen
├── list.php           → (3) List View screen
├── view.php           → (4) Viewing Content screen
├── write.php          → (5) Writing screen
├── edit.php           → (6) Editing screen
├── delete.php         → deletes a post
├── logout.php         → clears session
├── includes/
│   ├── functions.php  → shared PHP functions
│   └── style.css      → shared styles
└── data/
    ├── users.json     → user accounts
    └── posts.json     → posts
```
