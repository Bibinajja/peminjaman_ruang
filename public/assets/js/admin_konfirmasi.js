document.addEventListener("DOMContentLoaded", function () {

    // Konfirmasi SETUJUI
    document.querySelectorAll(".btn-success").forEach(btn => {
        btn.addEventListener("click", function (e) {
            const ok = confirm(
                "Setujui permohonan ini?\n\nPermohonan akan diteruskan ke Warek."
            );
            if (!ok) {
                e.preventDefault();
                return;
            }

            // cegah double click
            btn.classList.add("disabled");
            btn.innerText = "Memproses...";
        });
    });

    // Konfirmasi TOLAK
    document.querySelectorAll(".btn-danger").forEach(btn => {
        btn.addEventListener("click", function (e) {
            const ok = confirm(
                "Tolak permohonan ini?\n\nTindakan ini tidak dapat dibatalkan."
            );
            if (!ok) {
                e.preventDefault();
                return;
            }

            btn.classList.add("disabled");
            btn.innerText = "Memproses...";
        });
    });

    // Auto hide alert (jika ada)
    const alerts = document.querySelectorAll(".alert");
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.classList.add("fade");
            alert.classList.remove("show");
        }, 4000);
    });

    
});
