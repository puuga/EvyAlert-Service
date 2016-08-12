<?php
define("JSON_CONSTANT_FILE", file_get_contents("include/constant.json"));
function getConstant($key='') {
  if ($key==='') {
    return "";
  }
  $json_string = json_decode(JSON_CONSTANT_FILE, true);
  return $json_string[$key];
}
?>
