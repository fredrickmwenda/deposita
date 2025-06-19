document.addEventListener("DOMContentLoaded", function() {
    let chartType = 'year'; // Changed default to year
    const currentYear = new Date().getFullYear();
    const currentMonth = new Date().getMonth() + 1;
    const currentDay = new Date().getDate();

    // Initialize short/gain bar chart
    const shortGainOptions = {
        chart: {
            type: 'bar',
            height: 350,
            toolbar: {
                show: true
            },
            animations: {
                enabled: true
            }
        },
        plotOptions: {
            bar: {
                colors: {
                    ranges: [{
                        from: -Infinity,
                        to: 0,
                        color: '#f46a6a'  // red for negative
                    }, {
                        from: 0.001,
                        to: Infinity,
                        color: '#34c38f'  // green for positive
                    }]
                },
                columnWidth: '60%',
                distributed: false
            }
        },
        dataLabels: {
            enabled: true,
            formatter: function(val) {
                return formatNumber(val);
            }
        },
        series: [{
            name: 'Short/Gain',
            data: []
        }],
        xaxis: {
            type: 'category',
            categories: [],
            labels: {
                show: true,
                rotate: -45,
                rotateAlways: false,
                style: {
                    fontSize: '12px'
                }
            },
            axisBorder: {
                show: true
            },
            axisTicks: {
                show: true
            }
        },
        yaxis: {
            labels: {
                formatter: function(val) {
                    return formatNumber(val);
                },
                show: true
            },
            axisBorder: {
                show: true
            },
            axisTicks: {
                show: true
            },
            min: function(min) { return min < 0 ? min : 0; }
        },
        grid: {
            show: true,
            borderColor: '#90A4AE',
            strokeDashArray: 0,
            xaxis: {
                lines: {
                    show: true
                }
            },
            yaxis: {
                lines: {
                    show: true
                }
            }
        },
        title: {
            text: 'Short/Gain Statistics',
            align: 'center'
        },
        noData: {
            text: 'No data available',
            align: 'center',
            verticalAlign: 'middle',
            style: {
                fontSize: '16px'
            }
        }
    };

    function formatNumber(number) {
        return number.toLocaleString(undefined, {
            minimumFractionDigits: 0,
            maximumFractionDigits: 2
        });
    }

    const shortGainChart = new ApexCharts(document.querySelector("#shortGainChart"), shortGainOptions);
    shortGainChart.render();

    // Initialize year selector
    const yearSelect = document.getElementById('yearSelect');
    for (let year = 2020; year <= 2030; year++) {
        const option = document.createElement('option');
        option.value = year;
        option.textContent = year;
        if (year === currentYear) option.selected = true;
        yearSelect.appendChild(option);
    }

    function updateCharts(type, period) {
        console.log('Updating charts with:', { type, period });

        // Set categories based on type
        const categories = {
            year: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            month: Array.from({length: 31}, (_, i) => i + 1),
            week: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            day: ['Day Shift', 'Night Shift']
        };

        // Update chart categories
        shortGainChart.updateOptions({
            xaxis: { categories: categories[type] }
        });

        // Show loading state
        document.getElementById('attendantPerformanceTable').innerHTML = `
            <tr><td colspan="4" class="text-center">
                <div class="spinner-border spinner-border-sm text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                Loading data...
            </td></tr>
        `;

        // Construct the period parameter
        let periodParam;
        switch(type) {
            case 'year':
                periodParam = period;
                break;
            case 'month':
                periodParam = `${period}-${currentMonth}`;
                break;
            case 'week':
                periodParam = `${period}-W${getCurrentWeek()}`;
                break;
            case 'day':
                periodParam = `${period}-${currentMonth}-${currentDay}`;
                break;
        }

        // Fetch data
        fetch(`/api/short-gain-stats?type=${type}&period=${periodParam}`)
            .then(response => response.json())
            .then(data => {
                console.log('API response:', {
                    type,
                    periodParam,
                    rawData: data,
                    monthlyData: data.monthlyData,
                    dailyData: data.dailyData,
                    weeklyData: data.weeklyData,
                    shiftData: data.shiftData
                });

                // Map the data based on type
                let chartData = [];
                const defaultData = {
                    year: Array(12).fill(0),
                    month: Array(31).fill(0),
                    week: Array(7).fill(0),
                    day: Array(2).fill(0)
                };

                try {
                    switch(type) {
                        case 'year':
                            chartData = Array.isArray(data.monthlyData) ? data.monthlyData : defaultData.year;
                            break;
                        case 'month':
                            chartData = Array.isArray(data.dailyData) ? data.dailyData : defaultData.month;
                            break;
                        case 'week':
                            chartData = Array.isArray(data.weeklyData) ? data.weeklyData : defaultData.week;
                            break;
                        case 'day':
                            chartData = Array.isArray(data.shiftData) ? data.shiftData : defaultData.day;
                            break;
                        default:
                            chartData = defaultData[type] || [];
                    }

                    // Ensure we have numbers and handle any invalid values
                    chartData = chartData.map(val => {
                        const number = parseFloat(val);
                        return isNaN(number) ? 0 : number;
                    });
                } catch (error) {
                    console.error('Error processing chart data:', error);
                    chartData = defaultData[type] || [];
                }

                // Update chart with processed data
                shortGainChart.updateSeries([{
                    name: 'Short/Gain',
                    data: chartData
                }]);

                // Update attendant table
                updateAttendantTable(data.attendants, periodParam);
            })
            .catch(error => {
                console.error('Error updating data:', error);
                shortGainChart.updateSeries([{
                    name: 'Short/Gain',
                    data: []
                }]);
                document.getElementById('attendantPerformanceTable').innerHTML = `
                    <tr>
                        <td colspan="4" class="text-center text-danger">
                            Error loading data. Please try again.
                        </td>
                    </tr>
                `;
            });
    }

    function updateAttendantTable(attendants, period) {
        const tableBody = document.getElementById('attendantPerformanceTable');
        const totalShortGainElement = document.getElementById('totalShortGain');
        
        if (!attendants || !Array.isArray(attendants) || attendants.length === 0) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="4" class="text-center">No data available for this period</td>
                </tr>
            `;
            totalShortGainElement.textContent = '0';
            return;
        }

        try {
            // Calculate total absolute difference for percentage calculation
            const totalAbsDifference = attendants.reduce((sum, a) => sum + Math.abs(parseFloat(a.difference) || 0), 0);
            
            // Sort attendants by absolute difference
            const sortedAttendants = attendants.sort((a, b) => 
                Math.abs(parseFloat(b.difference) || 0) - Math.abs(parseFloat(a.difference) || 0)
            );

            // Calculate total short/gain
            const totalShortGain = attendants.reduce((sum, a) => sum + (parseFloat(a.difference) || 0), 0);
            totalShortGainElement.textContent = formatNumber(totalShortGain);

            // Generate table rows
            tableBody.innerHTML = sortedAttendants.map((attendant, index) => {
                const difference = parseFloat(attendant.difference) || 0;
                const percentage = totalAbsDifference ? 
                    ((Math.abs(difference) / totalAbsDifference) * 100).toFixed(1) : 0;
                
                const trendIcon = difference >= 0 ? 
                    '<i class="bx bx-trending-up text-success"></i>' : 
                    '<i class="bx bx-trending-down text-danger"></i>';

                return `
                    <tr>
                        <td><strong>#${index + 1}</strong></td>
                        <td>${attendant.name || 'Unknown'}</td>
                        <td>
                            ${trendIcon} 
                            <span class="text-${difference >= 0 ? 'success' : 'danger'}">
                                ${formatNumber(difference)}
                            </span>
                        </td>
                        <td>${percentage}%</td>
                    </tr>
                `;
            }).join('');
        } catch (err) {
            console.error('Error updating attendant table:', err);
            tableBody.innerHTML = `
                <tr>
                    <td colspan="4" class="text-center text-danger">
                        Error processing data. Please try again.
                    </td>
                </tr>
            `;
            totalShortGainElement.textContent = '0';
        }
    }

    // Set initial active state for year view
    document.querySelectorAll('.nav-pills .nav-link').forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('data-period') === 'year') {
            link.classList.add('active');
        }
    });

    // Event listeners for navigation pills
    document.querySelectorAll('.nav-pills .nav-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelectorAll('.nav-pills .nav-link').forEach(l => {
                l.classList.remove('active');
            });
            this.classList.add('active');
            chartType = this.getAttribute('data-period');
            updateCharts(chartType, yearSelect.value);
        });
    });

    // Year selector change event
    yearSelect.addEventListener('change', function() {
        updateCharts(chartType, this.value);
    });

    // Initial chart load with year view
    updateCharts('year', currentYear);
});

function getCurrentWeek() {
    const now = new Date();
    const onejan = new Date(now.getFullYear(), 0, 1);
    return Math.ceil((((now - onejan) / 86400000) + onejan.getDay() + 1) / 7);
}
