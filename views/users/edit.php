<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDIT PROFILE</title>
    <link rel="stylesheet" href="../public/stylesheets/users/edit.css"">
</head>

<body>
    <div class="container">
    <span class="title">UPDATE USER AVATAR</span>
    <form action="?controller=users&action=update" method="post" enctype="multipart/form-data">
        <input type="hidden" name="userId" value=<?php session_start();
                                                    echo $_SESSION['userId'] ?>>
        <div class="avatar">
            <label>Upload user avatar</label>
            <input type="file" name="image">
        </div>

        <?php if (isset($_GET['error'])) : ?>
            <p><?php echo $_GET['error']; ?></p>
        <?php endif ?>
        <div class="submitDiv">
            <button id="updateBtn" type="submit">UPDATE</button>
        </div>
        <a href="?controller=login&action=destroy">LOGOUT</a>
    </form>
    </div>
    </body>

</html>