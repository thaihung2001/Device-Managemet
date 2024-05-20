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
            <p>Tổng thiết bị: <b><?php echo $totalDevice; ?></b> thiết bị</p>

          </div>
        </div>
        <div class="col-sm-2">
          <div class="well">
            <button class="btn btn-primary">Cấp thiết bị </button>
          </div>
        </div>
        <div class="col-sm-5">
          <div class="well">
            <h4>Chi nhánh</h4>
          <p>Tổng chi nhánh: <b><?php echo $totalBranch; ?></b> chi nhánh</p>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>