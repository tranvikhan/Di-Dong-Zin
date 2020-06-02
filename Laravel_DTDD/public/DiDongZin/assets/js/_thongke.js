//CHAR JS FUNCTION
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'CN'],
        datasets: [{
            label: 'Sản phẩm bán được',
            data: [10, 15, 3, 3, 2, 1, 5],
            backgroundColor: [
                'rgba(231, 76, 60, 0.8)'
            ],
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

function doiLoaiBaoCao(){
    var s = document.getElementById("LoaiBaoCao");
    var i = document.getElementById("ThoiGianBaoCao");
    var n = document.getElementById("NamBaoCao");
    switch(s.value){
        case "1": 
            i.style.display = "inline-block";
            n.style.display = "none";
            i.type ="date";
            //ajax now
            break;
        // case "2":
        //     i.style.display = "inline-block";
        //     n.style.display = "none";
        //     i.type ="week";
        //     //ajax now
        // break;
        case "3":
            i.style.display = "inline-block";
            n.style.display = "none";
            i.type = "month";
            //ajax now
        break;
        case "4":
            i.style.display = "none";
            n.style.display = "inline-block";
            //ajax now
        break;
    }
}

function doiKieuBC(){
    var s = document.getElementById("kieubaocao");
    var tb1 = document.getElementById("bangBaoCao");
    var tb2 = document.getElementById("bangSanPham");
    if(s.value=="1"){
        tb1.style.display="block";
        tb2.style.display = "none";
    }else{
        tb2.style.display = "block";
        tb1.style.display = "none";
    }
}