<?php
include "include/db_connect_oo.php"
?>
<?php
$conn = connect_db($db_server, $db_username, $db_password, $db_dbname);

$events = [];

$sql = "SELECT id, user_uid, user_name, user_photo_url,
        title, event_photo_url, event_type_index, province_index,
        region_index, lat, lng, address,
        created_at_long, created_at, updated_at
        FROM events ORDER BY id DESC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $events[] = $row;
  }
}

header('Content-Type: application/json');
echo json_encode($events);
$conn->close();
// $con->close();
?>
