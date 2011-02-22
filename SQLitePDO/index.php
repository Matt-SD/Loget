<?php
/* Configuration info */
$loget['config'] = array(
  "title" => "Loget",
  "tagline" => "Loggin' all f**kin' day!",
  "dateformat" => "F d, Y", // See http://php.net/manual/en/function.date.php
  "timeformat" => "h:i", // See http://php.net/manual/en/function.date.php
);

/* Instantiate the database */
$loget['db'] = new PDO('sqlite:archive.sq3');

/* Build an array of posts */
$loget['posts'] = loadPosts();

/* Run the output function */
dispatch();

/* Function to load all the posts */
function loadPosts() {
  global $loget;
  
  if(isset($_GET['view']) && isset($_GET['id'])) {
    /* If both slug & ID given */
    $posts = $loget['db']->query("SELECT * FROM `posts` WHERE `slug`='{$_GET['view']}' AND `id`='{$_GET['id']}'")->fetchAll();
  } else if(isset($_GET['view'])) {
    /* If the slug is given */
    $posts = $loget['db']->query("SELECT * FROM `posts` WHERE `slug`='{$_GET['view']}'")->fetchAll();
  } else if(isset($_GET['id'])) {
    /* If the ID is given */
    $posts = $loget['db']->query("SELECT * FROM `posts` WHERE `id`='{$_GET['id']}'")->fetchAll();
  } else {
    /* If nothing is given */
    $posts = $loget['db']->query("SELECT * FROM `posts`")->fetchAll();
  }
  
  /* return the posts */
  return $posts;
}

/* The dispatch function */
function dispatch() {
  /* load the $loget array into the variable scope */
  global $loget;
  extract($loget);
  
  /* load the template file */
  include("template.php");
}
?>
