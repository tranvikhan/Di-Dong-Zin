//Prewiew image
var ImageReview = document.getElementById("ImageReview");
var inputImage = document.getElementById("inputImage");
inputImage.addEventListener("change", function () {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.addEventListener("load", function () {
            ImageReview.setAttribute("src", this.result)
        });
        reader.readAsDataURL(file);
    } else {
        ImageReview.setAttribute("src", "assets/img/picture_200px.png")
    }
});
