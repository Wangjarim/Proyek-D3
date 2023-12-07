<?php
$connect = mysqli_connect("localhost", "root", "", "klinik_sukajadi");

function query($query)
{
    global $connect;
    $result = mysqli_query($connect, $query);
    $row = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function register($data)
{
    global $connect;


    $fullname = mysqli_real_escape_string($connect, $data['name']);
    $username = stripslashes($data["username"]);
    $password = mysqli_real_escape_string($connect, $data["password"]);
    $confirm = mysqli_real_escape_string($connect, $data["confirm"]);
    $username_sama = mysqli_query($connect, "SELECT username FROM users WHERE username = '$username'");


    if (mysqli_fetch_assoc($username_sama)) {
        echo "<script>
                    alert('Username yang dipilih sudah terdaftar')
                </script>";
        return false;
    }



    if ($confirm !== $password) {
        echo "<script>
                    alert('Password tidak sama')
                </script>";
        return false;
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);

    mysqli_query($connect, "INSERT INTO users VALUES('','$fullname' ,'$username', '$hash', 'pelanggan')");

    return mysqli_affected_rows($connect);
}
