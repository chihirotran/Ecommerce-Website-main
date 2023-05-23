
var fut = new Date("march 12, 2023 13:29:00").getTime()

// Sử dụng jQuery để gửi yêu cầu Ajax đến file PHP

$.ajax({
    url: 'get_date.php',
    type: 'GET',
    dataType: 'json',
    success: function(data) {
        // Lấy giá trị ngày từ dữ liệu JSON
        var date_str = data.date;
        console.log("1234567899999999");
        // Chuyển đổi chuỗi ngày thành đối tượng ngày
        var date1 = new Date(date_str);
        var date1_7h = new Date(date1.getTime() - 7*60*60*1000); 
        // Hiển thị giá trị ngày
        console.log(date1);
        console.log(date1_7h);
        let x = setInterval(function stime(){
            
            var now = new Date().getTime()
            var D = date1_7h - now 
            var days = Math.floor(D/(1000*60*60*24))
            var hours = Math.floor(D/(1000*60*60))
            var minutes = Math.floor(D/(1000*60))
            var seconds = Math.floor(D/(1000))
            var daysale = days+" Ngày"
            hours %=24
            minutes %=60
            seconds %=60
            document.getElementById("days").innerText = daysale
            document.getElementById("hours").innerText = hours+" Giờ"
            document.getElementById("minutes").innerText = minutes+" Phút"
            document.getElementById("seconds").innerText = seconds+" Giây"
        
            if(D<0 || date_str==null ){
                clearInterval(x);
                var element = document.getElementById("TimeSale");
                element.style.display = "none";s
            }
        }, 0.1);
    },
    error: function(xhr, status, error) {
        var element = document.getElementById("TimeSale");
        element.style.display = "none";s
    }
});

function menutoggle() {
    var menuContainer = document.getElementById('menu-container');
    menuContainer.classList.toggle('menu-open');
}

function closeMenuOutsideClick(event) {
    var menu = document.getElementById('menu-container');
    var isClickInsideMenu = menu.contains(event.target);

    if (!isClickInsideMenu) {
        menu.classList.remove('menu-open');
    }
}

document.addEventListener('click', closeMenuOutsideClick);

document.addEventListener('click', closeMenuOutsideClick);


