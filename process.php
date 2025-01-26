<?php
function validateEnglishInput($input, $allowedCharacters) {
    $pattern = '/^[a-zA-Z0-9\s' . preg_quote($allowedCharacters, '/') . ']*$/';
    return preg_match($pattern, $input);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'validate') {
    $allowedSymbols = "!\"#$%&'()*+,-./:;<=>?@[\\]^_`{|}~";
    $input = $_POST['input'] ?? '';
    if (validateEnglishInput($input, $allowedSymbols)) {
        $data = ['input' => $input];
        file_put_contents('data.json', json_encode($data, JSON_PRETTY_PRINT));
        echo json_encode(['message' => 'Form submitted successfully!']);
    } else {
        echo json_encode(['message' => 'Only English letters, numbers, spaces, and allowed symbols are permitted.']);
    }
}
?>