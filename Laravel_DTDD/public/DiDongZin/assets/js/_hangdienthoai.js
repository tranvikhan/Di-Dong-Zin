//THEM HANG DIEN THOAI 
var btn_themhangdt = document.getElementById("btn-themhangdt");
var themhangdt = document.getElementById("themhangdt");
btn_themhangdt.addEventListener("click", function () {
    themhangdt.style.display = "block";
    btn_themhangdt.style.display = "none";
})

function closeThemHang() {
    themhangdt.style.display = "none";
    btn_themhangdt.style.display = "block";
}
//SUA DIEN THOAI 
var suahangdt = document.getElementById("suahangdt");

function SuaHang(idHangDt, Ten_hang, Quoc_gia) {
    suahangdt.style.display = "block";
    document.getElementById("IdHangDt").value = idHangDt;
    document.getElementById("TenHangDT").value = Ten_hang;
    document.getElementById("QuocGiaHangDT").value = Quoc_gia;
}

function closeSuaHang() {
    suahangdt.style.display = "none";
}