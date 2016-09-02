<?php
include "include/db_connect_oo.php"
?>
<?php
$conn = connect_db($db_server, $db_username, $db_password, $db_dbname);

if ( $_SERVER["REQUEST_METHOD"] == "GET" ) {
  $lat = isset($_GET["lat"]) ? $_GET["lat"] : 0.0 ;
  $lng = isset($_GET["lng"]) ? $_GET["lng"] : 0.0 ;
  $event_filter = isset($_GET["event_filter"]) ? $_GET["event_filter"] : "0,1,2,3";

  if ( !isset($_GET["id"]) ) {
    $provinces = getAllProvinces($conn);
  } else {
    $provinces = getProvince($conn, $_GET["id"]);
  }
}

header('Content-Type: application/json');
echo json_encode($provinces);
$conn->close();
// $con->close();

function getAllProvinces($conn) {
  $provinces = [];
  $sql = "SELECT * FROM provinces";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $provinces[] = $row;
    }
  }
  return $provinces;
}

function getProvince($conn, $id) {
  $sql = "SELECT * FROM provinces WHERE id=$id";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $province = $row;
    }
  }
  return $province;
}

?>
