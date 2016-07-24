<?php
class Utils {
  public static function humanize($str) {
    $str = trim(strtolower($str));
  	$str = preg_replace('/[^a-z0-9\s+]/', '', $str);
  	return preg_replace('/\s+/', ' ', $str);
  }
}
?>
