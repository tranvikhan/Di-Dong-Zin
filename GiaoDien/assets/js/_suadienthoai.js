
//Prewiew image
var ImageReview2 = document.getElementById("ImageReview2");
var inputImage2 = document.getElementById("inputImage2");
inputImage2.addEventListener("change", function () {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.addEventListener("load", function () {
            ImageReview2.setAttribute("src", this.result)
        });
        reader.readAsDataURL(file);
    } else {
        ImageReview2.setAttribute("src", "assets/img/undraw_photo_4yb9.svg")
    }
});
