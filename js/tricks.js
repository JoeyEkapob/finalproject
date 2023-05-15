
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

    function showshortname(shortname){
        if(shortname =='1'){
            return "นาย";
        }else if(shortname =='2'){
            return "นางสาว";
        } else if(shortname =='9'){
            return "นาง";
        } else if(shortname =='3'){
            return "ดร.";
        } else if(shortname =='4'){
        return "ผศ.";
        } else if(shortname =='5'){
            return "รศ.";
        } else if(shortname =='6'){
            return "ศ.";
        } else if(shortname =='7'){
            return "ผศ.ดร.";
        } else if(shortname =='8'){
            return "ศ.ดร."; 
        }else if(shortname =='10'){
            return "อาจารย์"; 
        }
    }

const dayTH = [null,'อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์']; 
const monthTH = [null,'มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'];
const monthTH_brev = [null,'ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];

function thaiDateFullMonth(time) {
  const thaiDate = new Date(time);
  const day = thaiDate.getDate();
  const month = monthTH[thaiDate.getMonth() + 1];
  const year = thaiDate.getFullYear() + 543;
  return `${day} ${month} ${year}`;
}
function thai_date_short(time) {
    const thai_date_return = new Date(time);
    const date = thai_date_return.getDate();
    const month = monthTH_brev[thai_date_return.getMonth() + 1];
    const year = thai_date_return.getFullYear() + 543;
    return `${date} ${month} ${year}`;
    }