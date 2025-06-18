<?php
include 'db_connect.php';

$project_id = $_GET['id'];
$conn->query("DELETE FROM projects WHERE id = $project_id");

header("Location: projects.php");
?>