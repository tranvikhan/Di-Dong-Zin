//get phoneID
const phoneID='001';
//DELETE COMMENT
function del_cmt(cmtID) {
    alert("Xoa binh luan nay? id="+cmtID);
}
//UPDATE COMMENT
function change_cmt(toolEditId,cmtID) { 
    var noidung =document.getElementById(toolEditId).querySelector("textarea").value;
    console.log(noidung);
    //Uploat update cmt on ajax
    //Reload
}
//REPLY COMMENT
function new_cmt(toolReplyId, cmtID) {
    var noidung = document.getElementById(toolReplyId).querySelector("textarea").value;
    console.log(noidung);
    //Uploat new cmt on ajax
    //Reload
}
//ADD NEW A COMMENT
function add_cmt() {
    var noidung = document.getElementById("noiDungCmtMoi").value;
    console.log(noidung);
    //ajax now
    //Reload
    
}
//FUNCTION FOR COMMMET INTERFACE
function edit_cmt(toolEditId) {
    var toolEdit = document.getElementById(toolEditId);
    if (toolEdit.style.display != "block") {
        var closeAll = document.getElementsByClassName("edit-comment-tool");
        for (i = 0; i < closeAll.length; i++) {
            closeAll[i].style.display = "none";
        }
        toolEdit.style.display = "block";
    } else {
        toolEdit.style.display = "none";
    }
}

function reply_cmt(toolReplyId) {
    var toolReply = document.getElementById(toolReplyId);
    if (toolReply.style.display != "block") {
        var closeAll = document.getElementsByClassName("reply-comment-tool");
        for (i = 0; i < closeAll.length; i++) {
            closeAll[i].style.display = "none";
        }
        toolReply.style.display = "block";
    } else {
        toolReply.style.display = "none";
    }
}