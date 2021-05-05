function loginConfirm(){
    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;
    if(username !== "" && password !== ""){
        window.alert("Login Succeed!");
    }else if(username === ""){
        window.alert("Username is not valid.");
    }else{
        window.alert("Password is not valid.");
    }
}