document.addEventListener("DOMContentLoaded", function () {
    const juniorCanvas = document.getElementById('juniorChart');
    const seniorCanvas = document.getElementById('seniorChart');


    console.log('canvas elements:', juniorCanvas, seniorCanvas);
    
    if (juniorCanvas) {
        const ctxJunior = juniorCanvas.getContext('2d');
        new Chart(ctxJunior, {
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
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Grade Levels'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Sections'
                        }
                    }
                }
            }
        });
        
    }

    if (seniorCanvas) {
        const ctxSenior = seniorCanvas.getContext('2d');
        new Chart(ctxSenior, {
            type: 'bar',
            data: {
                labels: seniorLabels,  // Labels for the X-axis
                datasets: [{
                    label: 'Senior High Sections',
                    data: seniorData,  // Data for the Y-axis
                    backgroundColor: 'rgba(255, 159, 64, 0.5)',
                    borderColor: 'rgba(255, 159, 64, 1)',
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
        
    }
});
function toggleSubMenu(event) {
    event.preventDefault();
    const submenu = event.target.nextElementSibling;
    submenu.classList.toggle('hidden');
  }

