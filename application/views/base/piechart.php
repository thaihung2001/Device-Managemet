<script type="text/javascript">
  let xPie = [];
  let yPie = [];
  $.ajax({
    url: '<?php echo site_url("pieChart"); ?>',
    type: 'get',
    dataType: 'json',
    success: function(response) {
      //console.log(response.label);
      $.each(response.pieData, function(index, device) {
        //console.log(device);
        xPie.push(device.type);
        yPie.push(device.count);
      });
      //Vẽ biểu đồ
      pieChart(xPie,yPie);
    },
    error: function(xhr, status, error) {
      console.error('An error occurred:', error);
      alert('Vui lòng thử lại, có lỗi.');
    }
  });
  function pieChart(label,value)
  {
    const xPieChartValues = label; //["Screen", "Keyboard", "Mouse", "CPU", "Switch"];
      const yPieChartValues = value; //[55, 49, 44, 24, 15];
      /* const barPieChartColors = [
        "#bd1e24",
        "#00477e",
        "#964f8e",
        "#ee9600",
        "#1e7145"
      ]; */
      const barPieChartColors =generateBarChartColors(xPieChartValues.length);
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
  }
</script>