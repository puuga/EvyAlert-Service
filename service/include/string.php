<?php
define("JSON_FILE", file_get_contents("include/string.json"));
function s2($key) {
  $locale = "th";
  $json_string = json_decode(JSON_FILE, true);
  return $json_string[$key][$locale];
}
?>
