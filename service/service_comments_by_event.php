<?php
include "include/db_connect_oo.php";
include "model/comment.php";
?>
<?php
$conn = connect_db($db_server, $db_username, $db_password, $db_dbname);

$comments = [];

if ( $_SERVER["REQUEST_METHOD"] == "GET" ) {

  if ( !isset($_GET["event_id"]) ) {
    $comments = getAll($conn, $event_filter);
  }
    $comments = getCommentsByEventId($conn, $_GET["event_id"]);
  }
}

header('Content-Type: application/json');
echo json_encode($comments);
$conn->close();
// $con->close();

?>
