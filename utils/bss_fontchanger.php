<?php
defined( '_JEXEC' ) or die( 'Restricted index access' );

$cookie_prefix = "bss-";
$cookie_time = time()+31536000;
if (isset($_GET['widthstyle'])) {
	$width = $_GET['widthstyle'];
	$_SESSION[$cookie_prefix. 'widthstyle'] = $width;
	setcookie ($cookie_prefix. 'widthstyle', $width, $cookie_time, '/', false);
}

$widthstyle = "w-" . $default_width;

//load width style
if (isset($_SESSION[$cookie_prefix. 'widthstyle'])) {
	$widthstyle = $_SESSION[$cookie_prefix. 'widthstyle'];
} elseif (isset($_COOKIE[$cookie_prefix. 'widthstyle'])) {
	$widthstyle = $_COOKIE[$cookie_prefix. 'widthstyle'];
}

$thisurl = $_SERVER['PHP_SELF'] . rebuildQueryString();

function rebuildQueryString() {
  $ignores = array("tstyle","contraststyle","fontstyle","widthstyle", "tempus");
  if (!empty($_SERVER['QUERY_STRING'])) {
      $parts = explode("&", $_SERVER['QUERY_STRING']);
      $newParts = array();
      foreach ($parts as $val) {
          $val_parts = explode("=", $val);
          if (!in_array($val_parts[0], $ignores)) {
            array_push($newParts, $val);
          }
      }
      if (count($newParts) != 0) {
          $qs = implode("&amp;", $newParts);
      } else {
          return "?";
      }
      return "?" . $qs . "&amp;"; // this is your new created query string
  } else {
      return "?";
  } 
}
?>
