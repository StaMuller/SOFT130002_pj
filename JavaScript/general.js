var track = ["Homepage"];

function trackShow(){
    let trackStr = "";
    for(i = 0; i < track.length;){
        trackStr += track[i];
        ++i;
        if(i !== track.length){
            trackStr += " -> ";
        }
    }
    document.getElementById("track").innerText=trackStr;
}

function goRegister(){
    track.push("Login");
    for(i = 0; i < track.length; ++i){
        if(track[i] === "Register"){
            track = track.slice(0, track.indexOf("Register"));
            break;
        }
    }
    if(i === track.length){
        track.push("Register");
    }
}
function goLogin(){
    for(i = 0; i < track.length; ++i){
        if(track[i] === "Login"){
            track = track.slice(0, track.indexOf("Login"));
            break;
        }
    }
    if(i === track.length){
        track.push("Login");
    }
}
function goSearch(){
    for(i = 0; i < track.length; ++i){
        if(track[i] === "Search"){
            track = track.slice(0, track.indexOf("Search"));
            break;
        }
    }
    if(i === track.length){
        track.push("Search");
    }
}
function goHomepage(){
    for(i = 0; i < track.length; ++i){
        if(track[i] === "Homepage"){
            track = track.slice(0, track.indexOf("Homepage"));
            break;
        }
    }
    if(i === track.length){
        track.push("Homepage");
    }
}