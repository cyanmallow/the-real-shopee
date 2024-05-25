// default: show 1st slide
let slideIndex = 1;
showSlide(slideIndex);

// next/prev controls
function plusSlide(n){
    showSlide(slideIndex += n);
}

// change current slide
function currentSlide(n){
    showSlide(slideIndex = n);
}

function showSlide(n){
    let slides = document.getElementsByClassName('slide');
    let dots = document.getElementsByClassName("dot");

    // this part loads very slow
    if (n > slides.length) {
        slideIndex = 1;
    }

    if (n < 1) {
        slideIndex = slides.length;
    }

    for (let i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
    }

    for (let i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
    }

    slides[slideIndex-1].style.display = "block";
    dots[slideIndex-1].className += " active";

    changeSlideAutomatically();
}

function changeSlideAutomatically(){
    setTimeout(() => {
        plusSlide(1);
    }, 2000);
}

function fetchCategoryItems(category){
    $.ajax({
        url: 'fetch-items.php',
        type: 'POST',
        data: { category: category},
        success:function(data){
            $('#category-items').html(data);
        }
    });
}

// hightlight the selected category
const selectedCategory = () => {
    const categoryElement = document.querySelectorAll('.category');
    const categoryToHighlight = document.getElementById('item_id');

    categoryElement.forEach((item) => {
        item.removeAttribute("aria-current");
    });
    if (categoryToHighlight){
        categoryToHighlight.setAttribute('aria-current', 'true');
    }
};

// const cartButton = document.getElementById('cart');
// cartButton.addEventListener('click', openCart);

// const openCart = () => {
//     //TODO: once click, open cart
// }

