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
//KHUYEN MAI
const check = document.getElementById("apDungKM");
check.addEventListener("change", function () {
    if (!check.checked) {
       document.getElementById("phanTramGiam").disabled = true;
       document.getElementById("quaTang").disabled = true;
       document.getElementById("ngayBatDau").disabled = true;
       document.getElementById("ngayKetThuc").disabled = true;
    }else{
        document.getElementById("phanTramGiam").disabled = false;
        document.getElementById("quaTang").disabled = false;
        document.getElementById("ngayBatDau").disabled = false;
        document.getElementById("ngayKetThuc").disabled = false;
    }
});