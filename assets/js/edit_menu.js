function showPopup(popupId, data = null) {
    var popup = new bootstrap.Modal(document.getElementById(popupId));
    popup.show();

    if (popupId === 'editMenuPopup' && data) {
        document.getElementById('edit-id-menu').value = data.id_menu;
        document.getElementById('edit-nama-menu').value = data.nama_menu;
        document.getElementById('edit-deskripsi').value = data.deskripsi;
        document.getElementById('edit-harga').value = data.harga;
        document.getElementById('edit-stok').value = data.stok;
        document.getElementById('edit-kategori').value = data.kategori;
        document.getElementById('edit-existing-image').value = data.image;
    }
}