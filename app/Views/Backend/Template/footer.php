  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="../../assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/vendor/chart.js/chart.umd.js"></script>
  <script src="../../assets/vendor/echarts/echarts.min.js"></script>
  <script src="../../assets/vendor/quill/quill.js"></script>
  <script src="../../assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="../../assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="../../assets/vendor/php-email-form/validate.js"></script>
  <script src="../../assets/js/sweetalert2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <?php if (session()->getFlashdata('success')) : ?>
    <script type="text/javascript">
        $(document).ready(function() {
            Swal.fire({
                title: "Success!",
                text: "<?php echo $_SESSION['success'] ?>",
                icon: "success",
                confirmButtonText: "OK"
            });
        });
    </script>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <script type="text/javascript">
        $(document).ready(function() {
            Swal.fire({
                title: "Sorry!",
                text: "<?php echo $_SESSION['error'] ?>",
                icon: "error",
                confirmButtonText: "OK"
            });
        });
    </script>
<?php endif; ?>

<?php if (session()->getFlashdata('warning')) : ?>
    <script type="text/javascript">
        $(document).ready(function() {
            Swal.fire({
                title: "Warning!",
                text: "<?php echo $_SESSION['warning'] ?>",
                icon: "warning",
                confirmButtonText: "OK"
            });
        });
    </script>
<?php endif; ?>

	<script>
		$('#calendar').datepicker({
		});

		!function ($) {
			$(document).on("click", "ul.nav li.parent > a > span.icon", function () {
				$(this).find('em:first').toggleClass("glyphicon-minus");
			});
			$(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
		}(window.jQuery);

		$(window).on('resize', function () {
			if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
		})
		$(window).on('resize', function () {
			if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
		})
	</script>

  <!-- Template Main JS File -->
  <script src="../../assets/js/main.js"></script>

</body>

</html>