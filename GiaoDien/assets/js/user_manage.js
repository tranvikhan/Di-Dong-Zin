//Prewiew image
const URLdefault = document.getElementById("img_avatar").getAttribute("src");
var ImageReview = document.getElementById("img_avatar");
var inputImage = document.getElementById("input_avatar");
inputImage.addEventListener("change", function () {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.addEventListener("load", function () {
            ImageReview.setAttribute("src", this.result);
        });
        reader.readAsDataURL(file);
    } else {
        ImageReview.setAttribute("src", URLdefault);
    }
});