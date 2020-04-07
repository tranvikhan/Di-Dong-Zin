var hinhthuc =document.getElementsByName("hinhthuc")[0];
var hint_thanhtoan= document.getElementsByClassName("hint-thanhtoan");
var type = document.getElementsByClassName("hint-thanhtoan")[0].style.display;
hinhthuc.addEventListener('change',function () {    
    if(hinhthuc.value=="Thanh toán Online"){
        for(i=0;i<hint_thanhtoan.length;i++){
            hint_thanhtoan[i].style.display = type;
        }
    }else{
        for (i = 0; i < hint_thanhtoan.length; i++) {
            hint_thanhtoan[i].style.display = "none";
        }
    }
    
})

