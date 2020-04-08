window.addEventListener("resize", function () {
    hide_company();
    if (window.innerWidth > 768) cp.style.left = "0";
});
//Trang chu
function trangchu() {
    location.replace("index.html");
}

//Tim san pham
function search_phone(value) {
    var text_search = document.getElementById("text_search").value.toString();
    var mySearch = document.getElementById("search-results");
    console.log(text_search);
    if (text_search.length > 0) {
        mySearch.style.display = "block";
    } else {
        mySearch.style.display = "none";
    }

}
// Danh sach hang dien thoai
var cp = document.getElementById("company");

function show_company() {
    cp.style.left = "0";

}

function hide_company() {
    cp.style.left = "-200px";
}
// Scroll Top
function scroll_top() {
    var y;
    var myset = setInterval(() => {
        if (pageYOffset > 0) {
            y = pageYOffset - 10;
            window.scrollTo(0, y);
        } else {
            clearInterval(myset);
        }
    }, 1);

}
window.addEventListener('scroll', function () {
    if (pageYOffset > 50) {
        this.document.getElementById("up-btn").style.right = "20px";
    }
    if (pageYOffset < 50) {
        this.document.getElementById("up-btn").style.right = "-60px";
    }
});
//SHOW SEARCH BAR FUNCTION
function show_search_bar() {
    var search_bar = document.getElementsByClassName("search-bar").item(0);
    if (search_bar.style.display == "block") {
        search_bar.style.display = "none";
    } else {
        search_bar.style.display = "block";
    }
}
// SWITCH MODE FUCNTION
const toggleSwitch = document.querySelector('.switch [type="checkbox"]');
const currentTheme = localStorage.getItem('theme');

if (currentTheme) {
    document.documentElement.setAttribute('data-theme', currentTheme);

    if (currentTheme === 'dark') {
        toggleSwitch.checked = true;
    }
}
window.matchMedia('(prefers-color-scheme: dark)').matches

function switchTheme(e) {
    if (e.target.checked) {
        document.documentElement.setAttribute('data-theme', 'dark');
        localStorage.setItem('theme', 'dark');
    } else {
        document.documentElement.setAttribute('data-theme', 'light');
        localStorage.setItem('theme', 'light');
    }
}

toggleSwitch.addEventListener('change', switchTheme, false);
/// LoadPage
function loadPage(page) {
    location.assign(page);

}