// public/js/stakeholder-dashboard.js
(function () {
  // ======== GLOBAL DEFAULTS (paksa warna teks & grid gelap di atas bg putih) ========
  if (typeof window.Chart === "undefined") {
    console.error("[stakeholder-dashboard] Chart.js belum terload.");
    return;
  }
  // teks, axis ticks, legend labels
  Chart.defaults.color = "#1E293B";     // slate-800
  // garis grid / border
  Chart.defaults.borderColor = "#CBD5E1"; // slate-300
  // font size sedikit lebih jelas
  Chart.defaults.font.size = 12;

  // ======== Helper: pastikan canvas punya tinggi ========
  function ensureMinHeight(id, px = 300) {
    const el = document.getElementById(id);
    if (el && !el.style.minHeight) el.style.minHeight = px + "px";
    return el;
  }

  // ======== Ambil data dari Blade ========
  const data = window.__charts;
  if (!data) {
    console.warn("[stakeholder-dashboard] window.__charts tidak ditemukan di Blade.");
    return;
  }

  // ======== Dana Cair per Bulan (Bar) ========
  (function () {
    const el = ensureMinHeight("chartDanaCair", 320);
    const d = data.danaCair;
    if (!el || !d) return;

    new Chart(el, {
      type: "bar",
      data: {
        labels: d.labels,
        datasets: [
          {
            label: "Dana Cair (juta)",
            data: d.data,
            backgroundColor: "rgba(14,165,233,0.35)", // sky-500 @35%
            borderColor: "#0EA5E9",                    // sky-500
            borderWidth: 2,
            borderRadius: 6,
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { labels: { color: "#1E293B" } },
          tooltip: {
            callbacks: {
              label: (ctx) => ` ${ctx.dataset.label}: ${ctx.parsed.y} jt`,
            },
          },
        },
        scales: {
          x: {
            ticks: { color: "#1E293B" },
            grid: { color: "#E2E8F0" }, // slate-200
          },
          y: {
            beginAtZero: true,
            ticks: { color: "#1E293B" },
            grid: { color: "#E2E8F0" },
          },
        },
      },
    });
  })();

  // ======== Pengeluaran per ORMAWA (Doughnut) ========
  (function () {
    const el = ensureMinHeight("chartPerOrmawa", 320);
    const d = data.perOrmawa;
    if (!el || !d) return;

    const base = ["#0EA5E9", "#22C55E", "#F59E0B", "#6366F1", "#EF4444", "#10B981", "#EAB308"];
    const bg = d.labels.map((_, i) => `${base[i % base.length]}CC`); // ~80% alpha
    const br = d.labels.map((_, i) => base[i % base.length]);

    new Chart(el, {
      type: "doughnut",
      data: {
        labels: d.labels,
        datasets: [
          {
            label: "Pengeluaran (juta)",
            data: d.data,
            backgroundColor: bg,
            borderColor: br,
            borderWidth: 2,
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { position: "bottom", labels: { color: "#1E293B" } },
          tooltip: { callbacks: { label: (ctx) => ` ${ctx.label}: ${ctx.parsed} jt` } },
        },
      },
    });
  })();

  // ======== Rata-rata Waktu Proses (Line) ========
  (function () {
    const el = ensureMinHeight("chartLeadTime", 320);
    const d = data.leadTime;
    if (!el || !d) return;

    new Chart(el, {
      type: "line",
      data: {
        labels: d.labels,
        datasets: [
          {
            label: "Lead Time (hari)",
            data: d.data,
            borderColor: "#22C55E",             // green-500
            backgroundColor: "rgba(34,197,94,0.2)",
            borderWidth: 2,
            tension: 0.3,
            pointRadius: 3,
            pointHoverRadius: 5,
            fill: false,
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { labels: { color: "#1E293B" } },
          tooltip: { enabled: true },
        },
        scales: {
          x: { ticks: { color: "#1E293B" }, grid: { color: "#E2E8F0" } },
          y: { ticks: { color: "#1E293B" }, grid: { color: "#E2E8F0" } },
        },
      },
    });
  })();
})();
