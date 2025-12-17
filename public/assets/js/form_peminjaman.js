document.querySelector('form').addEventListener('submit', function(e) {
    const tglMulai = tanggalMulai.value;
    const jamMulai = jamMulai.value;
    const tglSelesai = tanggalSelesai.value;
    const jamSelesai = jamSelesai.value;

    if (tglSelesai < tglMulai || (tglSelesai === tglMulai && jamSelesai <= jamMulai)) {
        e.preventDefault();
        alert('Waktu selesai harus setelah waktu mulai!');
    }
});
