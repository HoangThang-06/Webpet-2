const ctx = document.getElementById("registrationChart").getContext("2d");

const registrationChart = new Chart(ctx, {
  type: "bar",
  data: {
    labels: [
      "Tháng 1",
      "Tháng 2",
      "Tháng 3",
      "Tháng 4",
      "Tháng 5",
      "Tháng 6",
      "Tháng 7",
      "Tháng 8",
      "Tháng 9",
      "Tháng 10",
      "Tháng 11",
      "Tháng 12",
    ],
    datasets: [
      {
        label: "Số người đăng ký",
        data: monthlyData,
        backgroundColor: "rgba(0,123,255,0.6)",
        borderColor: "rgba(0,123,255,1)",
        borderWidth: 1,
      },
    ],
  },
  options: {
    responsive: true,
    scales: {
      y: { beginAtZero: true },
    },
  },
});
