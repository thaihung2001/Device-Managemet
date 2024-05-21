
<script type="text/javascript">

const xBarChartValues = ["Italy", "France", "Spain", "USA", "Argentina"];
const yBarChartValues = [55, 49, 44, 24, 15];
const barBarChartColors = ["red", "green","blue","orange","brown"];

new Chart("BarChart", {
  type: "bar",
  data: {
    labels: xBarChartValues,
    datasets: [{
      backgroundColor: barBarChartColors,
      data: yBarChartValues
    }]
  },
  options: {
    legend: {display: false},
    title: {
      display: true,
      text: "Thiết bị các chi nhánh"
    }
  }
});
</script>