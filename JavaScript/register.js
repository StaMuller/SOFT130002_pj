function registerConfirm(){
    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;
    const passwordConfirm = document.getElementById("passwordConfirm").value;
    const test = /^[0-9a-zA-Z]+$/;

    if(username === "" || password === "" || passwordConfirm === ""){
        if(username === ""){
            window.alert("username cannot be empty.");
        }else if(password === ""){
            window.alert("password cannot be empty.");
        }else{
            window.alert("password confirmation cannot be empty.");
        }
    }else if(password !== passwordConfirm){
        window.alert("password and password confirmation is unmatched.");
    }else if(!test.test(password)){
        window.alert("password must include both numbers and letters");
    }else{
        window.alert("Register Succeed!");
    }
}