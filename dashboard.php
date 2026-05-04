<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Platform - Басты бет</title>
    <link rel="stylesheet" href="style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="dashboard-body">

    <nav class="top-navbar">
        <div class="nav-left">
            <a href="#"><i class="fa-solid fa-sliders"></i></a>
            <a href="#"><i class="fa-solid fa-pen"></i></a>
            <a href="#"><i class="fa-solid fa-house"></i> Басты бет</a>
            <a href="#"><i class="fa-solid fa-calendar-days"></i> Ескерту</a>
        </div>
        
        <div class="nav-right">
            <div class="profile-dropdown">
                <button class="profile-btn" onclick="toggleDropdown()">
                    <i class="fa-solid fa-user-circle"></i> Admin <i class="fa-solid fa-caret-down"></i>
                </button>
                <div class="dropdown-content" id="myDropdown">
                    <a href="#"><i class="fa-solid fa-gear"></i> Профиль</a>
                    <a href="#"><i class="fa-solid fa-key"></i> Іске қосу</a>
                    <a href="#"><i class="fa-solid fa-book"></i> Домашние задания</a>
                    <a href="logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Шығу</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="dashboard-hero">
        <div class="logo-section">
            <div class="logo-icon"><i class="fa-solid fa-lightbulb"></i> <i class="fa-solid fa-brain"></i></div>
            <h1 class="logo-text">Online Platform</h1>
            <p class="logo-desc">Курс сабақтарыңызды жүргізуге<br>арналған!</p>
        </div>
    </div>

    <div class="main-content">
        <div class="breadcrumbs">
            <i class="fa-solid fa-house"></i> Басты бет <span class="arrow">&gt;</span> <i class="fa-solid fa-newspaper"></i> Жаңалықтар
        </div>
        
        <hr class="divider">

        <div class="warning-container">
            <div class="warning-box">
                <h4>Ескерту!!!</h4>
                <p>
                    Құрметті біздің платформамыздың қолданушысы, сізді сайтта көргенімізге қуаныштымыз. Бұл 
                    платформаға кіру үшін сізге жеке <strong>ЛОГИН</strong> және <strong>ПАРОЛЬ</strong> беріледі. 
                    Сол арқылы сабақтарды қарай аласыз. Бір логин, пароль тек бір қолданушыға арналған. 
                    Сондықтан логин, пароліңізді басқа адамдарға таратпауыңызды сұраймыз.
                </p>
                <p class="danger-text">
                    Бір логин парольмен бірнеше адам кірсе сізді автоматты түрде бұғаттап тастайды. 
                    Кейін қайта сатып алу керек болады!
                </p>
            </div>
        </div>
    </div>

    <script>
        function toggleDropdown() {
            document.getElementById("myDropdown").classList.toggle("show");
        }
        window.onclick = function(event) {
            if (!event.target.matches('.profile-btn') && !event.target.closest('.profile-btn')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    </script>
</body>
</html>