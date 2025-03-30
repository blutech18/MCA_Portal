document.addEventListener("DOMContentLoaded", function () {
    const chartCanvas = document.getElementById('strandChart');
    if (chartCanvas) {
        const ctx = chartCanvas.getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: strandLabels,  // Should be set from Blade
                datasets: [{
                    label: 'Number of Sections',
                    data: strandSections, // Should be set from Blade
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    } else {
        console.error("Canvas element with id 'strandChart' not found");
    }
});
