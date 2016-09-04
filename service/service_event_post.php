<?php
include "include/db_connect_oo.php";
include "model/event.php";
?>
<?php
$conn = connect_db($db_server, $db_username, $db_password, $db_dbname);

// read post data
$post_data->user_uid = $_POST["user_uid"];
$post_data->user_name = $_POST["user_name"];
$post_data->user_photo_url = $_POST["user_photo_url"];
$post_data->title = $_POST["title"];
$post_data->event_photo_url = $_POST["event_photo_url"];
$post_data->event_type_index = $_POST["event_type_index"];
$post_data->province_index = $_POST["province_index"];
$post_data->region_index = $_POST["region_index"];
$post_data->lat = $_POST["lat"];
$post_data->lng = $_POST["lng"];
$post_data->address = $_POST["address"];
$post_data->created_at_long = $_POST["created_at_long"];

// write database
$last_id = createEvent($conn, $post_data);
$event = getEventById($conn, $last_id);

header('Content-Type: application/json');
echo json_encode($event);
$conn->close();
// $conn->close();
?>
