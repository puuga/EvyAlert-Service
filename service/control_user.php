<?php
// server should keep session data for AT LEAST 30 minute
ini_set('session.gc_maxlifetime', 1800);

// each client should remember their session id for EXACTLY 30 minute
session_set_cookie_params(1800);

// Start the session
session_start();

function isSignin() {
  return isset($_SESSION["user_is_signin"]) ? TRUE : FALSE;
}

function getUserId() {
  return $_SESSION["user_id"];
}

function getUserEmail() {
  return $_SESSION["user_email"];
}

function getUserUsername() {
  return $_SESSION["user_username"];
}

function getUserLevel() {
  return isset($_SESSION["user_level"]) ? $_SESSION["user_level"] : 10000;
}

function requireSignin($bool) {
  if ( $bool && !isSignin() ) {
    header("Location: sign_in_form.php?message=require_signined");
    die();
  }
}

function requireLevel($level) {
  if ( getUserLevel() > $level ) {
    header("Location: sign_in_form.php?message=no_permission");
    die();
  }
}

?>
