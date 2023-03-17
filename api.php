<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the filename from the form input
    $filename = $_POST['filename'];

    // Set the purchase code and domain values
    $purchase_code = '';
    $domain = '';

    // URL of the API endpoint with the filename, purchase code, and domain parameters
    $url = "https://jnews.io//wp-json/jnews-server/v1/getJNewsData?domain={$domain}&purchase_code={$purchase_code}&name={$filename}&type=plugin";

    // Open a file pointer to the zip file
    $fp = fopen($filename, 'w');

    // Initialize a cURL session
    $ch = curl_init();

    // Set the cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FILE, $fp);

    // Execute the cURL request
    curl_exec($ch);

    // Close the file pointer and cURL session
    fclose($fp);
    curl_close($ch);

    // Set the appropriate headers to force the browser to download the file
    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Content-Length: ' . filesize($filename));

    // Stream the file to the browser
    readfile($filename);

    // Delete the file from the server
    unlink($filename);
}
?>
