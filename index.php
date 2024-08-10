<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel='stylesheet' href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'>
    <link rel='stylesheet' href='https://fonts.googleapis.com/css2?family=Poppins&amp;display=swap'>
    <link rel="stylesheet" href="assets/css/login.css">
</head>

<body>
    <div class="wrapper">
        <div class="login_box">
            <div class="login-header">
                <span>Login</span>
            </div>
            <form action="config/auth.php" method="post">
                <div class="input_box">
                    <input type="text" id="username" name="username" class="input-field" required>
                    <label for="username" class="label">Username</label>
                    <i class="bx bx-user icon"></i>
                </div>
                <div class="input_box">
                    <input type="password" id="password" name="password" class="input-field" required>
                    <label for="password" class="label">Password</label>
                    <i class="bx bx-show icon toggle-password" id="togglePassword"></i>
                </div>
                <div class="input_box">
                    <input type="submit" class="input-submit" value="Login">
                </div>
            </form>
        </div>
    </div>
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function(e) {
            // Toggle the type attribute using getAttribute() method
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // Toggle the icon class
            this.classList.toggle('bx-show');
            this.classList.toggle('bx-hide');
        });
    </script>
</body>

</html>