//REPOINSIVE LEFT MENU
var left_menu = document.getElementById("left-menu");
left_menu.style.left = "0px";
function show_left_menu() {
    if (left_menu.style.left == "0px"){
        left_menu.style.left = "-200px";
    } else if (left_menu.style.left == "-200px"){
        left_menu.style.left = "0px";
    }
}
//TAB LOADING PAGE
function loadPage(pageURL) {
    location.assign(pageURL)
}