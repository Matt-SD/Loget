<?php
/* Configuration info */
$loget['config'] = array(
  "title" => "Loget",
  "tagline" => "Loggin' all f**kin' day!",
  "dateformat" => "F d, Y", // See http://php.net/manual/en/function.date.php
  "timeformat" => "h:i", // See above link
);

/* Here's the serious stuff. Don't edit past here. */

/* Include the function lib */
include("lib.php");

/* Load the archive into the $loget array */
$loget['posts'] = loadArchive();

dispatch();
