<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/vendor/autoload.php';
use App\core\Database;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$config = [
    'db' => [
        'dsn'      => $_ENV['DB_DSN'] ?? '',
        'user'     => $_ENV['DB_USER'] ?? '',
        'password' => $_ENV['DB_PASSWORD'] ?? '',
    ]
];

try {
    $db = new Database($config['db']);
    $stmt = $db->prepare('SELECT * FROM Member WHERE Role = "User"');
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h2>Users from Database:</h2>";
    echo "<pre>";
    var_dump($users);
    echo "</pre>";
    
    if (empty($users)) {
        echo "<p style='color: red;'>No users found! Check if data exists in database.</p>";
    } else {
        echo "<p style='color: green;'>Found " . count($users) . " users</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>
