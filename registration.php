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
                $error = "Қате кілт.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="kk">
<head>
<meta charset="UTF-8">
<title>Тіркелу</title>
</head>

<body>

<h2>Тіркелу</h2>

<?php if($error) echo "<p style='color:red;'>$error</p>"; ?>
<?php if($success) echo "<p style='color:green;'>$success</p>"; ?>

<form method="POST" id="form">

    <input type="text" name="username" placeholder="Логин"><br><br>
    <input type="password" name="password" placeholder="Пароль"><br><br>

    <button id="btn">ТІРКЕЛУ</button>

</form>

<script>
document.getElementById("form").addEventListener("submit", function(){
    document.getElementById("btn").innerText = "Тексеру...";
});
</script>

</body>
</html>