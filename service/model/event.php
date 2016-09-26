<?php
function createEvent($conn, $post_data) {
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
    return $last_id;
  } else {
    echo $conn->error;
    die();
  }

}

function getEventById($conn, $id) {
  $sql = "SELECT id, user_uid, user_name, user_photo_url,
          title, event_photo_url, event_type_index, province_index,
          region_index, lat, lng, address,
          created_at_long, created_at, updated_at,
          count_comments(id) number_of_comments
          FROM events WHERE id=$id";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $event = $row;
    }
  }

  return $event;
}

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
              count_comments(id) number_of_comments,
              DISTANCE_KM(lat_d, lng_d, $lat, $lng) distance
          FROM
              events
          WHERE soft_delete=0 AND event_type_index IN ($event_filter) AND
              lat_d BETWEEN $lat - $actual_distance AND $lat + $actual_distance
                  AND lng_d BETWEEN $lng - $actual_distance AND $lng + $actual_distance
                  AND ( created_at BETWEEN (NOW() - INTERVAL 2 DAY) AND NOW() )
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
          created_at_long, created_at, updated_at,
          count_comments(id) number_of_comments
          FROM events
          WHERE soft_delete=0 AND event_type_index IN ($event_filter) AND
          created_at BETWEEN (NOW() - INTERVAL 2 DAY) AND NOW()
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
          created_at_long, created_at, updated_at,
          count_comments(id) number_of_comments
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
