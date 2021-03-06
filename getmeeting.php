<?php
require_once 'class-db.php';
$db = new DB;
$id = $_POST['id'];
$res = $db->get_meeting_by_id($id);
$row = $res->fetch_assoc();
echo json_encode($row);
