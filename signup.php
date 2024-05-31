<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
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
            <form action="process-signup.php" method="POST" class="add-field">
                <label for="username">Username: </label><br>
                <input type="text" maxlength="50" name="username"><br>
    
                <label for="password">Password: </label><br>
                <input type="password" maxlength="225" name="password"><br>

                <label for="repeat_password">Repeat password: </label><br>
                <input type="password" maxlength="225" name="repeat_password"><br>
                <!-- check xem co giong password ko -->

                <label for="address">Address: </label><br>
                <input type="text" maxlength="250" name="address"><br>
    
                <button type="submit">Sign up</button>

            </form>
            Already have an account?  <a href="signin.php">Sign in</a> now!
        
        </div>

        
    </div>

</body>
</html>