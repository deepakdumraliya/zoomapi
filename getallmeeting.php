<?php
require_once 'class-db.php';
$db = new DB;

$res = $db->get_meeting();
$row = $res->fetch_assoc();
$data = array();
while ($dt = $res->fetch_assoc()) {
    array_push($data, $dt);
}
echo json_encode($data);
