// Konfirmasi sebelum menghapus produk
function confirmDelete(productName) {
    return confirm(`Anda yakin ingin menghapus produk "${productName}"?`);
}

// Menampilkan notifikasi
function showNotification(message, type = "success") {
    const notification = document.createElement("div");
    notification.className = `notification ${type}`;
    notification.innerText = message;
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.remove();
    }, 3000);
}
