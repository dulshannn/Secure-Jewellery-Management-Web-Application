<?php
// api/ai_generate.php

// 1. SAFETY: Turn off visible errors so they don't break the JSON response
error_reporting(0); 
ini_set('display_errors', 0);

// 2. SAFETY: Set Headers to allow connection from your frontend
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

// Handle Preflight (Browser Security Check)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// 3. SAFETY: Initialize Database in "Try Mode"
$db = null;
$db_path = __DIR__ . '/../db_pg.php';

if (file_exists($db_path)) {
    include $db_path; // Tries to connect
}

// Check if connection worked. If not, we run in "Offline Mode"
$is_db_active = ($db !== null && pg_connection_status($db) === PGSQL_CONNECTION_OK);


// 4. MAIN LOGIC
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // SAFETY: Read input safely
    $inputJSON = file_get_contents("php://input");
    $input = json_decode($inputJSON, true);
    
    // SAFETY: Sanitize the prompt to prevent bad scripts
    $raw_prompt = $input['prompt'] ?? '';
    $prompt = htmlspecialchars(strtolower(trim($raw_prompt))); 

    if (empty($prompt)) {
        echo json_encode(["status" => "error", "message" => "Prompt cannot be empty."]);
        exit;
    }

    // --- SIMULATION LOGIC (Guaranteed to work) ---
    // This allows your presentation to succeed even without internet/API keys.
    
    // 1. Fake the "Thinking" delay (Cinematic feel)
    sleep(2);

    // 2. Mock Image Database (High Quality Assets)
    $mock_images = [
        'ring' => 'https://cdn.pixabay.com/photo/2014/11/05/16/00/gold-518118_1280.jpg',
        'necklace' => 'https://cdn.pixabay.com/photo/2015/09/03/07/20/necklace-920199_1280.jpg',
        'diamond' => 'https://cdn.pixabay.com/photo/2016/02/02/15/54/jewellery-1175533_1280.jpg',
        'emerald' => 'https://cdn.pixabay.com/photo/2017/08/07/11/04/sapphire-2602700_1280.jpg',
        'vintage' => 'https://cdn.pixabay.com/photo/2016/11/19/11/32/jewellery-1839016_1280.jpg',
        'default' => 'https://cdn.pixabay.com/photo/2017/01/17/02/09/gold-1985860_1280.jpg'
    ];

    // 3. Intelligent Keyword Matching
    $imageUrl = $mock_images['default'];
    if (strpos($prompt, 'necklace') !== false) $imageUrl = $mock_images['necklace'];
    if (strpos($prompt, 'ring') !== false) $imageUrl = $mock_images['ring'];
    if (strpos($prompt, 'diamond') !== false) $imageUrl = $mock_images['diamond'];
    if (strpos($prompt, 'emerald') !== false) $imageUrl = $mock_images['emerald'];
    if (strpos($prompt, 'vintage') !== false) $imageUrl = $mock_images['vintage'];


    // 5. SAFETY: Database Save (Only if DB is active)
    if ($is_db_active) {
        // Use try-catch so database errors don't stop the image from showing
        try {
            $query = "INSERT INTO custom_designs (user_id, prompt_text, generated_image_path) VALUES ($1, $2, $3)";
            // Assuming User ID 1 for guests if no session exists
            @pg_query_params($db, $query, [1, $prompt, $imageUrl]);
        } catch (Exception $e) {
            // Do nothing, just log it internally. The user still gets their image.
            error_log("DB Save Failed: " . $e->getMessage());
        }
    }

    // 6. Return Success Response
    echo json_encode([
        "status" => "success",
        "message" => "Design Generated Successfully",
        "image_url" => $imageUrl,
        "mode" => $is_db_active ? "online" : "offline_demo"
    ]);

} else {
    echo json_encode(["status" => "error", "message" => "Invalid Request Method"]);
}
?>