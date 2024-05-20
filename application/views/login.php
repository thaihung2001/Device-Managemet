<div class="container">
  <div class="row">
    <div class="col-3"></div>
    <div class="col-6">
      <div class="card">
        <div class="card-header">
          Đăng nhập hệ thống
        </div>
        <div class="card-body">
          <form method="POST" id="loginForm">
            <div class="form-group">
              <label for="exampleInputEmail1">Email </label>
              <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" value="admin@gmail.com">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Password</label>
              <input type="password" class="form-control" name="password" id="password" value="Admin@736">
            </div>
            <button type="submit" class="btn btn-primary">Đăng nhập</button>
          </form>
        </div>
      </div>
    </div>
    <div class="col-3"></div>
  </div>
</div>

<script type='text/javascript'>
  $(document).ready(function() {
    $('#loginForm').submit(function(e) {
      e.preventDefault();
      $.ajax({
        type: "POST",
        url: "<?php echo site_url('login'); ?>",
        data: $(this).serialize(),
        dataType: "json",
        success: function(response) {
          if (response.status) {
            //alert(response.message);
            window.location.href = "<?php echo site_url('dashboard'); ?>";
          } else {

            alert(response.message);
          }
        }
      });
    });
  });
</script>