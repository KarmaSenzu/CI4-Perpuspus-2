<!-- ======= Footer ======= -->
<footer class="footer text-center py-4">
  <div class="container">
    <div class="copyright">
      &copy; 2024 <strong><span>Perpuspus</span></strong>. All Rights Reserved
    </div>
    <!-- Social Media Links -->
    <div class="social-links mt-3">
      <a href="https://wa.me/6285951750898" class="text-secondary mx-2" title="Whatsapp">
        <i class="bi bi-whatsapp"></i>
      </a>
      <a href="https://x.com/FCBarcelona?t=gwDEvIuX3tfTKV6iikmq3w&s=09" class="text-secondary mx-2" title="Twitter">
        <i class="bi bi-twitter"></i>
      </a>
      <a href="https://www.instagram.com/fcbarcelona?igsh=eXo3Y2lvaDcxa2Nn" class="text-secondary mx-2" title="Instagram">
        <i class="bi bi-instagram"></i>
      </a>
      <a href="https://www.tiktok.com/@fcbarcelona?_t=8rOLNbfrCki&_r=1" class="text-secondary mx-2" title="TikTok">
        <i class="bi bi-tiktok"></i>
      </a>
    </div><!-- End Social Links -->
  </div><!-- End Container -->
</footer><!-- End Footer -->

<!-- Vendor JS Files -->
<script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- AOS JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
  AOS.init({
    duration: 1000,
    once: false,
    mirror: true
  });

  
</script>

<script type="text/javascript">
  const pinjamBukuBtn = document.querySelectorAll('.pinjam-buku-btn');
  
  pinjamBukuBtn.forEach(button => {
    button.addEventListener('click', function (event) {
      <?php if (!session()->get('is_logged_in')): ?>
        const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
        loginModal.show();
      <?php else: ?>
        window.location.href = '<?= site_url('user/peminjaman-step1'); ?>';
      <?php endif; ?>
    });
  });
</script>