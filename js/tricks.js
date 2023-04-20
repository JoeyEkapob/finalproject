
    function showstatprotext1(status) {
        if (status == '1') {
            return "รอดำเนินการ";
        } else if (status == '2') {
            return "เลยระยะเวลา";
        } else if (status == '3') {
            return "ปิดโปรเจค";
        }
    }

    function showstatprotext2(status_2) {
        if(status_2 == '1') {
            return "งานปกติ";
        } else if (status_2 == '2') {
            return "งานด่วน";
        } else if (status_2 == '3') {
            return "งานด่วนมาก";
        }
    }
    function ThDate(date) {
        var months = [
          "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน",
          "พฤษภาคม", "มิถุนายน", "กรกฏาคม", "สิงหาคม",
          "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
        ];
        var days = ["อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัส", "ศุกร์", "เสาร์"];
      
        var dateObj = new Date(date);
        if (isNaN(dateObj.getTime())) {
          return "";
        }
      
        var week = dateObj.getDay();
        var month = dateObj.getMonth();
        var day = dateObj.getDate();
        var year = dateObj.getFullYear() + 543;
      
        return "วัน" + days[week] + "ที่ " + day + " " + months[month] + " " + year;
      }

    function showpass(){ //เเสดง Password
        var pass = document.getElementById('password');
        if(pass.type == 'password'){
            pass.type = 'text';

        }else if(pass.type == 'text'){

            pass.type = 'password';
        }

    }