<?php
ini_set('display_errors','on');
/* Build the user info array */
$user = array(
  "password" => md5("l0g3t"), // NOTE: Password MUST be inside the brackets
);

/* Login or Admin Panel? */
if(!isLoggedIn()) {
  /* Login */
  dispatchLogin();
} else if(isLoggedIn()) {
  /* Admin Panel */
  dispatchMain();
}

/* Assorted functions */
function isLoggedIn() {
  global $user;
  if(!isset($_COOKIE['loget'])) {
    return false;
  } else if($_COOKIE['loget']!==$user['password']) {
    return false;
  } else {
    return true;
  }
}

function dispatchLogin() {
  global $user;
  
  if(isset($_POST['password'])) {
    if(md5($_POST['password'])==$user['password']) {
      setcookie('loget',md5($_POST['password']));
      header("Location: ./admin.php");
    }
  }
  
  echo "<form action=\"./admin.php?login\" method=\"POST\">\n";
  echo "<p><input type=\"password\" name=\"password\"> <input type=\"submit\" value=\"Go\"></p>\n";
  echo "</form>";
}

function dispatchMain() {
  $db = new PDO("sqlite:archive.sq3");
  
  if(isset($_GET['delete'])) {
    $db->exec("DELETE FROM `posts` WHERE `id`='{$_GET['delete']}'");
    echo "<h1>Post Deleted</h1>";
  }
  if(isset($_POST['content'])) {
    $id = $db->query("SELECT `id` FROM `posts` ORDER BY `id` DESC LIMIT 1")->fetch();
    $id = $id['id'] + 1;
    $title = $_POST['title'];
    $slug = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $title);
	$slug = strtolower(trim($slug, '-'));
	$slug = preg_replace("/[\/_|+ -]+/", '-', $slug);
	$content = htmlspecialchars($_POST['content']);
	$timestamp = time();
	try {
    $db->exec("INSERT INTO `posts` (`id`,`title`,`slug`,`content`,`timestamp`) VALUES ('$id','$title','$slug','$content','$timestamp');");
    } catch(PDOException $e) {
     var_dump($e);
    }
    echo "<h1 style=\"color:#080;\">Created post successfully.</h1>";
  }
  
  if(isset($_GET['edit'])) {
    $post = $db->query("SELECT * FROM `posts` WHERE `id`='{$_GET['edit']}'")->fetch();
    $title = $post['title'];
    $content = htmlspecialchars($post['content']);
  } else { $title = null; $content = null; }
  /* Draw up the create post form */
  echo "<form action=\"./admin.php\" method=\"POST\">\n";
  echo "<p>Title: <input type=\"text\" name=\"title\" size=\"25\" value=\"{$title}\"></p>\n";
  echo "<p>Content:<br /><textarea name=\"content\" cols=\"75\" rows=\"10\">{$content}</textarea></p>\n";
  if(isset($_GET['edit'])) {
    echo "<input type=\"hidden\" name=\"edit\" value=\"{$_GET['edit']}\">\n";
  }
  echo "<p><input type=\"submit\" value=\"Create Post\"></p>\n";
  echo "</form>\n";
  echo "<hr>\n";
  
  /* Generate list of posts */
  echo "<h2>Existing posts:</h2>\n";
  echo "<ul>\n";
  $posts = $db->query("SELECT * FROM `posts` ORDER BY `id` DESC")->fetchAll();
  foreach($posts as $post) {
    echo "<li><a href=\"./admin.php?edit={$post['id']}\">#{$post['id']} &raquo; {$post['title']}</a> - <a href=\"./admin.php?delete={$post['id']}\" style=\"color:red;\">Delete</a></li>\n";
  }
  echo "</ul>";
}
?>
