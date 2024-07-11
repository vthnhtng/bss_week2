<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link rel="stylesheet" href="../public/stylesheets/login/new.css"">
</head>

<body>
    <div class="container">
        <span class="title">SOIOT SYSTEM</span>
        <form action="?controller=login&action=create" method="POST">
            <input type="text" id="username" name="username" placeholder="username"><br>
            <input type="password" id="password" name="password" placeholder="password"><br>
            <?php
            if ($error) {
                echo '<span class="alert">'.$error.'</span>';
            }
            ?>
            <div class="submitDiv">
                <button id="loginBtn" type="submit">LOGIN</button>
                <a href="#">or create new account</a>
            </div>
        </form>
    </div>
</body>

</html>