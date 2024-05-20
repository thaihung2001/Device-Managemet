<nav class="navbar navbar-inverse visible-xs">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Hệ thống quản lý kho</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href="<?php echo site_url('dashboard'); ?>">Tổng quan</a></li>
        <li class="active"><a href="<?php echo site_url('branch'); ?>">Chi nhánh công ty</a></li>
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
        <li><a href="<?php echo site_url('dashboard'); ?>">Tổng quan</a></li>
        <li class="active"><a href="<?php echo site_url('branch'); ?>">Chi nhánh công ty</a></li>
        <li><a href="<?php echo site_url('device'); ?>">Thiết bị công ty</a></li>
        <li><a href="#" class="logoutButton">Đăng xuất</a></li>
      </ul><br>
    </div>
    <br>
    <div class="col-sm-9">
      <div class="well">
        <form class="form-inline" id="createBranchForm">
          <div class="form-group">
            <input type="text" class="form-control" id="createNameBranch" placeholder="Nhập tên chi nhánh mới" name="createNameBranch">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" id="createAddressBranch" placeholder="Nhập địa chỉ chi nhánh" name="createAddressBranch">
          </div>
          <div class="form-group"><button type="submit" class="btn btn-primary">Thêm mới</button></div>
        </form>
      </div>
      <div class="well">
        <h4>Danh sách các chi nhánh</h4>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>STT</th>
              <th>Tên chi nhánh</th>
              <th>Địa chỉ</th>
              <th>Hành động</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- modal edit Branch -->
<div class="modal fade" id="editBranchModal" tabindex="-1" role="dialog" aria-labelledby="editBranchModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="editBranchModalLabel">Chỉnh sửa Chi Nhánh</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editBranchForm">
          <div class="form-group">
            <label for="branchName">Tên chi nhánh</label>
            <input type="text" class="form-control" id="branchName" name="branchName" required>
          </div>
          <div class="form-group">
            <label for="branchAddress">Địa chỉ</label>
            <input type="text" class="form-control" id="branchAddress" name="branchAddress" required>
          </div>
          <input type="hidden" id="branchId" name="branchId">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
        <button type="button" class="btn btn-primary" id="saveBranchChanges">Lưu thay đổi</button>
      </div>
    </div>
  </div>
</div>
<!-- /// -->
<script type='text/javascript'>
  function renderTable(data) {
    $(".table tbody").empty();
    $.each(data, function(index, item) {
      let $row = $("<tr>");
      $row.append($("<td>").text(index + 1));
      $row.append($("<td class='branch-name'>").text(item.name));
      $row.append($("<td class='branch-address'>").text(item.address));
      let $actionTd = $("<td>");
      let $editButton = $("<button>").text("Sửa").addClass("btn btn-primary btn-sm").attr("data-id", item.id);
      let $deleteButton = $("<button>").text("Xóa").addClass("btn btn-danger btn-sm").attr("data-id", item.id);
      // Thêm các nút vào cột hành động
      $actionTd.append($editButton).append(" ").append($deleteButton);
      $row.append($actionTd);
      $(".table tbody").append($row);
    });
  }

  function openEditModal(id, name, address) {
    $('#branchId').val(id);
    $('#branchName').val(name);
    $('#branchAddress').val(address);
    $('#editBranchModal').modal('show');
  }

  function loadTable() {
    $.ajax({
      url: "<?php echo site_url('loadBranch'); ?>",
      type: "GET",
      dataType: "json",
      success: function(response) {
        if(response.status){
          renderTable(response.data);
        }
      },
      error: function(xhr, status, error) {
        console.log('Tải dữ liệu thất bại!');
      }
    });
  }

  $(document).ready(function() {
    let allData = <?php echo json_encode($allData); ?>;
    renderTable(allData);

    //create Branch
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
            //load lại bảng
            loadTable();
          } else {
            alert(response.message);
          }
        },
        error: function(xhr, status, error) {
          console.error('Vui lòng thử lại, có lỗi xảy ra.');
        }
      });
    });

    //click update
    $(".table").on("click", ".btn-primary", function() {
      let $row = $(this).closest("tr");
      let id = $(this).data("id");
      let name = $row.find(".branch-name").text();
      let address = $row.find(".branch-address").text();
      openEditModal(id, name, address);
    });

    //click delete
    $(".table").on("click", ".btn-danger", function() {
      let id = $(this).data("id");
      if (confirm("Bạn có chắc chắn muốn xóa chi nhánh này?")) {
        $.ajax({
          url: "<?php echo site_url('deleteBranch'); ?>", // URL đến API delete
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
    //update branch
    $('#saveBranchChanges').click(function() {
      let formData = $('#editBranchForm').serialize();
      $.ajax({
        url: "<?php echo site_url('updateBranch'); ?>", // URL đến API update
        type: "POST",
        data: formData,
        dataType: "json",
        success: function(response) {
          if (response.status) {
            $('#editBranchModal').modal('hide');
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
  });
</script>