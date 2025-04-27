<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['num1'], $_GET['num2'], $_GET['operator'])) {
    $num1 = (float)$_GET['num1'];
    $num2 = (float)$_GET['num2'];
    $operator = $_GET['operator'];
    $result = null;

    switch ($operator) {
        case 'add':
            $result = $num1 + $num2;
            $operation = "$num1 + $num2 = $result";
            break;
        case 'subtract':
            $result = $num1 - $num2;
            $operation = "$num1 - $num2 = $result";
            break;
        case 'multiply':
            $result = $num1 * $num2;
            $operation = "$num1 × $num2 = $result";
            break;
        case 'divide':
            if ($num2 != 0) {
                $result = $num1 / $num2;
                $operation = "$num1 ÷ $num2 = $result";
            } else {
                $result = 'Error (Division by zero)';
                $operation = "Division by zero error";
            }
            break;
        case 'percent':
            $result = ($num1 / 100) * $num2;
            $operation = "$num1% of $num2 = $result";
            break;
        case 'exponent':
            $result = pow($num1, $num2);
            $operation = "$num1 ^ $num2 = $result";
            break;
        default:
            $result = 'Invalid operation';
            $operation = "Invalid operation";
    }

    if (!isset($_SESSION['history'])) {
        $_SESSION['history'] = [];
    }

    if ($result !== null && $result !== 'Error (Division by zero)') {
        $_SESSION['history'][] = $operation;
    }

    echo json_encode(['result' => $result, 'history' => $_SESSION['history']]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clear'])) {
    $_SESSION['history'] = [];
    echo json_encode(['history' => []]);
    exit;
}
?>
