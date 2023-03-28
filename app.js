
var fut = new Date("march 12, 2023 13:29:00").getTime()

// Sử dụng jQuery để gửi yêu cầu Ajax đến file PHP

$.ajax({
    url: 'get_date.php',
    type: 'GET',
    dataType: 'json',
    success: function(data) {
        // Lấy giá trị ngày từ dữ liệu JSON
        var date_str = data.date;

        // Chuyển đổi chuỗi ngày thành đối tượng ngày
        var date1 = new Date(date_str);
        var date1_7h = new Date(date1.getTime() - 7*60*60*1000); 
        // Hiển thị giá trị ngày
        console.log(date1);
        let x = setInterval(function stime(){
            
            var now = new Date().getTime()
            var D = date1_7h - now 
            var days = Math.floor(D/(1000*60*60*24))
            var hours = Math.floor(D/(1000*60*60))
            var minutes = Math.floor(D/(1000*60))
            var seconds = Math.floor(D/(1000))
            hours %=24
            minutes %=60
            seconds %=60
            document.getElementById("days").innerText = days
            document.getElementById("hours").innerText = hours
            document.getElementById("minutes").innerText = minutes
            document.getElementById("seconds").innerText = seconds
        
            if(D<0){
                clearInterval(x);
                var element = document.getElementById("TimeSale");
                element.style.display = "none";
            }
        }, 0.1);
    },
    error: function(xhr, status, error) {
        // Xử lý lỗi
    }
});



