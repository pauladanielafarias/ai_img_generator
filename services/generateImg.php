<?php

include '../helpers/logger.php';

require_once '../config/config.php';

// Check if the request is POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $error_msg="Error: Method Not Allowed. Only POST requests are allowed.";

    $logger->error($error_msg);

    http_response_code(405);
    echo $error_msg;

    exit;
}

// Validate and sanitize the input
$inputJSON = file_get_contents('php://input');
$inputData = json_decode($inputJSON, true);

if (!isset($inputData['prompt']) || empty($inputData['prompt']) || strlen($inputData['prompt']) > 1000) {
    $error_msg = "Error: Invalid or missing prompt. Prompt must be a non-empty string with a maximum length of 1000 characters.";
    
    $logger->error($error_msg);

    http_response_code(400);
    echo $error_msg;
    exit;
}

$prompt =  $inputData['prompt'];

// Sanitize other input fields if necessary
$style = isset($inputData['style']) ? $inputData['style'] : 'vivid';
$size = isset($inputData['size']) ? $inputData['size'] : '1024x1024';
$quality = isset($inputData['quality']) ? $inputData['quality'] : 'standard';

// User ID for tracking purposes
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$sessionId = session_id();
$user = strval($sessionId);

// Data for the request to OpenAI API
$data = array(
    'model' => 'dall-e-3',
    'prompt' => $prompt,
    'n' => 1,
    'style' => $style,
    'size' => $size,
    'quality' => $quality,
    'user' => $user
);

$logger->info('Request data to send to OpenAI API: ', $data);

// Convert data to JSON format
$jsonData = json_encode($data);

// Set HTTP headers
$headers = array(
    'Content-Type: application/json',
    'Authorization: Bearer ' . $OPENAI_APIKEY
);

// Set stream context options
$contextOptions = array(
    'http' => array(
        'method' => 'POST',
        'header' => implode("\r\n", $headers),
        'content' => $jsonData
    )
);

// Create stream context
$context = stream_context_create($contextOptions);

// Send request to OpenAI API
$response = file_get_contents($OPENAI_API_URL, false, $context);

$logger->info('Response from OpenAI API: ', array('response' => $response));

// Check for errors in response
if ($response === false) {
    echo "Error in server: Unable to make request to OpenAI API.";
    http_response_code(500); // Internal Server Error
    exit;
}

// Handle response
$responseData = json_decode($response, true);

// Check for errors in response data
if (isset($responseData['error'])) {
    $error_msg = "Error in server: " . $responseData['error']['message'];

    $logger->error($error_msg);

    echo $error_msg;
    http_response_code(500); // Internal Server Error
    exit;
}

// Send the image URL back to the client
$imageURL = $responseData['data'][0]['url'] ? $responseData['data'][0]['url'] : '';
$realPrompt = $responseData['data'][0]['revised_prompt'] ? $responseData['data'][0]['revised_prompt'] : '';

echo json_encode(array(
    'imageUrl' => $imageURL,
    'realPrompt' => $realPrompt,
    'user' => $user,
));
http_response_code(200);

?>