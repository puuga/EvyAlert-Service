<?php
include "include/db_connect_oo.php";
include "model/event.php";
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

?>
