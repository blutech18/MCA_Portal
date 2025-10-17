/* MCA Portal JS - Version: 2025-09-29 22:56:16 - Cache Busted */
document.addEventListener("DOMContentLoaded", function () {
    const juniorCanvas = document.getElementById('juniorChart');
    const seniorCanvas = document.getElementById('seniorChart');

    function prepareCanvas(canvas) {
        if (!canvas) return;
        // Align internal drawing size with displayed size for accurate hover
        const rect = canvas.getBoundingClientRect();
        canvas.width = Math.max(1, Math.floor(rect.width));
        canvas.height = Math.max(1, Math.floor(rect.height));
    }

    function buildOptions(extra) {
        return Object.assign({
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'nearest', intersect: true },
            plugins: { tooltip: { enabled: true }, legend: { display: true } },
            scales: {}
        }, extra || {});
    }

    let juniorChart, seniorChart;

    if (juniorCanvas) {
        prepareCanvas(juniorCanvas);
        const ctxJunior = juniorCanvas.getContext('2d');
        juniorChart = new Chart(ctxJunior, {
            type: 'bar',
            data: {
                labels: juniorLabels,
                datasets: [{
                    label: 'Junior High Sections',
                    data: juniorData,
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: buildOptions({
                scales: {
                    x: { title: { display: true, text: 'Grade Levels' } },
                    y: { beginAtZero: true, title: { display: true, text: 'Number of Sections' } }
                }
            })
        });
    }

    if (seniorCanvas) {
        prepareCanvas(seniorCanvas);
        const ctxSenior = seniorCanvas.getContext('2d');
        seniorChart = new Chart(ctxSenior, {
            type: 'bar',
            data: {
                labels: seniorLabels,
                datasets: [{
                    label: 'Senior High Sections',
                    data: seniorData,
                    backgroundColor: 'rgba(255, 159, 64, 0.5)',
                    borderColor: 'rgba(255, 159, 64, 1)',
                    borderWidth: 1
                }]
            },
            options: buildOptions({
                scales: { y: { beginAtZero: true } }
            })
        });
    }

    // Re-sync on resize to keep hover accurate
    window.addEventListener('resize', () => {
        if (juniorCanvas && juniorChart) {
            prepareCanvas(juniorCanvas);
            juniorChart.resize();
        }
        if (seniorCanvas && seniorChart) {
            prepareCanvas(seniorCanvas);
            seniorChart.resize();
        }
    });
});
function toggleSubMenu(event) {
    event.preventDefault();
    const submenu = event.target.nextElementSibling;
    submenu.classList.toggle('hidden');
  }

