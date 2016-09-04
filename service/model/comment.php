<?php
function getAll($conn, $event_filter) {
  $comments = [];
  $sql = "SELECT *
          FROM comments
          WHERE soft_delete=0
          ORDER BY id";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $comments[] = $row;
    }
  }
  return $comments;
}

function getCommentsByEventId($conn, $event_id) {
  $comments = [];
  $sql = "SELECT *
          FROM comments
          WHERE event_id=$event_id AND soft_delete=0
          ORDER BY id";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $comments[] = $row;
    }
  }
  return $comments;
}

function getCommentById($conn, $id) {
  $comments = [];
  $sql = "SELECT *
          FROM comments
          WHERE id=$id";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $comments[] = $row;
    }
  }
  return $comments;
}

function createComment($conn, $post_data) {
  $sql = "INSERT INTO events (
            event_id,
            comment,
            user_uid,
            user_name,
            user_photo_url,
            created_at_long, created_at, updated_at )
          VALUES (
            $post_data->event_id,
            '$post_data->comment',
            '$post_data->user_uid',
            '$post_data->user_name',
            '$post_data->user_photo_url',
            $post_data->created_at_long, NOW(), NOW()
          ) ";
  if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
    return $last_id;
  } else {
    echo $conn->error;
    die();
  }

}
?>
