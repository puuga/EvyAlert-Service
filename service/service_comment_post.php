<?php
include "include/db_connect_oo.php";
include "model/comment.php";
?>
<?php
$conn = connect_db($db_server, $db_username, $db_password, $db_dbname);

// read post data
$post_data->event_id = $_POST["event_id"];
$post_data->comment = $_POST["comment"];
$post_data->user_uid = $_POST["user_uid"];
$post_data->user_name = $_POST["user_name"];
$post_data->user_photo_url = $_POST["user_photo_url"];
$post_data->created_at_long = $_POST["created_at_long"];

// write database
$last_id = createComment($conn, $post_data);
$event = getCommentById($conn, $last_id);

header('Content-Type: application/json');
echo json_encode($event);
$conn->close();
// $conn->close();
?>
