<?php
// Старт сессии ДО любого вывода
session_start();

// Включим буферизацию вывода
ob_start();

// Функция для очистки ввода
function clean_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Инициализация переменных
$username = $email = '';
$errors = [];

// Обработка формы
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = clean_input($_POST['username'] ?? '');
    $email = clean_input($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    // Валидация
    if (empty($username)) $errors['username'] = 'Enter username';
    elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) $errors['username'] = 'Only letters, numbers and underscores allowed';
    
    if (empty($email)) $errors['email'] = 'Enter email';
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Incorrect email';
    
    if (empty($password)) $errors['password'] = 'Enter password';
    elseif (strlen($password) < 6) $errors['password'] = 'Password must be at least 6 characters';
    
    // Если нет ошибок
    if (empty($errors)) {
        $_SESSION['success'] = 'Success!';
        $_SESSION['form_data'] = []; // Очищаем предыдущие данные
        
        // Очищаем буфер и делаем редирект
        ob_end_clean();
        header('Location: '.$_SERVER['PHP_SELF']);
        exit();
    } else {
        // Сохраняем введенные данные для повторного показа
        $_SESSION['form_data'] = [
            'username' => $username,
            'email' => $email
        ];
    }
}

// Получаем сохраненные данные из сессии
if (isset($_SESSION['form_data'])) {
    $username = $_SESSION['form_data']['username'] ?? '';
    $email = $_SESSION['form_data']['email'] ?? '';
    unset($_SESSION['form_data']);
}
include 'header.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="registration-container">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="success-message"><?= $_SESSION['success'] ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        
        <h1>SignUp</h1>
        <form method="post">
            <div class="form-group">
                <label>Username:</label>
                <input type="text" name="username" value="<?= $username ?>" required>
                <?php if (isset($errors['username'])): ?>
                    <span class="error"><?= $errors['username'] ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" value="<?= $email ?>" required>
                <?php if (isset($errors['email'])): ?>
                    <span class="error"><?= $errors['email'] ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" required>
                <?php if (isset($errors['password'])): ?>
                    <span class="error"><?= $errors['password'] ?></span>
                <?php endif; ?>
            </div>
            
            <button type="submit" class="submit-btn">Submit</button>
        </form>
    </div>
</body>
</html>
<?php
// Завершаем буферизацию если не было редиректа
ob_end_flush();
?>