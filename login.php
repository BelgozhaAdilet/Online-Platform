<?php
session_start();

$conn = new mysqli("localhost", "root", "", "your_db_name");
$conn->set_charset("utf8");

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $login = $_POST["login"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($password == $user["password"]) {
            $_SESSION["user"] = $user["username"];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Логин немесе пароль дұрыс емес. Тағы бір рет теріп көріңіз.";
        }
    } else {
        $error = "Логин немесе пароль дұрыс емес. Тағы бір рет теріп көріңіз.";
    }
}
?>

<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Platform - Кіру</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div class="main-container">
    <div class="logo-section">
        <div class="logo-icon"><i class="fa-solid fa-lightbulb"></i> <i class="fa-solid fa-brain"></i></div>
        <h1 class="logo-text">Online Platform</h1>
        <p class="logo-desc">Курс сабақтарыңызды жүргізуге<br>арналған!</p>
    </div>

    <div class="auth-wrapper">
        <div class="tabs">
            <a href="login.php" class="tab-btn active"><i class="fa-solid fa-sign-in-alt"></i> Кіру</a>
            <a href="registration.php" class="tab-btn"><i class="fa-solid fa-user"></i> Тіркелу</a>
        </div>

        <div class="auth-box">
            <form method="POST" id="form" class="auth-form">
                <?php if($error) echo "<div class='alert-error'>$error</div>"; ?>

                <div class="input-group">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="login" placeholder="Логин" required>
                </div>
                <div class="input-group">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password" placeholder="Пароль" required>
                </div>
                
                <div class="form-options">
                    <label class="remember-me"><input type="checkbox"> Мені есте сақтау</label>
                    <a href="#" class="forgot-password">Парольды ұмыттыңыз ба?</a>
                </div>
                
                <button type="submit" id="btn" class="submit-btn">КІРУ</button>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById("form").addEventListener("submit", function(){
    document.getElementById("btn").innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Тексеру...';
});
</script>

</body>
</html>