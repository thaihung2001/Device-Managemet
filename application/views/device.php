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
        <li><a href="<?php echo site_url('dashboard'); ?>">Tổng quan</a></li>
        <li><a href="<?php echo site_url('branch'); ?>">Chi nhánh công ty</a></li>
        <li class="active"><a href="<?php echo site_url('device'); ?>">Thiết bị công ty</a></li>
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
        <li><a href="<?php echo site_url('dashboard'); ?>">Tổng quan</a></li>
        <li><a href="<?php echo site_url('branch'); ?>">Chi nhánh công ty</a></li>
        <li class="active"><a href="<?php echo site_url('device'); ?>">Thiết bị công ty</a></li>
        <li><a href="#" class="logoutButton">Đăng xuất</a></li>
      </ul><br>
    </div>
    <br>

    <div class="col-sm-9">
      <div class="well">
      </div>
      <div class="well">
        <div class="row">
          <div class="col-sm-5">
            <h4>Danh sách các thiết bị</h4>
          </div>
          <div class="col-sm-5">
            <form class="navbar-form navbar-left" id="formSearch" style="margin-left:28px;">
              <div class="form-group">
                <input type="text" class="form-control" name="search" placeholder="Nhập vào giá trị tìm kiếm" value="<?php if ($this->input->get('search')) {
                                                                                                                        echo $this->input->get('search');
                                                                                                                      } ?>">
              </div>
              <button type="submit" class="btn btn-warning" id="btn-search">Tìm kiếm</button>
            </form>
          </div>
          <div class="col-sm-2">
            <button class="btn btn-primary" id="addDeviceButton" style="margin-top: 8px;">Thêm mới</button>
          </div>
        </div>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>STT</th>
              <th>Tên thiết bị</th>
              <th>Số lượng</th>
              <th>Ngày mua</th>
              <th>Mô tả</th>
              <th>Hành động</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
        <?php echo $links; ?>
      </div>
    </div>
  </div>
</div>
<!-- modal add device -->
<div class="modal fade" id="addDeviceModal" tabindex="-1" role="dialog" aria-labelledby="addDeviceModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="editDeviceModalLabel">Thêm mới Thiết Bị</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="deviceForm" class="form">
          <div class="row form-row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="deviceName">Tên thiết bị</label>
                <input type="text" class="form-control" id="deviceName" name="name" placeholder="Tên thiết bị mới" required>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="deviceDescription">Mô tả</label>
                <textarea class="form-control" row="1" name="description" id="deviceDescription" placeholder="Mô tả thiết bị mới" required></textarea>
              </div>
            </div>
          </div>
          <div class="row form-row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="deviceDateBuy">Ngày mua thiết bị</label>
                <input type="date" class="form-control" id="deviceDateBuy" name="date_buy" required>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="deviceActive">Trạng thái</label>
                <select class="form-control" id="deviceActive" name="active" required>
                  <option value="1">Đang hoạt động</option>
                  <option value="0">Không hoạt động</option>
                </select>
              </div>
            </div>
           
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
        <button type="submit" class="btn btn-primary" id="actionAddDevice">Lưu thay đổi</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- /// -->
<!-- modal edit Device -->
<div class="modal fade" id="editDeviceModal" tabindex="-1" role="dialog" aria-labelledby="editDeviceModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="editDeviceModalLabel">Chỉnh sửa Thiết Bị</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editDeviceForm"  class="form">
          <div class="row form-row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="deviceEditName">Tên thiết bị</label>
                <input type="text" class="form-control" id="deviceEditName" name="deviceEditName" placeholder="Tên thiết bị mới" required>
              </div>
            </div>
            <div class="col-sm-6">
            <div class="form-group">
                <label for="deviceEditDescription">Mô tả</label>
                <textarea class="form-control" row="1" name="deviceEditDescription" id="deviceEditDescription" placeholder="Mô tả thiết bị mới" required></textarea>
              </div>
            </div>
          </div>
          <div class="row form-row">
            <div class="col-sm-6">
            <div class="form-group">
                <label for="deviceEditDate">Ngày mua thiết bị</label>
                <input type="date" class="form-control" id="deviceEditDate" name="deviceEditDate" required>
              </div>
            </div>
            <div class="col-sm-6">
            <div class="form-group">
                <label for="deviceEditActive">Trạng thái</label>
                <select class="form-control" id="deviceEditActive" name="deviceEditActive" required>
                  <option value="1">Đang hoạt động</option>
                  <option value="0">Không hoạt động</option>
                </select>
              </div>
            </div>
          </div>
          <input type="hidden" id="deviceId" name="deviceId">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
        <button type="button" class="btn btn-primary" id="actionEditDevice">Lưu thay đổi</button>
      </div>
    </div>
  </div>
</div>
<!-- /// -->

<script type="text/javascript">
  let today = new Date().toISOString().split('T')[0];
  $('#deviceDateBuy').val(today); //fill value at date.

  function formatDateTable(date) {
    let dateComponents = date.split('-');
    let year = dateComponents[0];
    let month = dateComponents[1];
    let day = dateComponents[2];
    return formattedDate = `${day}/${month}/${year}`;
  }

  function formatDateModal(date) {
    let dateComponents = date.split('/');
    let year = dateComponents[2];
    let month = dateComponents[1];
    let day = dateComponents[0];
    return formattedDate = `${year}-${month}-${day}`;
  }

  function renderTable(data) {
    $(".table tbody").empty();
    $.each(data, function(index, item) {
      let $row = $("<tr>");
      $row.append($("<td>").text(index + 1));
      $row.append($("<td class='deviceName'>").text(item.name));
      $row.append($("<td class='deviceDate'>").text(formatDateTable(item.date_buy)));
      $row.append($("<td class='deviceDescription'>").text(item.description));
      $row.append($("<td class='deviceActive'>").text(item.active == "1" ? "Đang hoạt động" : "Không hoạt động").addClass(item.active == "1" ? "text-success" : "text-danger"));
      let $actionTd = $("<td>");
      let $editButton = $("<button>").text("Sửa").addClass("btn btn-primary btn-sm").attr("data-id", item.id);
      let $deleteButton = $("<button>").text("Xóa").addClass("btn btn-danger btn-sm").attr("data-id", item.id);
      $actionTd.append($editButton).append(" ").append($deleteButton);
      $row.append($actionTd);
      $(".table tbody").append($row);
    });
  }


  function openEditModal(id, name, date, description, active) {
    $('#deviceId').val(id);
    $('#deviceEditName').val(name);
    
    $('#deviceEditDate').val(date);
    $('#deviceEditDescription').val(description);
    $('#deviceEditActive').val(active);
    $('#editDeviceModal').modal('show');
  }

  function loadTable() {
    $.ajax({
      url: "<?php echo site_url('loadDevice'); ?>",
      type: "GET",
      dataType: "json",
      success: function(response) {
        //console.log(response);return;
        if (response.status) {
          renderTable(response.data);
        }
      },
      error: function(xhr, status, error) {
        console.log('Tải dữ liệu thất bại!');
      }
    });
  }

  $(document).ready(function() {
    let allData = <?php echo json_encode($results); ?>;
    renderTable(allData); //render các dòng dữ liệu 

    //Open modal add device
    $("#addDeviceButton").on('click', function() {
      $('#addDeviceModal').modal('show');
    });
    //Create device
    $('#deviceForm').submit(function(event) {
      event.preventDefault();
      let formData = $(this).serialize();
      $.ajax({
        url: '<?php echo site_url("insertDevice"); ?>',
        type: 'POST',
        dataType: 'json',
        data: formData,
        success: function(response) {
          //console.log(response);
          if (response.status) {
            alert(response.message);
            $('#deviceForm')[0].reset();
            $('#addDeviceModal').modal('hide');
            loadTable(); //load lại bảng
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

    //click update
    $(".table").on("click", ".btn-primary", function() {
      let $row = $(this).closest("tr");
      let id = $(this).data("id");
      let name = $row.find(".deviceName").text();
      let date = $row.find(".deviceDate").text();
      let description = $row.find(".deviceDescription").text();
      let valActive = $row.find(".deviceActive").text();
      let active;
      if (valActive === "Đang hoạt động") {
        active = 1;
      } else if (valActive === "Không hoạt động") {
        active = 0;
      }
      openEditModal(id, name, formatDateModal(date), description, active);
    });

    //click delete
    $(".table").on("click", ".btn-danger", function() {
      let id = $(this).data("id");
      if (confirm("Bạn có chắc chắn muốn xóa thiết bị này?")) {
        $.ajax({
          url: "<?php echo site_url('deleteDevice'); ?>", // URL đến API delete
          type: "DELETE",
          data: {
            id: id
          },
          dataType: "json",
          success: function(response) {
            if (response.status) {
              alert(response.message);
              //load lại bảng
              loadTable();
            } else {
              alert(response.message);
            }
          },
          error: function(xhr, status, error) {
            alert('Vui lòng thử lại, có lỗi xảy ra.');
          }
        });
      }
    });

    //update device
    $('#actionEditDevice').click(function(event) {
      event.preventDefault();
      let formData = $('#editDeviceForm').serialize();
      $.ajax({
        url: "<?php echo site_url('updateDevice'); ?>", // URL đến API update
        type: "POST",
        data: formData,
        dataType: "json",
        success: function(response) {
          if (response.status) {
            $('#editDeviceModal').modal('hide');
            alert(response.message);
            //load lại bảng
            loadTable();
          } else {
            alert(response.message);
          }
        },
        error: function(xhr, status, error) {
          alert('Vui lòng thử lại, có lỗi xảy ra.');
        }
      });
    });

    //search device
    $('#btn-search').click(function() {
      let formSearchData = $('#formSearch').serialize();
      $.ajax({
        url: "<?php echo site_url('device'); ?>", // URL đến API update
        type: "GET",
        data: formData,
        dataType: "json",
        success: function(response) {
          console.log(response);
          /*  if (response.status) {
             alert(response.message);
             //load lại bảng
             loadTable();
           } else {
             alert(response.message);
           } */
        },
        error: function(xhr, status, error) {
          alert('Vui lòng thử lại, có lỗi xảy ra.');
        }
      });
    });
  });
</script>