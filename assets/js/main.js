// Menangani tombol logout
document.addEventListener("DOMContentLoaded", () => {
    const logoutButton = document.getElementById("logout");
    if (logoutButton) {
        logoutButton.addEventListener("click", () => {
            if (confirm("Anda yakin ingin logout?")) {
                window.location.href = "logout.php";
            }
        });
    }
});
