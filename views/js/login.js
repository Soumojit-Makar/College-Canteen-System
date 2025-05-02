function showLogin() {
    
    document.getElementById("btn-login-form").innerText = "Logging in...";
    document.getElementById("btn-login-form").disabled = true;
    document.getElementById("main-content").classList.add("hidden");
    document.getElementById("login-form").classList.remove("hidden");
    document.getElementById("signup-form").classList.add("hidden");
    document.getElementById("btn-login-form").innerText = "Login";
    document.getElementById("btn-login-form").disabled = false;
}

function showSignup() {
    document.getElementById("btn-signup-form").innerText = "Signing up...";
    document.getElementById("btn-signup-form").disabled = true;

    document.getElementById("main-content").classList.add("hidden");
    document.getElementById("signup-form").classList.remove("hidden");
    document.getElementById("login-form").classList.add("hidden");
    document.getElementById("btn-signup-form").innerText = "Sign Up";
    document.getElementById("btn-signup-form").disabled = false;
}
function showHome() {
    document.getElementById("main-content").classList.remove("hidden");
    document.getElementById("login-form").classList.add("hidden");
    document.getElementById("signup-form").classList.add("hidden");
}
function signup() {
    document.getElementById("btn-signup").innerText = "Signing up...";
    document.getElementById("btn-signup").disabled = true;
    let fullname = document.getElementById('fullname').value;
    let phone = document.getElementById('phone').value;
    let password = document.getElementById('password').value;

    if (!fullname || !phone || !password) {
        showToast("Please fill all fields!", "error");
        document.getElementById("btn-signup").innerText = "Sign Up";
        document.getElementById("btn-signup").disabled = false;
        return;
    }

    const formData = new FormData();
    formData.append("fullname", fullname);
    formData.append("phone", phone);
    formData.append("password", password);

    fetch("/backend/logic/sign_up.php", {
        method: "POST",
        body: formData
    })
        .then(async res => {
            const text = await res.text();
            console.log("Raw response from PHP:", text);
            try {
                return JSON.parse(text);
            } catch (err) {
                throw new Error("Invalid JSON returned from PHP: " + text);
            }
        })
        .then(response => {
            if (response.success) {
                showToast(response.message, "success");
                showLogin();
            } else {
                showToast(response.message, "error");
            }
        })
        .catch(err => {
            console.error("Error:", err.message);
            showToast("Something went wrong: " + err.message, "error");
        });
    document.getElementById("btn-signup").innerText = "Sign Up";
    document.getElementById("btn-signup").disabled = false;
}

function login() {
    // console.log(0)
    document.getElementById("btn-login").innerText = "Logging in...";
    document.getElementById("btn-login").disabled = true;

    
    const phone = document.getElementById("login-phone").value;
    const password = document.getElementById("login-password").value;
    console.log(1);
    
    if (!phone || !password) {
        showToast("Please fill all fields!", "error");
        return;
    }
    // console.log(2);
    
    const formData = new FormData();
    formData.append("phone", phone);
    formData.append("password", password);
    // console.log(3);
    
    fetch("/backend/logic/login.php", {
        method: "POST",
        body: formData
    })
        .then(async res => {
            // console.log(4);
            
            const text = await res.text();
            console.log("Raw response from PHP:", text);
            try {
                return JSON.parse(text);
            } catch (err) {
                throw new Error("Invalid JSON returned from PHP: " + text);
            }
        })
        .then(response => {
            // console.log(5);
            
            if (response.success) {
                showToast(response.message, "success");
                if (response.user.role === "admin") {
                    window.location.href = "./admin/"
                } else {
                    window.location.href = "./customer/"
                }

            } else {
                showToast(response.message, "error");
            }
        })
        .catch( err => {
            // console.log(6);
            
            console.error("Error:", err);
            showToast("Something went wrong!", "error");

        });
        document.getElementById("btn-login").innerText = "Login";
        document.getElementById("btn-login").disabled = false;

}