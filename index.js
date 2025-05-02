
fetch("/backend/logic/session_check.php",{
    method:"GET"
})
.then(res=>res.json())
.then(response=>{
    if (response.success) {
        const role= response.user.role;
        if (role==="admin") {
            window.location.href="/views/admin/";
        }else{
            window.location.href="/views/customer/";
        }
    }else{
        window.location.href="/views/"
    }
})
.catch(()=>window.location.href="/views/")
    

