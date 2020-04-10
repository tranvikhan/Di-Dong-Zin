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
//SUA HANG DIEN THOAI 
var suahangdt = document.getElementById("suahangdt");

function SuaHang(idHangDt, tenHangDT, quocGia) {
    suahangdt.style.display = "block";
    document.getElementById("IdHangDt").value = idHangDt;
    document.getElementById("TenHangDT").value = tenHangDT;
    document.getElementById("QuocGiaHangDT").value = quocGia;}

function closeSuaHang() {
    suahangdt.style.display = "none";
}

//XOA HANG DIEN THOAI   
function XoaHang(tenHang, soLuongDT)
{
    if(soLuongDT == 0)
    {
        return confirm('Bạn sẽ xóa hãng điện thoại '+ tenHang +'?');
    }
    else
    {
        alert('Hãng điện thoại '+ tenHang +' có những điện thoại di động. Bạn không thể xóa nó !!');
        return false;
    }
}