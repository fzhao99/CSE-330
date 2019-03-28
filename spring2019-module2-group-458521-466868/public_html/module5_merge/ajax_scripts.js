function loginAjax(event) {
    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;

    const data = {"username": username, "password": password};

    fetch("login_ajax.php", {
        method: 'POST',
        body: JSON.stringify(data),
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'}
    })
    .then(response=>response.json())
    .then(function(data){
        if(data.success){
            console.log("You've been logged in!");
            updateCalendar();
            document.getElementById('login').style.display = "none";
            document.getElementById('signup_button').style.display="none";
            document.getElementById('add-event').style.display="inline";
            document.getElementById('logout').style.display = "inline";
            document.getElementById('tags').style.display = "inline";
            document.getElementById('login_error').textContent = '';
           
            localStorage.setItem("token", data.token);

        } else {
            console.log(`You were not logged in ${data.message}`);
            document.getElementById('login_error').textContent = `${data.message}`;
            document.getElementById('username').value = '';
            document.getElementById('password').value = '';
            
        }

    })
}
function logoutAjax(event){
    fetch("logout.php", {
        headers: {
            'Content-Type': 'application/json'}
    })
    .then(response=>response.json())
    .then(function(data){
        if(data.success){
            updateCalendar();
            console.log("You've been logged out!");
            document.getElementById('login').style.display="inline";
            document.getElementById('logout').style.display = "none";
            document.getElementById('add-event').style.display="none";
            document.getElementById('tags').style.display = "none";

            document.getElementById('signup_button').style.display="block";
            document.getElementById('username').value = '';
            document.getElementById('password').value = '';

        } else {
            console.log(`${data.message}`);
        }
    })
    // .then(function(data){
    //     if(data.success){
    //         updateCalendar();
    //         console.log("You've been logged out!");
    //         document.getElementById('login').style.display="inline";
    //         document.getElementById('logout').style.display = "none";
    //         document.getElementById('add-event').style.display="none";
    //         document.getElementById('signup_button').style.display="block";
    //         document.getElementById('username').value = '';
    //         document.getElementById('password').value = '';
    //     } else {
    //         console.log(`${data.message}`);
    //     }
    // })
}
//adding a comment
function signupAjax(event){

    const first_name = document.getElementById('first_name').value;
    const last_name = document.getElementById('last_name').value;
    const new_username = document.getElementById('new_username').value;
    const new_password = document.getElementById('new_password').value;
    const confirm_password = document.getElementById('confirm_password').value;

    const data = {
        "first_name": first_name,
        "last_name": last_name,
        "new_username": new_username,
        "new_password": new_password,
        "confirm_password": confirm_password
    }
    fetch("signup.php", {
        method: 'POST',
        body: JSON.stringify(data),
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response=>response.json())
    .then(function(data){
        if(data.success){
            console.log("You have successfully signed up!");
            document.getElementById('signup').style.display='none';
            document.getElementById('login').style.display='inline';
            document.getElementById('first_name').value = '';
            document.getElementById('last_name').value = '';
            document.getElementById('new_username').value = '';
            document.getElementById('new_password').value = '';
            document.getElementById('confirm_password').value = '';
            document.getElementById('su_error').textContent = '';

        } else {
            console.log(`${data.message}`);
            document.getElementById('su_error').textContent = `${data.message}`;
            document.getElementById('first_name').value = '';
            document.getElementById('last_name').value = '';
            document.getElementById('new_username').value = '';
            document.getElementById('new_password').value = '';
            document.getElementById('confirm_password').value = '';

        }
    })
}
function handleRefresh(){
    fetch("is_session_set.php",{
    method:'POST',
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
    }}
)
.then(response=>response.json())
.then(function(data){
    if(data.success){
        document.getElementById('logout').style.display = "inline";
        document.getElementById('add-event').style.display="inline";
        document.getElementById('tags').style.display = "inline";

        document.getElementById('login').style.display = "none";
        document.getElementById('signup_button').style.display = "none";


    }
    else{
        document.getElementById('logout').style.display = "none";
        document.getElementById('add-event').style.display="none";
        document.getElementById('tags').style.display = "none";

        document.getElementById('login').style.display = "inline";
        document.getElementById('signup_button').style.display = "inline";

    }
})
}



document.addEventListener("DOMContentLoaded", function(){
    handleRefresh();
    document.getElementById('logout_button').addEventListener("click", logoutAjax, false);
    document.getElementById("login_button").addEventListener("click", loginAjax, false);
    document.getElementById('signup_button').addEventListener("click", function(){
        document.getElementById('login').style.display="none";
        document.getElementById('signup').style.display="inline";
        document.getElementById('signup_button').style.display="none";
    }, false);
    document.getElementById('register_user').addEventListener("click", signupAjax, false);
    document.getElementById('return_to_login').addEventListener("click", function(){
        document.getElementById('login').style.display="inline";
        document.getElementById('su_error').textContent = '';
        document.getElementById('login_error').textContent = '';
        document.getElementById('signup').style.display="none";
        document.getElementById('signup_button').style.display="block";
    }, false);
}, false);
