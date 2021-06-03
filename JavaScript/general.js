function trackShow(){
    let trackStr = "";
    const tmp = document.cookie.split('=');
    const tmpArray = tmp[1].split(",");
    for(let i = 0; i < tmpArray.length;){
        trackStr += tmpArray[i];
        ++i;
        if(i !== tmpArray.length){
            trackStr += " -> ";
        }
    }
    document.getElementById("track").innerText=trackStr;
}

function goRegister(){
    let tmp = document.cookie.split("=");
    let tmpArray = tmp[1].split(",");
    let i = 0;
    let array = [];
    while(i < tmpArray.length){
        array.push(tmpArray[i]);
        if(tmpArray[i] === "Register"){
            break;
        }
        ++i;
    }
    if(i === tmpArray.length){
        array.push("Register");
    }
    document.cookie=tmp[0] + "=" + tmpArray[0] + "; expires=Thu,01 Jan 1970 00:00:00 GMT";
    document.cookie="name=" + array;
}
function goLogin(){
    let tmp = document.cookie.split("=");
    let tmpArray = tmp[1].split(",");
    let i = 0;
    let array = [];
    while(i < tmpArray.length){
        array.push(tmpArray[i]);
        if(tmpArray[i] === "Login"){
            break;
        }
        ++i;
    }
    if(i === tmpArray.length){
        array.push("Login");
    }
    document.cookie=tmp[0] + "=" + tmpArray[0] + "; expires=Thu,01 Jan 1970 00:00:00 GMT";
    document.cookie="name=" + array;
}
function goSearch(){
    let tmp = document.cookie.split("=");
    let tmpArray = tmp[1].split(",");
    let i = 0;
    let array = [];
    while(i < tmpArray.length){
        array.push(tmpArray[i]);
        if(tmpArray[i] === "Search"){
            break;
        }
        ++i;
    }
    if(i === tmpArray.length){
        array.push("Search");
    }
    document.cookie=tmp[0] + "=" + tmpArray[0] + "; expires=Thu,01 Jan 1970 00:00:00 GMT";
    document.cookie="name=" + array;
}
function goHomepage(){
    document.cookie="name=" + new Array("Homepage");
    let tmp = document.cookie.split("=");
    let tmpArray = tmp[1].split(",");
    let i = 0;
    let array = [];
    while(i < tmpArray.length){
        array.push(tmpArray[i]);
        if(tmpArray[i] === "Homepage"){
            break;
        }
        ++i;
    }
    if(i === tmpArray.length){
        array.push("Homepage");
    }
    document.cookie=tmp[0] + "=" + tmpArray[0] + "; expires=Thu,01 Jan 1970 00:00:00 GMT";
    document.cookie="name=" + array;
}
function goExhibition(){
    let tmp = document.cookie.split("=");
    let tmpArray = tmp[1].split(",");
    let i = 0;
    let array = [];
    while(i < tmpArray.length){
        array.push(tmpArray[i]);
        if(tmpArray[i] === "Exhibition"){
            break;
        }
        ++i;
    }
    if(i === tmpArray.length){
        array.push("Exhibition");
    }
    document.cookie=tmp[0] + "=" + tmpArray[0] + "; expires=Thu,01 Jan 1970 00:00:00 GMT";
    document.cookie="name=" + array;
}
function goCollection(){
    let tmp = document.cookie.split("=");
    let tmpArray = tmp[1].split(",");
    let i = 0;
    let array = [];
    while(i < tmpArray.length){
        array.push(tmpArray[i]);
        if(tmpArray[i] === "Collection"){
            break;
        }
        ++i;
    }
    if(i === tmpArray.length){
        array.push("Collection");
    }
    document.cookie=tmp[0] + "=" + tmpArray[0] + "; expires=Thu,01 Jan 1970 00:00:00 GMT";
    document.cookie="name=" + array;
}