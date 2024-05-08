<?php include 'db.php'; ?>
<!DOCTOTYPE html>
<html lang="en">
    <head>
        <title>Track Eye</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="login.css">
    </head>

    <body>
        <header>
            <h2 class="logo">Track Eye</h2>
        </header>
        <main>
            <div class="wrapper">
                <form action="">
					<h1>Login</h1>
                        <div class="input-box">
                            <input type="email" placeholder="mail" required>
                            <i class='bx bxs-envelope' ></i>
                        </div>
                        <div class="input-box">
                            <input type="password" placeholder="Password" required>
                            <i class='bx bxs-lock-alt'></i>
                        </div>
                        <div class="remember-forgot">
                            
                            <a href="forgot_password.html">Forgot password</a>
                        </div>

                        <button type="submit" class="btn">Login</button>
                </form>   
            </div>
        </main>
        <footer>
            <!-- place footer here -->
        </footer>
        <!-- Bootstrap JavaScript Libraries -->
        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>

        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous">
        </script>

        <script src="script.js"></script>
    </body>
</html>
