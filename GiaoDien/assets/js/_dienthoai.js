//CHECK PHONE ALL
const checkAll = document.getElementById("checkAll");
const check_phone = document.getElementsByName("check_phone[]");
checkAll.addEventListener("change", function () {
    if (checkAll.checked) {
        for (var i = 0; i < check_phone.length; i++) {
            check_phone[i].checked = true;
        }
    } else {
        for (var i = 0; i < check_phone.length; i++) {
            check_phone[i].checked = false;
        }
    }
});
// DELETE ITEM
function delete_item(madienthoai) {
    var id = madienthoai;
    alert("Bạn chắc chắn muốn xóa sản phẩm " + " " + id + " ?");
}