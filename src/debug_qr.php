<?php
// Temporary debug script - DELETE AFTER USE
include 'config/config.php';

$identifier = $_GET['id'] ?? 'Jn7obvS';

$db = getDbInstance();
$db->where("identifier", $identifier);
$qrcode = $db->getOne("dynamic_qrcodes");

header('Content-Type: application/json');

if ($qrcode) {
    echo json_encode([
        'found' => true,
        'id' => $qrcode['id'],
        'identifier' => $qrcode['identifier'],
        'link' => $qrcode['link'],
        'state' => $qrcode['state'],
        'filename' => $qrcode['filename'],
        'scan_count' => $qrcode['scan'] ?? 0,
        'created_at' => $qrcode['created_at'] ?? null,
        'updated_at' => $qrcode['updated_at'] ?? null,
    ], JSON_PRETTY_PRINT);
} else {
    echo json_encode([
        'found' => false,
        'error' => 'QR code not found with identifier: ' . $identifier
    ], JSON_PRETTY_PRINT);
}

