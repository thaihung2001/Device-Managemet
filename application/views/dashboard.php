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
          <div class="well" style="height:139.8px">
            <h4>Kho: <b><?php echo $totalDevice; ?></b>(danh mục)</h4>
            <p>Tổng thiết bị: <b style="color:blue;"><?php echo $totalGrantedDevice; ?></b></p>
            <p>Trạng thái thiết bị: <b style="color:green;"><?php echo $totalActive; ?></b>(hoạt động), <b style="color:red;"><?php echo $totalDeactive; ?></b>(không hoạt động)</p>
          </div>
        </div>
        <div class="col-sm-2">
          <div class="well" style="height:139.8px">
            <div class="row" style="text-align:center;">
              <button class="btn btn-primary" id="grantAction">Hành động</button>
            </div>
            <hr>
            <div class="row" style="text-align:center;">
              <button class="btn btn-warning" id="revokeAction">Quản lý </button>
            </div>
          </div>
        </div>
        <div class="col-sm-5">
          <div class="well" style="height:139.8px">
            <h4>Chi nhánh</h4>
            <p>Tổng chi nhánh: <b><?php echo $totalBranch; ?></b> chi nhánh</p>
          </div>
        </div>
      </div>
      <!-- Nhập mới thiết bị -->
      <div class="col-12" style="display:none;" id="grantDeviceToBranch">
        <div class="well">
          <h4>Nhập / Xuất thiết bị đến chi nhánh</h4>
          <form id="formGrant" class="form">
            <div class="form-group">
              <div class="col-sm-6">
                <label for="idAction">Loại hành động : </label>
                <select name="idAction" id="idAction" class="form-control" required>
                  <option value="">Nhãn hành động</option>
                  <option value="import">Nhập thiết bị mới</option>
                  <option value="export">Xuất kho</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-6">
                <label for="numDevice">Số lượng : </label>
                <input type="number" name="numDevice" class="form-control" id="numDevice" value="1" min="1" required>
              </div>
            </div>
            <br>
            <div class="form-group">
              <div class="col-sm-4 export" style="display:none;">
                <label for="idBranchFrom">Chi nhánh xuất: </label>
                <select name="idBranchFrom" id="idBranchFrom" class="form-control idBranch">
                  <option value="">Chọn chi nhánh</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <div class="col-sm-4">
                <label for="idDevice">Thiết bị : </label>
                <select name="idDevice" id="idDevice" class="form-control" required>
                  <option value="">Chọn thiết bị</option>
                </select>
              </div>
            </div>

            <div class="form-group import">
              <div class="col-sm-4">
                <label for="idBranchTo">Chi nhánh nhập: </label>
                <select name="idBranchTo" id="idBranchTo" class="form-control idBranch" required>
                  <option value="">Chọn chi nhánh</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12 export" style="display:none;">
                <label for="note">Ghi chú: </label>
                <textarea name="note" id="note" class="form-control">
                </textarea>
              </div>
            </div>
            <br>
            <button type="submit" class="btn btn-primary" style="margin-top: 25px;" id="btn-action">Thực thi</button>
          </form>
          <br>
          <div class="row">
            <div class="col-sm-6" style="border-right:0.5px solid black;">
              <button class="btn btn-default" id="addDevice">+ Thiết bị</button>
              <!-- form thêm nhanh tên thiết bị -->
              <form id="deviceForm" style="display:none;">
                <div class="form-group">
                  <input type="text" class="form-control" id="deviceName" name="name" placeholder="Tên thiết bị mới" required>
                </div>
                <div class="form-group">
                  <textarea class="form-control" row="1" name="description" id="deviceDescription" placeholder="Mô tả thiết bị mới" required></textarea>
                </div>
                <div class="form-group">
                  <input type="date" class="form-control" id="deviceDateBuy" name="date_buy" required>
                </div>
                <div class="form-group">
                  <select class="form-control" id="deviceActive" name="active" required>
                    <option value="1">Đang hoạt động</option>
                    <option value="0">Không hoạt động</option>
                  </select>
                </div>
                <div class="form-group">
                  <input type="number" class="form-control" id="quantity" name="quantity" min="1" value="1" required>
                </div>
                <div class="form-group"><button type="submit" class="btn btn-primary">Thêm mới</button></div>
              </form>
            </div>
            <div class="col-sm-6">
              <button class="btn btn-default" id="addBranch">+ Chi nhánh</button>
              <!-- form thêm nhanh chi nhánh -->
              <form id="createBranchForm" style="display:none;">
                <div class="form-group">
                  <input type="text" class="form-control" id="createNameBranch" placeholder="Nhập tên chi nhánh mới" name="createNameBranch">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" id="createAddressBranch" placeholder="Nhập địa chỉ chi nhánh" name="createAddressBranch">
                </div>
                <div class="form-group"><button type="submit" class="btn btn-primary">Thêm mới</button></div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- /// -->
      <!-- Thu hồi thiết bị -->
      <div class="col-12" style="display:none;" id="revokeDeviceFromBranch">
        <div class="well" style="text-align:center;">
          <h4>Quản lý thiết bị đã cấp phát</h4>
          <div class="row">
            <div class="col-sm-4">
              <select name="branchRevoke" id="branchRevoke" class="form-control">
              </select>
            </div>
          </div>
          <table class="table" id="dataInventory">
            <thead>
              <tr>
                <td>STT</td>
                <td>Tên thiết bị</td>
                <td>Số lượng</td>
                <td>Trạng thái</td>
                <td>Thời gian tạo</td>
                <td>Người tạo</td>
                <td>Thời gian cập nhật</td>
                <td>Người cập nhật</td>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
      <!-- /// -->
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
<!-- modal grant device to branch -->
<div id="grantDeviceModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <form id="">
        <div class="modal-body">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
          <button type="submit" class="btn btn-primary">Lưu</button>
        </div>
      </form>

    </div>

  </div>
</div>
<!-- model revoke devicce from branch -->
<div id="revokeDeviceModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Thu hồi</h4>
      </div>
      <form class="form" id="formRevoke">
        <div class="modal-body">
          <input type="hidden" id="inventoryId" name="inventoryId">
          <div class="form-group">
            <label for="deviceRevokeName">Tên thiết bị</label>
            <input type="text" class="form-control" id="deviceRevokeName" name="deviceRevokeName" placeholder="" required>
          </div>
          <div class="form-group">
            <label for="deviceRevokeQuantity">Số lượng</label>
            <input type="number" class="form-control" id="deviceRevokeQuantity" min="1" name="deviceRevokeQuantity" placeholder="" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
          <button type="submit" class="btn btn-primary" id="actionRevoke">Lưu thay đổi</button>
        </div>
      </form>

    </div>

  </div>
</div>
<!-- /// -->
<script type="text/javascript">
  //render data in modal
  let dataDevice = <?php echo json_encode($allDevice) ?>;
  let dataBranch = <?php echo json_encode($allBranch) ?>;

  //console.log("DEVICE:", dataDevice, "BRANCH:", dataBranch);

  //render data table in revoke modal 
  function renderTableBody(data) {
    $(".table tbody").empty();
    $.each(data, function(index, item) {
      let $row = $("<tr>");
      $row.append($("<td>").text(index + 1));
      $row.append($("<td class='deviceName'>").text(item.device_name));
      $row.append($("<td class='grantQuantity'>").text(item.quantity));
      $row.append($("<td class='grantStatus'>").text(item.status)); //formatDateTable(item.date_buy)
      $row.append($("<td class='created_at'>").text(item.created_at));
      $row.append($("<td class='user_name'>").text(item.user_name));
      $row.append($("<td class='updated_at'>").text(item.updated_at));
      $row.append($("<td class='updated_by'>").text(item.updated_by));
      //$row.append($("<td class=''>").text(item.active == "1" ? "Đang hoạt động" : "Không hoạt động").addClass(item.active == "1" ? "text-success" : "text-danger"));
      let $actionTd = $("<td>");
      let $deleteButton = $("<button>").text("Thu hồi").addClass("btn btn-danger btn-sm").attr("data-id", item.inventory_id);
      $actionTd.append($deleteButton);
      $row.append($actionTd);
      $(".table tbody").append($row);
    });
  }

  function renderSelectDevice(data) {
    let $selectDevice = $('#idDevice');
    $selectDevice.empty();
    $selectDevice.append('<option value="">Chọn thiết bị</option>');
    $.each(data, function(index, device) {
      let $optionDevice = $('<option>', {
        value: device.id,
        text: device.name
      });
      $selectDevice.append($optionDevice);
    });
  }

  function renderSelectBranch(select, data) {
    let $selectBranch = select;
    $selectBranch.empty();
    $selectBranch.append('<option value="">Chọn chi nhánh</option>');
    $.each(data, function(index, branch) {
      let $optionBranch = $('<option>', {
        value: branch.id,
        text: branch.name
      });
      $selectBranch.append($optionBranch);
    });
  }

  function openRevokeModal(id, name, quantity, status) {
    $('#inventoryId').val(id);
    $('#deviceRevokeName').val(name);
    $('#deviceRevokeName').attr('disabled', true);
    $('#deviceRevokeQuantity').val(quantity);
    $('#deviceRevokeQuantity').attr('max', quantity);
    $('#revokeDeviceModal').modal('show');
  }
  $(document).ready(function() {
    //Open slide grant device to branch
    $("#grantAction").on("click", function() {
      $("#grantDeviceToBranch").slideToggle("slow");
      //render data in select option device (Grant-modal)
      renderSelectDevice(dataDevice);
      //render data in select option branch (Grant-modal)
      let selected = $('.idBranch');
      renderSelectBranch(selected, dataBranch);
    });
    // open slide add device
    $("#addDevice").on("click", function() {
      $("#deviceForm").slideToggle("slow");
    });
    //submit form #deviceForm
    $('#deviceForm').submit(function(event) {
      event.preventDefault();
      let formData = $(this).serialize();
      $.ajax({
        url: '<?php echo site_url("insertDevice"); ?>',
        type: 'POST',
        dataType: 'json',
        data: formData,
        success: function(response) {
          if (response.status) {
            alert(response.message);
            $('#deviceForm')[0].reset();
            $('#deviceForm').hide();
            dataDevice = response.devices;
            renderSelectDevice(response.devices);
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

    // open slide add branch
    $("#addBranch").on("click", function() {
      $("#createBranchForm").slideToggle("slow");
    });

    // submit form #createBranchForm
    $('#createBranchForm').submit(function(event) {
      event.preventDefault();
      let formCreateData = $(this).serialize();
      $.ajax({
        url: '<?php echo site_url("insertBranch"); ?>',
        type: 'POST',
        dataType: 'json',
        data: formCreateData,
        success: function(response) {
          if (response.status) {
            alert(response.message);
            $('#createBranchForm')[0].reset();
            $('#createBranchForm').hide();
            dataBranch = response.branchs;
            let selected = $('.idBranch');
            renderSelectBranch(selected, response.branchs);
          } else {
            alert(response.message);
          }
        },
        error: function(xhr, status, error) {
          console.error('Vui lòng thử lại, có lỗi xảy ra.');
        }
      });
    });
    //Lắng nghe khi chọn nhãn hành động
    $('#idAction').on('change', function() {
      let type = $(this).val();
      if (type === 'import') {
        $('#btn-action').show();
        $('.export').hide();
      } else if (type == 'export') {
        $('.export').show();
        $('#note').show();
      } else {
        $('#btn-action').hide();
        $('.export').hide();
      }
      console.log(type);
    });


    //submit form grant device to branch
    $('#formGrant').submit(function(event) {
      event.preventDefault();

      if ($('#idAction').val() == 'import') {
        if ($('#idDevice').val() == "" || $('#idBranchTo').val() == "") {
          alert("Thông tin chưa đầy đủ! ");
          return;
        }
      }

      if ($('#idAction').val() == 'export') {
        if ($('#idDevice').val() == "" || $('#idBranchFrom').val() == "" || $('#idBranchTo').val() == "" || $('#note').val() == "") {
          alert("Thông tin chưa đầy đủ! ");
          return;
        }
      }

      let formData = $(this).serialize();
      //console.log(formData);
      $.ajax({
        url: '<?php echo site_url("insertInventoryHistory"); ?>',
        type: 'POST',
        dataType: 'json',
        data: formData,
        success: function(response) {
          console.log(response);return;
          if (response.status) {
            alert(response.message);
            $('#formGrant')[0].reset();
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

    //Open slide revoke device from branch
    $("#revokeAction").on("click", function() {
      $("#revokeDeviceFromBranch").slideToggle("slow");
      let branch_select = $('#branchRevoke');
      renderSelectBranch(branch_select, dataBranch);
    });
    // Lắng nghe sự kiện khi chọn thay đổi branch option trong quản lý tb cấp phát  
    $('#branchRevoke').on('change', function() {
      let branchId = $(this).val();
      if (branchId) {
        // Gửi yêu cầu AJAX
        $.ajax({
          url: '<?php echo site_url("getInventoryFromBranch"); ?>',
          type: 'GET',
          dataType: 'json',
          data: {
            branch_id: branchId
          },
          success: function(response) {
            if (response.status) {
              console.log(response.data);
              // Gọi hàm để render dữ liệu lên bảng
              renderTableBody(response.data);
            } else {
              console.log(response.message);
              $(".table tbody").empty();
              $(".table tbody").append("<p>không có dữ liệu</p>");
            }
          },
          error: function(xhr, status, error) {
            console.error('Đã có lỗi xảy ra:', error);
          }
        });
      } else {
        // Nếu không chọn chi nhánh nào, xóa nội dung bảng
        $(".table tbody").empty();
      }
    });

    //Khi click nút thu hồi ở mỗi dòng thì mở modal
    $(".table").on("click", ".btn-danger", function() {
      let $row = $(this).closest("tr");
      let id = $(this).data("id");
      let name = $row.find(".deviceName").text();
      let quantity = $row.find(".grantQuantity").text();
      let status = $row.find(".grantStatus").text();
      openRevokeModal(id, name, quantity, status);
    });
    //submit form revoke modal
    $('#formRevoke').submit(function(event) {
      event.preventDefault();
      let formRevokeData = $(this).serialize();
      $.ajax({
        url: '<?php echo site_url("revokeDeviceFromInventory"); ?>',
        type: 'POST',
        dataType: 'json',
        data: formRevokeData,
        success: function(response) {
          console.log(response);
          return;
          if (response.status) {
            alert(response.message);
            $('#revokeDeviceModal').modal('hide');
            //fill data in table after update quanttiy
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