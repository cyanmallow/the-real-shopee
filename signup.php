<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link rel="stylesheet" href="/the-real-shopee/sites/signin.css">
</head>
<body>
    <div id="container">
        <div class="upper-bar">
            <div class="logo">
                <a href="index.html">
                    <img src="/the-real-shopee/pictures/logo-white.png" alt="logo" height="200px" width="200px">
                </a>            
            </div>
        </div>

        <div class="login">
            <form action="add-item.php" class="add-field">
                <label for="username">Username: </label><br>
                <input type="text" maxlength="50"><br>
    
                <label for="password">Password: </label><br>
                <input type="text" maxlength="225"><br>

                <label for="password">Repeat password: </label><br>
                <input type="text" maxlength="225"><br>
                <!-- check xem co giong password ko -->
    
                <input type="submit" value="Sign up">

            </form>
            Already have an account?  <a href="signin.php">Sign in</a> now!
        
        </div>

        <div class="contact">
            <table>
                <tr>
                    <th>Follow us</th>
                    <th>Contact us</th>
                    <th>Policy</th>
                </tr>
                <tr>
                    <td><a href="https://github.com/cyanmallow">Github</a></td>
                    <td>ggmmallow@gmail.com</td>
                    <td>Terms & Conditions</td>
                </tr>
                <tr>
                    <td><a href="https://x.com/MostimaGinger">X</a></td>
                    <td><a href="https://www.facebook.com/moscult/">Facebook</a></td>
                    <td>Shipping Policy</td>

                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>Exchange and Return</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>VAT Policy</td>
                </tr>
            </table>
        </div>
    </div>

</body>
</html>