<?php
session_start();
include("connection.php");

// Initialize $error_message and $username
$error_message = "";
$username = "";

// Fungsi login
if (isset($_POST["submit"])) {
    $username = htmlentities(strip_tags(trim($_POST["username"])));
    $password = htmlentities(strip_tags(trim($_POST["password"])));

    if (empty($username)) {
        $error_message .= "- Username belum diisi <br>";
    }

    if (empty($password)) {
        $error_message .= "- Password belum diisi <br>";
    }

    // Check admin credentials
    $admin_username = "admin";
    $admin_password = "admin123";

    if ($username === $admin_username && $password === $admin_password) {
        // Simpan role admin dalam sesi   
        $_SESSION["role"] = 'admin';
        header("Location: admin.php");
        exit();
    } else {
        // Check regular user credentials in the database using prepared statement
        $query = "SELECT * FROM users WHERE username = ?";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            // Jika data ditemukan, ambil rolenya dan kata sandi
            $stmt->bind_result($user_id, $db_username, $db_password, $userRole);
            $stmt->fetch();

            // Verifikasi kata sandi menggunakan password_verify
            if (password_verify($password, $db_password)) {
                // Simpan role user dalam sesi   
                $_SESSION["role"] = $userRole;
                $_SESSION["id"] = $user_id;

                if ($userRole === 'admin') {
                    header("Location: admin.php");
                    exit();
                } elseif ($userRole === 'user') {
                    header("Location: index2.php");
                    exit();
                }
            } else {
                $error_message .= "- Username dan/atau Password tidak sesuai";
            }
        } else {
            $error_message .= "- Username dan/atau Password tidak sesuai";
        }

        mysqli_stmt_close($stmt);
    }
}

// Redirect to signup page
if (isset($_POST["signup"])) {
    header("Location: signup.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <div class="container">
        <?php
        if ($error_message !== "") {
            echo "<div class='error'>$error_message</div>";
        }
        ?>
        <form action="login.php" method="post">
            <fieldset>
                <legend>Login</legend>
                <p>
                    <label for="username">Username : </label>
                    <input type="text" name="username" id="username" value="<?php echo $username ?>">
                </p>
                <p>
                    <label for="password">Password : </label>
                    <input type="password" name="password" id="password" value="<?php echo $password ?>">
                </p>
                <p>
                    <input type="submit" name="submit" value="Log In">
                </p>
                <!-- Add a link/button for redirection -->
                <p>
                    <a href="index2.php">Kembali Ke Home</a>
                </p>
            </fieldset>
        </form>

        <form action="login.php" method="post">
            <fieldset>
                <legend>Sign Up</legend>
                <p>
                    <input type="submit" name="signup" value="Sign Up">
                </p>
            </fieldset>
        </form>
    </div>
</body>

</html>
