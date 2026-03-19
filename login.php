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
<title>Кіру</title>
</head>

<body>

<h2>Кіру</h2>

<?php if($error) echo "<p style='color:red;'>$error</p>"; ?>

<form method="POST" id="form">

    <input type="text" name="login" placeholder="Логин"><br><br>
    <input type="password" name="password" placeholder="Пароль"><br><br>

    <button id="btn">КІРУ</button>

</form>

<script>
document.getElementById("form").addEventListener("submit", function(){
    document.getElementById("btn").innerText = "Тексеру...";
});
</script>

</body>
</html>