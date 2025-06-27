// === BIỂU ĐỒ 1: sessions-overview-users ===
var userColors = $("#sessions-overview-users").data("colors") || "#727cf5,#0acf97,#fa5c7c,#ffbc00";
var userChartColors = userColors.split(",");

// === BIỂU ĐỒ 2: gender-chart ===
var genderColors = $("#gender-chart").data("colors") || "#727cf5,#0acf97,#fa5c7c,#ffbc00";
var genderChartColors = genderColors.split(",");

var genderChartOptions = {
    chart: { height: 277, type: "donut" },
    legend: { show: false },
    stroke: { width: 0 },
    plotOptions: {
        pie: {
            donut: {
                size: "75%",
                labels: {
                    show: true,
                    total: {
                        showAlways: true,
                        show: true,
                        label: "tổng số",
                        formatter: function (w) {
                            return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                        },
                    },
                },
            },
        },
    },
    series: [failed, passed],
    labels: ["Không đạt", "đạt"],
    colors: genderChartColors,
    dataLabels: { enabled: false },
    responsive: [
        {
            breakpoint: 480,
            options: {
                chart: { width: 200 },
            },
        },
    ],
};

var genderChart = new ApexCharts(
    document.querySelector("#gender-chart"),
    genderChartOptions
);
genderChart.render();
