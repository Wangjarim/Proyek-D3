<?php
require 'function.php';

if (isset($_POST["regis"])) {
    if (register($_POST) > 0) {
        echo
        "<script>
            alert('Akun berhasil terbuat');
            window.location.href = 'login.php'
        </script>";
    } else {
        echo "
            <script>
                alert('Akun gagal terbuat');
            </script>;
        ";
        echo mysqli_error($connect);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="assets/css/log.css">
</head>

<body>
    <div class="wrapper">
        <div class="card-switch">
            <label class="switch">
                <div class="flip-card__inner">
                    <div class="title-regis title">
                        <a>Klinik Pratama Muhammadiyah Sukajadi</a>
                    </div>
                    <div class="flip-card__front">
                        <div class="title">Sign up</div>
                        <form class="flip-card__form" action="" method="POST">
                            <input class="flip-card__input" placeholder="Full Name" type="name" name="name" required>
                            <input class="flip-card__input" name="username" placeholder="Username" type="text" required>
                            <input class="flip-card__input" name="password" placeholder="Password" type="password" required>
                            <input class="flip-card__input" name="confirm" placeholder="Confirm Password" type="password" required>
                            <div class="">
                                <button class="flip-card__btn r" name="regis">Register</button>
                                <button class="flip-card__btn l" onclick="return window.location.href = 'login.php'">Login</button>
                            </div>
                        </form>
                    </div>
                    <div class="flip-card__back">

                    </div>
                </div>
            </label>
        </div>
    </div>
</body>

</html>