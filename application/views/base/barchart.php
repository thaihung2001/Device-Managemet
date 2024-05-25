<script type="text/javascript">
  let xBar = [];
  let yBar = [];
  $.ajax({
    url: '<?php echo site_url("barChart"); ?>',
    type: 'get',
    dataType: 'json',
    success: function(response) {
      //console.log(response.barData);
      $.each(response.barData, function(index, branch) {
        xBar.push(branch.name);
        yBar.push(branch.totalDevice);
      });
      //console.log("xBar:", xBar, "yBar:", yBar);
      //Vẽ biểu đồ
      barChart(xBar, yBar);
    },
    error: function(xhr, status, error) {
      console.error('An error occurred:', error);
      alert('Vui lòng thử lại, có lỗi.');
    }
  });

  function barChart(xBar, yBar) {
    const xBarChartValues = xBar; //["Italy", "France", "Spain", "USA", "Argentina"];
    const yBarChartValues = yBar; //[55, 49, 44, 24, 15];
    // const barBarChartColors = ["red", "green", "blue", "orange"];

    // Tạo danh sách màu sắc cho biểu đồ
    const barBarChartColors = generateBarChartColors(xBarChartValues.length);
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
        legend: {
          display: false
        },
        title: {
          display: true,
          text: "Thiết bị các chi nhánh"
        },
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        }
      }
    });
  }
</script>