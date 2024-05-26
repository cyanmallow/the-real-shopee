<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in</title>
    <link rel="stylesheet" href="/the-real-shopee/sites/signin.css">
    <link rel="stylesheet" href="https://unpkg.com/mvp.css"> 
</head>
<body>
    <div id="container">
        <div class="upper-bar">
            <div class="logo">
                <a href="index.php">
                    <img src="/the-real-shopee/pictures/logo-white.png" alt="logo" height="200px" width="200px">
                </a>          
            </div>
        </div>

        <div class="login">
            <form action="process-signup.php" class="add-field" method="POST">
                <label for="username">Username: </label><br>
                <input type="text" maxlength="50" name="username"><br>
    
                <label for="password">Password: </label><br>
                <input type="password" maxlength="225" name="password"><br>

                <input type="submit" value="Sign in">

            </form>
            No accounts yet?  <a href="signup.php">Sign up</a> now!
        
        </div>

        
    </div>

</body>
</html>