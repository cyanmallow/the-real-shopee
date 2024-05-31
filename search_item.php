<?php
    echo "<link rel='stylesheet' href='/the-real-shopee/sites/flex.css'>";

    // add flex
    echo "<div class='flex-container'>";
    echo "<div class='flex-name'>" . $item["item_name"] . "</div>";
    echo "<div class='flex-price'>₫ " . $item["price"] . "</div>";
    echo "<div class='flex-quality'>Only " . $item["quantity"] . " left!! Get yours today!</div>";
    echo "<div class='flex-img'><img src='" . $item["image_url"] . "' alt='Image of " . $item["item_name"] . "'></div>";
?>