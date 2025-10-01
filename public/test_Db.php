<?php
require_once '../app/Core/Database.php';

try {
    $db = new Database();
    echo "<h3>✅ Database connection successful!</h3>";
} catch (Throwable $e) {
    echo "<h3>❌ Connection failed:</h3> " . $e->getMessage();
}
