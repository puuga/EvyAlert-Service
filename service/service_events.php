<?php
include "include/db_connect_oo.php"
?>
<?php
$conn = connect_db($db_server, $db_username, $db_password, $db_dbname);

$events = [];

if ( $_SERVER["REQUEST_METHOD"] == "GET" ) {
  $lat = isset($_GET["lat"]) ? $_GET["lat"] : 0.0 ;
  $lng = isset($_GET["lng"]) ? $_GET["lng"] : 0.0 ;
  $event_filter = isset($_GET["event_filter"]) ? $_GET["event_filter"] : "0,1,2,3";

  if ( !isset($_GET["filter"]) ) {
    $events = getAll($conn, $event_filter);
  } elseif ( $_GET["filter"] === "0" ) {
    $events = getNearBy($conn, $lat, $lng, 20, $event_filter);
  } elseif ( $_GET["filter"] === "1" ) {
    $events = getNearBy($conn, $lat, $lng, 50, $event_filter);
  } elseif ( $_GET["filter"] === "2" ) {
    $events = getEventsLast2Days($conn, $event_filter);
  } elseif ( $_GET["filter"] === "3" ) {
    $province_id = $_GET["province_id"];
    $events = getEventsByPrivinceId($conn, $province_id, $event_filter);
  }
}

header('Content-Type: application/json');
echo json_encode($events);
$conn->close();
// $con->close();

function getAll($conn, $event_filter) {
  $events = [];
  $sql = "SELECT id, user_uid, user_name, user_photo_url,
          title, event_photo_url, event_type_index, province_index,
          region_index, lat, lng, address,
          created_at_long, created_at, updated_at
          FROM events
          WHERE soft_delete=0 AND event_type_index IN ($event_filter)
          ORDER BY id DESC LIMIT 1000";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $events[] = $row;
    }
  }
  return $events;
}

function getNearBy($conn, $lat, $lng, $distance, $event_filter) {
  $actual_distance = $distance === 20 ? 0.3 : 0.5 ;
  $events = [];
  $sql = "SELECT
              id, user_uid, user_name, user_photo_url,
              title, event_photo_url, event_type_index, province_index,
              region_index, lat, lng, address,
              created_at_long, created_at, updated_at,
              DISTANCE_KM(lat_d, lng_d, $lat, $lng) distance
          FROM
              events
          WHERE soft_delete=0 AND event_type_index IN ($event_filter) AND
              lat_d BETWEEN $lat - $actual_distance AND $lat + $actual_distance
                  AND lng_d BETWEEN $lng - $actual_distance AND $lng + $actual_distance
          HAVING distance <= $distance
          ORDER BY distance LIMIT 1000";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $events[] = $row;
    }
  }
  return $events;
}

function getEventsLast2Days($conn, $event_filter) {
  $events = [];
  $sql = "SELECT id, user_uid, user_name, user_photo_url,
          title, event_photo_url, event_type_index, province_index,
          region_index, lat, lng, address,
          created_at_long, created_at, updated_at
          FROM events
          WHERE soft_delete=0 AND event_type_index IN ($event_filter) AND
          created_at BETWEEN (NOW() - INTERVAL 7 DAY) AND NOW()
          ORDER BY id DESC
          LIMIT 1000";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $events[] = $row;
    }
  }
  return $events;
}

function getEventsByPrivinceId($conn, $province_id, $event_filter) {
  $events = [];
  $sql = "SELECT id, user_uid, user_name, user_photo_url,
          title, event_photo_url, event_type_index, province_index,
          region_index, lat, lng, address,
          created_at_long, created_at, updated_at
          FROM events
          WHERE soft_delete=0 AND event_type_index IN ($event_filter)
          AND province_index=$province_id
          ORDER BY id DESC LIMIT 1000";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $events[] = $row;
    }
  }
  return $events;
}
?>
