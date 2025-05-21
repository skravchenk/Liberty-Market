<?php
session_start();
ob_start();

require_once 'Database.php';
require_once 'User.php';

function clean_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

$username = $email = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = clean_input($_POST['username'] ?? '');
    $email = clean_input($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username)) $errors['username'] = 'Enter username';
    elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) $errors['username'] = 'Only letters, numbers and underscores allowed';

    if (empty($email)) $errors['email'] = 'Enter email';
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Incorrect email';

    if (empty($password)) $errors['password'] = 'Enter password';
    elseif (strlen($password) < 6) $errors['password'] = 'Password must be at least 6 characters';

    if (empty($errors)) {
        $db = new Database();
        $user = new User($db);

        if ($user->register($username, $email, $password)) {
            $_SESSION['success'] = 'Registration and login successful!';
            ob_end_clean();
            header('Location: index.php');
            exit();
        } else {
            $errors['form'] = 'Username or email already exists.';
        }

        $_SESSION['form_data'] = [];
    } else {
        $_SESSION['form_data'] = [
            'username' => $username,
            'email' => $email
        ];
    }
}

if (isset($_SESSION['form_data'])) {
    $username = $_SESSION['form_data']['username'] ?? '';
    $email = $_SESSION['form_data']['email'] ?? '';
    unset($_SESSION['form_data']);
}

include 'includes/header.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="registration-container">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="success-message"><?= $_SESSION['success'] ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($errors['form'])): ?>
            <div class="error-message"><?= $errors['form'] ?></div>
        <?php endif; ?>

        <h1>SignUp</h1>
        <form method="post">
            <div class="form-group">
                <label>Username:</label>
                <input type="text" name="username" value="<?= htmlspecialchars($username) ?>" required>
                <?php if (isset($errors['username'])): ?>
                    <span class="error"><?= $errors['username'] ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
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

            <button type="submit" class="submit-btn">Register</button>
        </form>
    </div>
</body>
</html>
<?php
ob_end_flush();
?>
