var ua = navigator.userAgent;
var ipad = ua.match(/(iPad).*OS\s([\d_]+)/);

var isIphone =!ipad && ua.match(/(iPhone\sOS)\s([\d_]+)/);
if(isIphone){
    window.location.href='https://phone.ffffffff0x.com/'
}

var isAndroid = ua.match(/(Android)\s+([\d.]+)/);
if(isAndroid){

    window.location.href='https://phone.ffffffff0x.com/'
}