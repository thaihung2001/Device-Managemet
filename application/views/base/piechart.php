
<script type="text/javascript">
const xPieChartValues = ["Screen", "Keyboard", "Mouse", "CPU", "Switch"];
const yPieChartValues = [55, 49, 44, 24, 15];
const barPieChartColors = [
  "#b91d47",
  "#00aba9",
  "#2b5797",
  "#e8c3b9",
  "#1e7145"
];

new Chart("PieChart", {
  type: "pie",
  data: {
    labels: xPieChartValues,
    datasets: [{
      backgroundColor: barPieChartColors,
      data: yPieChartValues
    }]
  },
  options: {
    title: {
      display: true,
      text: "Tổng quan danh mục của thiết bị"
    }
  }
});
</script>
