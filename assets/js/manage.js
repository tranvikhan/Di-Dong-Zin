var left_menu = document.getElementById("left-menu");
left_menu.style.left = "0px";
function show_left_menu() {
    if (left_menu.style.left == "0px"){
        left_menu.style.left = "-200px";
    } else if (left_menu.style.left == "-200px"){
        left_menu.style.left = "0px";
    }
}
//TAB FUNCTION
function openTab(evt, tabName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(tabName).style.display = "block";
    if(tabName!='themdienthoai'){
        evt.currentTarget.className += " active";
    }
    
}
//TAB FUNCTION SUA DIEN THOAI
function openTabSua(evt, tabName,phoneid) {
    var i, tabcontent, tablinks,phoneID;
    phoneID = document.getElementById("phoneID");
    phoneID.value = phoneid;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    document.getElementById(tabName).style.display = "block";
}
//Prewiew image
var ImageReview = document.getElementById("ImageReview");
var inputImage = document.getElementById("inputImage");
inputImage.addEventListener("change",function () {
    const file = this.files[0];
    if(file){
        const reader = new FileReader();
        reader.addEventListener("load",function () {
            ImageReview.setAttribute("src",this.result)
        });
        reader.readAsDataURL(file);
    }else{
        ImageReview.setAttribute("src", "assets/img/picture_200px.png")
    }
});
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
        ImageReview2.setAttribute("src", "assets/img/picture_200px.png")
    }
});
//CHECK PHONE ALL
const checkAll= document.getElementById("checkAll");
const check_phone = document.getElementsByName("check_phone[]");
checkAll.addEventListener("change",function () {
   if(checkAll.checked){
        for(var i=0; i<check_phone.length;i++){
            check_phone[i].checked = true;
        }
   }else{
       for (var i = 0; i < check_phone.length; i++) {
           check_phone[i].checked = false;
       }
   }
});
function delete_item(madienthoai) {
    var id= madienthoai;
    alert("Bạn chắc chắn muốn xóa sản phẩm "+" "+id+" ?");
}
//THEM HANG DIEN THOAI 
var btn_themhangdt = document.getElementById("btn-themhangdt");
var themhangdt= document.getElementById("themhangdt");
btn_themhangdt.addEventListener("click",function () {
    themhangdt.style.display = "block";
    btn_themhangdt.style.display = "none";
})
function closeThemHang() {
    themhangdt.style.display="none";
    btn_themhangdt.style.display="block";
}
//SUA DIEN THOAI 
var suahangdt = document.getElementById("suahangdt");
function SuaHang(idHangDt) {
    suahangdt.style.display = "block";
    document.getElementById("IdHangDt").value= idHangDt;
}

function closeSuaHang() {
    suahangdt.style.display = "none";
}
//CHar.................
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'CN'],
        datasets: [{
            label: 'Sản phẩm bán được',
            data: [10, 15, 3, 3, 2, 1,5],
            backgroundColor: [
                'rgba(231, 76, 60, 0.8)'],
            borderColor: [
                'rgba(44, 62, 80, 0.2)',
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});