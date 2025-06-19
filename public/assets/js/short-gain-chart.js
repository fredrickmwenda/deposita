
document.addEventListener("DOMContentLoaded", function() {
    let chartType = 'month'; // Default view
    const currentYear = new Date().getFullYear();
    const currentMonth = new Date().getMonth() + 1;
    const currentDay = new Date().getDate();

    // Initialize year selector
    const yearSelect = document.getElementById('yearSelect');
    for (let year = 2020; year <= 2030; year++) {
        const option = document.createElement('option');
        option.value = year;
        option.textContent = year;
        if (year === currentYear) option.selected = true;
        yearSelect.appendChild(option);
    }

    function updateChart(type, period) {
        fetch(`/api/short-gain-stats?type=${type}&period=${period}`)
            .then(response => response.json())
            .then(data => {
                // Update attendant performance list
                if (data.attendants) {
                    const performanceList = document.getElementById('attendantPerformanceList');
                    performanceList.innerHTML = data.attendants.map(attendant => `
                        <div class="bg-light p-3 d-flex mb-3">
                            <img src="assets/images/users/avatar-2.jpg" alt="" class="avatar-sm rounded me-3">
                            <div class="flex-grow-1">
                                <h5 class="font-size-15 mb-2">
                                    <a href="#" class="text-body">${attendant.name}</a>
                                </h5>
                                <p class="mb-0 text-muted">
                                    <i class="bx bx-trending-${attendant.difference >= 0 ? 'up text-success' : 'down text-danger'} align-middle"></i>
                                    Short/Gain: ${attendant.difference.toLocaleString()}
                                </p>
                            </div>
                        </div>
                    `).join('');
                }
            })
            .catch(error => console.error('Error:', error));
    }

    // Event listeners for navigation pills
    document.querySelectorAll('.nav-pills .nav-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all links
            document.querySelectorAll('.nav-pills .nav-link').forEach(l => {
                l.classList.remove('active');
            });
            
            // Add active class to clicked link
            this.classList.add('active');
            
            const view = this.getAttribute('data-period');
            chartType = view;
            
            switch(view) {
                case 'year':
                    updateChart('year', yearSelect.value);
                    break;
                case 'month':
                    updateChart('month', `${yearSelect.value}-${currentMonth}`);
                    break;
                case 'week':
                    updateChart('week', `${yearSelect.value}-W${getCurrentWeek()}`);
                    break;
                case 'day':
                    updateChart('day', `${yearSelect.value}-${currentMonth}-${currentDay}`);
                    break;
            }
        });
    });

    // Year selector change event
    yearSelect.addEventListener('change', function() {
        updateChart(chartType, this.value);
    });

    // Initial chart load
    updateChart('month', `${currentYear}-${currentMonth}`);
});

function getCurrentWeek() {
    const now = new Date();
    const onejan = new Date(now.getFullYear(), 0, 1);
    return Math.ceil((((now - onejan) / 86400000) + onejan.getDay() + 1) / 7);
}