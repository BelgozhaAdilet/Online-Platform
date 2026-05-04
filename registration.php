<?php
session_start();

$conn = new mysqli("localhost", "root", "", "your_db_name");
$conn->set_charset("utf8");

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST["username"];
    $password = $_POST["password"];

    if ($username == "" || $password == "") {
        $error = "Заполните это поле.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Бұл логин бұрыннан бар.";
        } else {
            $stmt2 = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt2->bind_param("ss", $username, $password);

            if ($stmt2->execute()) {
                $success = "Тіркелгеніңіз үшін рахмет!";
            } else {
                $error = "Қате кетті.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Platform - Тіркелу</title>
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
            <a href="login.php" class="tab-btn"><i class="fa-solid fa-sign-in-alt"></i> Кіру</a>
            <a href="registration.php" class="tab-btn active"><i class="fa-solid fa-user"></i> Тіркелу</a>
        </div>

        <div class="auth-box">
            <form method="POST" id="form" class="auth-form">
                <?php if($error) echo "<div class='alert-error'>$error</div>"; ?>
                <?php if($success) echo "<div class='alert-success'>$success <a href='login.php' style='color:#065f46; text-decoration:underline;'>Кіру</a></div>"; ?>

                <div class="input-group">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="username" placeholder="Қалаған логин" required>
                </div>
                <div class="input-group">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password" placeholder="Қажетті пароль" required>
                </div>
                
                <div class="input-group">
                    <i class="fa-solid fa-key"></i>
                    <input type="text" id="access-code" placeholder="Кіру коды" required>
                </div>

                <button type="submit" id="btn" class="submit-btn">ТІРКЕЛУ</button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("form");
    const btn = document.getElementById("btn");
    const accessCodeInput = document.getElementById("access-code");
    
    const allowedCodes = ["5000", "5250", "5500", "5750", "6000", "6250", "6500", "6700", "6950"];

    const errorMessage = document.createElement('span');
    errorMessage.innerText = "Кіру коды қате!";
    errorMessage.style.color = "#ef4444"; 
    errorMessage.style.fontSize = "12px";
    errorMessage.style.fontWeight = "bold";
    errorMessage.style.display = "none"; 
    errorMessage.style.position = "absolute";
    errorMessage.style.bottom = "-20px"; 
    errorMessage.style.left = "0";

    accessCodeInput.parentElement.appendChild(errorMessage);

    form.addEventListener("submit", function(event){
        
        const enteredCode = accessCodeInput.value.trim();

        if (!allowedCodes.includes(enteredCode)) {
           
            event.preventDefault(); 
            
            errorMessage.style.display = "block";
            accessCodeInput.style.borderColor = "#ef4444"; 
            
            
            setTimeout(() => {
                errorMessage.style.display = "none";
                accessCodeInput.style.borderColor = "#d1d5db";
            }, 3000);

        } else {
          
            errorMessage.style.display = "none";
            accessCodeInput.style.borderColor = "#10b981"; 
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Тексеру...';
        }
    });
});
</script>

</body>
</html>