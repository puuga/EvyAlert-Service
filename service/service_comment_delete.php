<?php
include "include/db_connect_oo.php"
?>
<?php
$conn = connect_db($db_server, $db_username, $db_password, $db_dbname);

// read get data
$get_data->comment_id = $_GET["comment_id"];

// write database
$sql = "UPDATE comments
        SET soft_delete=1
        WHERE id=$get_data->comment_id";
if ($conn->query($sql) === TRUE) {
  $last_id = $conn->insert_id;
  $temp = $post_data;
  $temp->id = $last_id;
} else {
  $temp = $conn->error;
  die();
}

// $sql = "SELECT id, user_uid, user_name, user_photo_url,
//         title, event_photo_url, event_type_index, province_index,
//         region_index, lat, lng, address,
//         created_at_long, created_at, updated_at
//         FROM events WHERE id=$get_data->user_uid";
// $result = $conn->query($sql);
// if ($result->num_rows > 0) {
//   // output data of each row
//   while($row = $result->fetch_assoc()) {
//     $event = $row;
//   }
// }
http_response_code(204);
// header('Content-Type: application/json');
// echo json_encode($event);
$conn->close();
// $conn->close();
?>
