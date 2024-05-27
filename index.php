<?php 
session_start();
// print_r($_SESSION);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy the world today!!</title>
    <link rel="stylesheet" href="/the-real-shopee/sites/styles.css">
    <link rel="stylesheet" href="https://unpkg.com/mvp.css"> 

</head>
<body>
    <!-- <div class="container"> -->
        <div class="upper-bar">
            <div class="logo">
                <a href="index.php">
                    <img src="/the-real-shopee/pictures/logo-white.png" alt="logo" height="150px" style="margin-left: 10px">
                </a>
            </div>
            <div id="search-bar">
                <!-- the damn bar -->
                <input type="text" placeholder="What do you want to buy~">
                <button type="submit">Search</button>
                <!-- trending items -->
            </div>
            <div id="signin-signup">
                <img src="pictures/user_1177568.png" alt="user" id="user">
                <?php if(isset($_SESSION["user_id"])):?>
                    <a href="/the-real-shopee/signout.php" class="user-login">Sign out</a>
                <?php else:?>
                    <a href="/the-real-shopee/signup.php" class="user-login">Sign up</a>
                    <a href="/the-real-shopee/signin.php" class="user-login">Sign in</a>
                <?php endif;?>
                
            </div>
            <div id="shopping-cart">
                <a href="items_in_cart.php">
                    <img src="pictures/trolley_4290854.png" alt="cart" id="cart">
                </a>            
            </div>
        </div>

        <div class="main">

        
            <!-- <a href="/the-real-shopee/signout.php">Sign out</a> -->
        <a href="/the-real-shopee/add-item.php">Debug: Add item for admin</a>

            <div class="image-carousel">
                <div class="slide">
                    <img src="https://img.alicdn.com/imgextra/i2/2206488662066/O1CN01Mn8ppQ1R8H7T3dxD2_!!0-item_pic.jpg" alt="baghook" style="height: 400px;">
                    <div class="text">Arknights – Ambience Synesthesia 2023 – Baghook Faster and Stronger</div>
                </div>
                <div class="slide">
                    <img src="https://img.alicdn.com/imgextra/i1/2206488662066/O1CN01neSJ5s1R8H52RDtS1_!!2206488662066.jpg" alt="bean" style="height: 400px;">
                    <div class="text">40cm Ling Bean</div>
                </div>
                <div class="slide">
                    <img src="https://resize.cdn.otakumode.com/ex/1014.1000/shop/product/a54d99e142d44da99cc8672d399965b2.jpg" alt="Figure" style="height: 400px;">
                    <div class="text">Skadi The Corrupting Heart - Elite II ver. 1/7</div>
                </div>
                <div class="slide">
                    <img src="https://i.ebayimg.com/images/g/t~QAAOSwGJxfxMt8/s-l1200.jpg" alt="pin" style="height: 400px;">
                    <div class="text">Character Metal Pin Set</div>
                </div>                
                <div class="slide">
                    <img src="https://i.ebayimg.com/images/g/4SYAAOSwI7Biw2os/s-l1200.webp" alt="Rabbit" style="height: 400px;">
                    <div class="text">Official Arknights Rhodes Island CH.O3 Amiya Ver. Rabbit Plush Doll 23cm</div>
                </div>                
                <div class="slide">
                    <img src="https://img.alicdn.com/imgextra/i3/2206488662066/O1CN01GkDYEV1R8HAOVBkv7_!!2-item_pic.png" alt="Others" style="height: 400px;">
                    <div class="text">Muelsyse - Umbrella</div>
                </div>

                <!-- next and previous button -->
                <a class="prev" onclick="plusSlide(-1)">&#10094;</a>
                <a class="next" onclick="plusSlide(1)">&#10095;</a>
            </div>

            <!-- dot/circle to switch pic -->
            <div style="text-align: center;">
                <span class="dot" onclick="currentSlide(1)"></span>
                <span class="dot" onclick="currentSlide(2)"></span>
                <span class="dot" onclick="currentSlide(3)"></span>
                <span class="dot" onclick="currentSlide(4)"></span>
                <span class="dot" onclick="currentSlide(5)"></span>
                <span class="dot" onclick="currentSlide(6)"></span>
            </div>

        <!-- category part -->
            <div class="category">
                <button class="all-categories" onclick="fetchCategoryItems('baghook')">Baghook</button>
                <button class="all-categories" onclick="fetchCategoryItems('bean')">Bean</button>
                <button class="all-categories" onclick="fetchCategoryItems('figure')">Figure</button>
                <button class="all-categories" onclick="fetchCategoryItems('metalpin')">Metal Pin</button>
                <button class="all-categories" onclick="fetchCategoryItems('rabbit')">Rabbit</button>
                <button class="all-categories" onclick="fetchCategoryItems('others')">Others</button>
            </div>
            <div class="category-items" id="category-items">
            <!-- move php to fetch-items.php -->
            </div>
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
        <!-- </div> -->
    </div>
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="/the-real-shopee/sites/script.js"></script>
</body>
</html>