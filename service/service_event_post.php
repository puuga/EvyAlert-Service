<?php
include "include/db_connect_oo.php"
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
$sql = "INSERT INTO events (user_uid, user_name, user_photo_url,
                            title, event_photo_url, event_type_index,
                            province_index, region_index,
                            lat, lng, lat_d, lng_d,
                            lat_lng,
                            address, created_at_long,
                            created_at, updated_at )
          VALUES ('$post_data->user_uid', '$post_data->user_name', '$post_data->user_photo_url',
            '$post_data->title', '$post_data->event_photo_url', '$post_data->event_type_index',
            '$post_data->province_index', '$post_data->region_index',
            '$post_data->lat', '$post_data->lng', $post_data->lat, $post_data->lng,
            ST_GeomFromText('POINT($post_data->lat $post_data->lng)'),
            '$post_data->address', $post_data->created_at_long,
            NOW(),
            NOW()
          ) ";
if ($conn->query($sql) === TRUE) {
  $last_id = $conn->insert_id;
  $temp = $post_data;
  $temp->id = $last_id;
} else {
  $temp = $conn->error;
}

$sql = "SELECT id, user_uid, user_name, user_photo_url,
        title, event_photo_url, event_type_index, province_index,
        region_index, lat, lng, address,
        created_at_long, created_at, updated_at
        FROM events WHERE id=$last_id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $event = $row;
  }
}

header('Content-Type: application/json');
echo json_encode($event);
$conn->close();
// $conn->close();
?>
