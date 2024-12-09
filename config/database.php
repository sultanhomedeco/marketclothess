<?php
require_once __DIR__ . '/../vendor/autoload.php';

use MongoDB\Client;

try {
    $client = new Client("mongodb://localhost:27017");
    $db = $client->marketclothes; // Nama database
} catch (Exception $e) {
    die("Error connecting to MongoDB: " . $e->getMessage());
}
