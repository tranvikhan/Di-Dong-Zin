var dropdown = document.getElementsByClassName("dropdown-btn");
var i;

for (i = 0; i < dropdown.length; i++) {
    dropdown[i].addEventListener("click", function () {
        //this.classList.toggle("active");
        var dropdownContent = this.nextElementSibling;
        var imageBtn = this.children[0];
        if (dropdownContent.style.display === "block") {
            dropdownContent.style.display = "none";
            imageBtn.src = "assets/img/xemthem.png";
        } else {
            dropdownContent.style.display = "block";
            imageBtn.src = "assets/img/anbot.png";
        }
    });
}