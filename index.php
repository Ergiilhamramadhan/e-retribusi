<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login E-Retribusi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
    <link rel="stylesheet" href="assets/style.css">

    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <!-- Tambahin ini di <head> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

</body>

<body class="login-page-modern">

    <div class="login-container">

        <!-- LOGO -->
        <div class="logo-circle">
            E
        </div>

        <h2 class="title">E-RETRIBUSI</h2>

        <!-- FORM -->
        <form action="login_proses.php" method="POST">

            <div class="input-box">
                <i class="fa fa-user"></i>
                <input type="text" name="username" required>
                <label>Username</label>
            </div>

            <div class="input-box">
                <i class="fa fa-lock"></i>
                <input type="password" name="password" id="password" required>
                <label>Password</label>
                <i class="fa fa-eye toggle-password" onclick="togglePassword()"></i>
            </div>

            <button type="submit">Log In</button>

        </form>

    </div>

    <script>
        function togglePassword() {
            const password = document.getElementById("password");
            const icon = document.querySelector(".toggle-password");

            if (password.type === "password") {
                password.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                password.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>

</body>
</html>