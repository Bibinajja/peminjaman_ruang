document.addEventListener("DOMContentLoaded", function () {

    const palette = {
        nantucketBreeze: "#BFD7EA",
        cloudDancer: "#F2F2EE",
        alaskanBlue: "#6FA7C7",
        cosmicSky: "#B4B6D2",
        aquaGray: "#AEB8B2",
        regatta: "#4F7DB6",
        rinsingRivulet: "#5ECAC3",
        duskyCitron: "#E6D28A"
    };

    /* ===== BADGE STATUS ===== */
    document.querySelectorAll(".badge").forEach(badge => {
        const status = badge.textContent.trim();

        if (status === "Disetujui") {
            badge.style.backgroundColor = palette.rinsingRivulet;
            badge.style.color = "#fff";
        } else if (status === "Ditolak") {
            badge.style.backgroundColor = palette.cosmicSky;
            badge.style.color = "#fff";
        } else if (status === "Menunggu") {
            badge.style.backgroundColor = palette.duskyCitron;
            badge.style.color = "#333";
        }
    });

    /* ===== TOMBOL (JIKA ADA) ===== */
    document.querySelectorAll(".btn-approve").forEach(btn => {
        btn.style.background = palette.rinsingRivulet;
        btn.style.border = "none";
        btn.style.color = "#fff";

        btn.addEventListener("click", () => {
            const id = btn.dataset.id;
            if (confirm("Setujui permohonan ini?")) {
                kirimStatus(id, "Disetujui");
            }
        });
    });

    document.querySelectorAll(".btn-reject").forEach(btn => {
        btn.style.background = palette.cosmicSky;
        btn.style.border = "none";
        btn.style.color = "#fff";

        btn.addEventListener("click", () => {
            const id = btn.dataset.id;
            if (confirm("Tolak permohonan ini?")) {
                kirimStatus(id, "Ditolak");
            }
        });
    });

    function kirimStatus(id, status) {
        fetch("aksi_konfirmasi.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `id=${id}&status=${status}`
        })
        .then(() => location.reload())
        .catch(() => alert("Gagal update status"));
    }

});
