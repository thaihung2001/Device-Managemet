<nav class="navbar navbar-inverse visible-xs">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo site_url('dashboard'); ?>">Hệ thống quản lý kho</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="<?php echo site_url('dashboard'); ?>">Tổng quan</a></li>
        <li><a href="<?php echo site_url('branch'); ?>">Chi nhánh công ty</a></li>
        <li><a href="<?php echo site_url('device'); ?>">Thiết bị công ty</a></li>
        <li><a href="#" class="logoutButton">Đăng xuất</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container-fluid">
  <div class="row content">
    <div class="col-sm-3 sidenav hidden-xs">
      <h2>Quản lý hệ thống</h2>
      <ul class="nav nav-pills nav-stacked">
        <li class="active"><a href="<?php echo site_url('dashboard'); ?>">Tổng quan</a></li>
        <li><a href="<?php echo site_url('branch'); ?>">Chi nhánh công ty</a></li>
        <li><a href="<?php echo site_url('device'); ?>">Thiết bị công ty</a></li>
        <li><a href="#" class="logoutButton">Đăng xuất</a></li>
      </ul><br>
    </div>
    <br>

    <div class="col-sm-9">
      <div class="row">
        <div class="col-sm-5">
          <div class="well">
            <h4>Kho</h4>
            <p>Tổng thiết bị: <b><?php echo $totalDevice; ?></b> thiết bị, <b style="color:#a78a1a;"><?php echo $totalGrantedDevice; ?></b>(đã cấp), <b style="color:blue;"><?php echo ($totalDevice - $totalGrantedDevice); ?></b>(tồn kho)</p>
            <p>Trạng thái thiết bị: <b style="color:green;"><?php echo $totalActive; ?></b>(hoạt động), <b style="color:red;"><?php echo $totalDeactive; ?></b>(không hoạt động)</p>
          </div>
        </div>
        <div class="col-sm-2">
          <div class="well" style="height:139.8px">
            <button class="btn btn-primary" id="addAction">Cấp phát </button>
            <hr>
            <button class="btn btn-danger" id="revokeAction">Thu hồi </button>
          </div>
        </div>
        <div class="col-sm-5">
          <div class="well" style="height:139.8px">
            <h4>Chi nhánh</h4>
            <p>Tổng chi nhánh: <b><?php echo $totalBranch; ?></b> chi nhánh</p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-6">
          <div class="well">
            <canvas id="PieChart" style="width:100%;"></canvas>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="well">
            <canvas id="BarChart" style="width:100%;"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- modal add device to branch -->
<div id="grantDeviceModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Cấp phát thiết bị đến chi nhánh</h4>
      </div>
      <form id="formGrant" class="form-inline">
        <div class="modal-body">
          <div class="form-group">
            <label for="nameDevice">Thiết bị : </label>
            <input type="text" name="nameDevice" id="nameDevice" class="form-control" placeholder="Nhập vào tên thiết bị" required autocomplete="off">

          </div>
          <div class="form-group" style="padding-left:15px; padding-right:15px;">
            <label for="idBranch">Chi nhánh : </label>
            <select name="idBranch" id="idBranch" class="form-control" required>
              <option value="">Chọn chi nhánh</option>
            </select>
          </div>
          <div class="form-group">
            <label for="numDevice">Số lượng : </label>
            <input type="number" name="numDevice" class="form-control" id="numDevice" value="1" min="1" required>
          </div>
          <input type="hidden" name="idDevice" id="idDevice">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
          <button type="submit" class="btn btn-primary">Lưu</button>
        </div>
      </form>
      <ul class="list-group">
        <li class="list-group-item" id="suggestions"></li>
      </ul>
    </div>

  </div>
</div>
<!-- /// -->
<script type="text/javascript">
  //render data in modal
  let dataDevice = <?php echo json_encode($allDevice) ?>;
  // Hàm để hiển thị các đề xuất
  function showSuggestions(value) {
    let filteredDevices = dataDevice.filter(function(device) {
      return device.name.toLowerCase().includes(value.toLowerCase());
    });

    let $suggestions = $('#suggestions');
    $suggestions.empty();

    if (filteredDevices.length > 0) {
      filteredDevices.forEach(function(device) {
        let $item = $('<li class="list-group-item"></li>').text(device.name + ' - ' + device.type);
        $item.on('click', function() {
          $('#nameDevice').val(device.name); //fill vào input
          $('#idDevice').val(device.id); //fill vào ID hidden
          $suggestions.empty();
        });
        $suggestions.append($item);
      });
      $suggestions.show();
    } else {
      $suggestions.hide();
    }
  }
  // Sự kiện khi nhập vào ô input
  $('#nameDevice').on('input', function() {
    let value = $(this).val();
    if (value) {
      showSuggestions(value);
    } else {
      $('#suggestions').empty().hide();
      $('#idDevice').val('');
    }
  });

  // Ẩn đề xuất khi click ra ngoài
  $(document).on('click', function(event) {
    if (!$(event.target).closest('.form-group').length) {
      $('#suggestions').empty().hide();
    }
  });

  //render data in select option branch 
  let dataBranch = <?php echo json_encode($allBranch) ?>;
  let $select = $('#idBranch');
  $.each(dataBranch, function(index, branch) {
    let $option = $('<option>', {
      value: branch.id,
      text: branch.name
    });
    $select.append($option);
  });
  console.log("DEVICE:", dataDevice, "BRANCH:", dataBranch);
  $(document).ready(function() {
    //Open modal grant device to branch
    $("#addAction").on("click", function() {
      $('#grantDeviceModal').modal('show');

    });

    //submit form grant device to branch
    $('#formGrant').submit(function(event) {
      event.preventDefault();
      if ($('#idDevice').val() == "" || $('#idBranch').val() == "" ) {
        alert("Thông tin chưa chính xác! Vui lòng chọn tên thiết bị được hiển thị dưới danh sách khi nhập! ");
        return;
      }
      let formData = $(this).serialize();
      $.ajax({
        url: '<?php echo site_url("insertInventory"); ?>',
        type: 'POST',
        dataType: 'json',
        data: formData,
        success: function(response) {
          //console.log(response);
          if (response.status) {
            $('#formGrant')[0].reset();
            $('#grantDeviceModal').modal('hide');
            alert(response.message);
            //loadTable(); //load lại bảng
          } else {
            alert(response.message);
          }
        },
        error: function(xhr, status, error) {
          console.error('An error occurred:', error);
          alert('Vui lòng thử lại, có lỗi.');
        }
      });
    });
  });
</script>