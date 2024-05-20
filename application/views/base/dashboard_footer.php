<script type='text/javascript'>
    $(document).ready(function() {
        $('.logoutButton').click(function(e) {
        e.preventDefault();
        if (confirm('Bạn chắc chắn muốn đăng xuất?')) {
            window.location.href = "<?php echo site_url('logout'); ?>";
        }
        });
    });
</script>
</body>
</html>