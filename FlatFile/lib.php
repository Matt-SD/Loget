<?php

/* http://snipplr.com/view.php?codeview&id=17886 */
function XML2Arr($xml,$recursive=false) {
  if(!$recursive) {
    $array = simplexml_load_string($xml);
  } else {
    $array = $xml;
  }
  $newArray = array();
  $array = $array;
  foreach($array as $key => $value) {
    $value = (array) $value;
    if(isset($value[0])) {
      $newArray[$key] = trim($value[0]);
    } else {
      $newArray[$key][] = XML2Arr($value,true);
    }
  }
  return $newArray;
}


function loadArchive() {
  /* Get an array of files in /archive */
  $arr = scandir("./archive/");
  /* Remove . and .. */
  unset($arr[0]); unset($arr[1]);
  
  /* Load the contents of each file into an array */
  foreach($arr as $k => $v) {
    $xml = file_get_contents("./archive/{$v}");
    $entry = XML2Arr($xml);
    $entry['entry'] = processHTML($entry['entry']);
    $archive[$entry['id']] = $entry;
  }
  
  /* The next 3 lines were a comment on the PHP.net manual */
  $tmp = Array();
  foreach($archive as &$ma) { $tmp[] = &$ma["timestamp"]; }
  array_multisort($tmp, $archive);
  
  /* Reverse it so that the highest ID is first */
  $archive = array_reverse($archive);
  
  return $archive;
}

function processHTML($content) {
  return str_replace(array('{{','}}'),array('<','>'),$content);
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
