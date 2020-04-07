// MODAL FUNCTION
var modal = document.getElementById("myModal2");
// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
// When the user clicks the button, open the modal 
function suathanhvien(id) {
    modal.style.display = "block";
    var userAvatar = document.getElementById("form-userAvatar");
    var userID = document.getElementById("form-userId");
    var userType = document.getElementById("form-userType");
    var userName = document.getElementById("form-userName");
    var userFullName = document.getElementById("form-userFullName");
    var userSex = document.getElementById("form-userSex");
    var userDate = document.getElementById("form-userDate");
    var userPhone = document.getElementById("form-userPhone");
    var userAddress = document.getElementById("form-userAddress");
    userID.innerHTML=id;
    //ajax
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var myObj = JSON.parse(this.responseText);
            //code do du lieu vao day
        }
    };
    xhttp.open("GET", "getUser.php?id=" + id, true);
    xhttp.send();
}
// When the user clicks on <span> (x), close the modal
span.onclick = function () {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}