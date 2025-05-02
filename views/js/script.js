document.addEventListener("DOMContentLoaded", () => {
    if (localStorage.getItem("darkMode") === "enabled") {
        document.body.classList.add("dark-mode");
        document.querySelector(".toggle-mode").textContent = "Light Mode";
    }

});
function toggleDarkMode() {
    document.body.classList.toggle('dark-mode');
    let modeText = document.body.classList.contains('dark-mode') ? 'Light Mode' : 'Dark Mode';
    document.querySelector('.toggle-mode').textContent = modeText;
    localStorage.setItem("darkMode", document.body.classList.contains('dark-mode') ? "enabled" : "disabled");
}
function showToast(message, type = 'info', duration = 3000) {
    const container = document.getElementById('toast-container');
    container.innerHTML = `
    <div class='toast toast-${type}' id='toast'>
    <p> ${message}</p>
    <button class='close-btn' onclick="removeToast()"> &times; </button>
    </div>
    `;

    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(-20px)';
        setTimeout(() => toast.remove(), 300);

    }, duration);
}
function removeToast() {
    document.getElementById("toast").remove()
}
function toggleSidebar() {
    document.getElementById("sidebar").classList.remove('hidden');
    document.getElementById('m').classList.add("hidden");
}
function toggleOpen() {
    document.getElementById("sidebar").classList.add('hidden');
    document.getElementById('m').classList.remove("hidden");
}
function logout() {
    fetch("/backend/logic/logout.php", {
        method: "GET",
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

            showToast(response.message, "success");

            window.location.href = "/";
        })
        .catch(err => {
            console.error("Error:", err.message);
            showToast("Something went wrong: " + err.message, "error");
        });

}