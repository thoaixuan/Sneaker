/*Thoai_Hacker >> CART Js*/

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length,c.length);
        }
    }
    return "";
}
function checkCookie(cname) {
    var cname=getCookie("name_product");
    if (cname!="") {
        alert("Đã có trong giỏ hàng " + cname);
    } else {
        /*username = prompt("Please enter your name:", "");
        if (username != "" && username != null) {
            setCookie("username", username, 365);
        }*/
        alert("SP NEWs");
    }
}
function delete_cookie(cname) { document.cookie = cname + "=" + "; " + 0; }
var clicks = 0;
function add_to_cart(){
  /*Block spam click */
  clicks += 1;
  if(clicks==4){alert("Do not CLICK SPAM  ! I'm Hacker"); window.location.href ='https://www.youtube.com/watch?v=m2dz_z-3B0s';}
  /*----------------- */
  var name_product, size_product, sl_product, prize;

  checkCookie(name_product);

  name_product = document.getElementById("name_product").value;
  size_product = document.getElementById("size_product").value;
  sl_product = document.getElementById("1").value;
  prize = document.getElementById("prize").value;
  /*Delete cooki: setCookie('username','giatricookie' , 1); hoac delete_cookie('username');*/
  setCookie('name_product',name_product , 1);
  setCookie('size_product',size_product , 1);
  setCookie('sl_product',sl_product , 1);
  setCookie('prize',prize , 1);
  /*var y = getCookie('prize');*/
  console.log(getCookie('name_product'),'>> Size : '+getCookie('size_product'),'>>SL : '+ getCookie('sl_product'),'>>Gia : '+getCookie('prize'));
}