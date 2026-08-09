import 'bootstrap/dist/css/bootstrap.min.css'; //bez teego nie dzialaja style w admin/dashboard
import 'bootstrap';

import Chart from 'chart.js/auto';
import feather from 'feather-icons';

feather.replace();

const ctx = document.getElementById("myChart");
if (ctx) {
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
            datasets: [{
                data: [15339, 21345, 18483, 24003, 23489, 24092, 12034],
                borderColor: '#007bff',
                borderWidth: 2,
                fill: false
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: false
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
}
