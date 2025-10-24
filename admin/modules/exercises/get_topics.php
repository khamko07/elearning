<?php
require_once ("../../../include/initialize.php");

if (!isset($_SESSION['USERID'])){
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

header('Content-Type: application/json');

$categoryId = isset($_GET['categoryId']) ? (int)$_GET['categoryId'] : 0;

if ($categoryId <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid category ID']);
    exit;
}

$sql = "SELECT TopicID, TopicName FROM tbltopics WHERE CategoryID = {$categoryId} AND IsActive = 1 ORDER BY TopicName";
$mydb->setQuery($sql);
$topics = $mydb->loadResultList();

echo json_encode(['success' => true, 'topics' => $topics]);
?>