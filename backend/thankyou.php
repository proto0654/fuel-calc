<?php

// Set content type to HTML
header('Content-Type: text/html; charset=UTF-8');

// Start session to retrieve potential session data (if we decide to use it later)
session_start();

$formData = [];
if (isset($_GET['data'])) {
    // Decode the URL-encoded JSON data
    $formData = json_decode(urldecode($_GET['data']), true);
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Спасибо за заявку!</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; max-width: 800px; margin: 30px auto; padding: 20px; background: #f9f9f9; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #28a745; border-bottom: 2px solid #eee; padding-bottom: 10px; margin-bottom: 20px; }
        h2 { color: #0056b3; margin-top: 25px; margin-bottom: 15px; }
        ul { list-style: none; padding: 0; }
        li { background: #e9ecef; margin-bottom: 8px; padding: 10px 15px; border-radius: 4px; display: flex; justify-content: space-between; align-items: center; }
        li strong { color: #555; margin-right: 10px; }
        .back-button { display: inline-block; background-color: #007bff; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; margin-top: 20px; }
        .back-button:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <h1>Спасибо! Ваша заявка успешно отправлена.</h1>
    <p>Мы свяжемся с вами в ближайшее время.</p>

    <?php if (!empty($formData)): ?>
        <h2>Отправленные данные:</h2>
        <ul>
            <?php foreach ($formData as $key => $value): ?>
                <li>
                    <strong><?php echo htmlspecialchars(ucfirst($key)); ?>:</strong> 
                    <?php 
                        if (is_array($value)) {
                            echo htmlspecialchars(implode(', ', $value));
                        } else {
                            echo htmlspecialchars($value);
                        }
                    ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>К сожалению, данные не были получены или отображены.</p>
    <?php endif; ?>

    <a href="/test-task-calc-ajax/" class="back-button">Вернуться на главную</a>
</body>
</html> 