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
?>
