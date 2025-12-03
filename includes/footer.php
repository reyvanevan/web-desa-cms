    <footer id="footer">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4">
                    <h4 class="text-white mb-3">KRL CINTA</h4>
                    <p><?= get_setting('footer_alamat', 'Desa Ciangsana RW 21, Kecamatan Gunung Putri, Bogor, Jawa Barat.') ?></p>
                    <div class="d-flex gap-3 mt-3">
                        <a href="<?= get_setting('footer_instagram', '#') ?>"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="<?= get_setting('footer_facebook', '#') ?>"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="<?= get_setting('footer_youtube', '#') ?>"><i class="fab fa-youtube fa-lg"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 offset-lg-2">
                    <h5 class="text-white mb-3">Menu</h5>
                    <ul class="list-unstyled">
                        <li><a href="index.php">Beranda</a></li>
                        <li><a href="index.php#about">Tentang</a></li>
                        <li><a href="index.php#kegiatan">Program</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h5 class="text-white mb-3">Kontak</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-phone me-2"></i> <?= get_setting('footer_telepon', '(021) 1234-5678') ?></li>
                        <li><i class="fas fa-envelope me-2"></i> <?= get_setting('footer_email', 'info@krlcinta.id') ?></li>
                    </ul>
                </div>
            </div>
            <div class="border-top border-secondary mt-5 pt-4 text-center">
                <p class="small mb-0">&copy; <?= date('Y') ?> KRL CINTA RW 21. Developed by <strong>KKN Sinergi Peduli</strong>.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // --- 1. Inisialisasi Animasi (AOS) ---
        AOS.init({
            duration: 1000, // Durasi animasi 1 detik
            once: true,     // Animasi cuma jalan sekali pas scroll (biar ga pusing)
            offset: 100     // Mulai animasi pas elemen udh keliatan dikit
        });

        // --- 2. Logic Dark Mode (Toggle) ---
        const toggleBtn = document.getElementById('darkModeToggle');

        // Cek dulu: tombolnya ada ga? (Penting biar ga error kalau HTML belum disave)
        if (toggleBtn) {
            const icon = toggleBtn.querySelector('i');
            const body = document.body;

            // Cek LocalStorage: User pernah pilih dark mode ga sebelumnya?
            if (localStorage.getItem('theme') === 'dark') {
                body.classList.add('dark-mode');
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun'); // Ganti ikon jadi matahari
            }

            // Event Listener pas tombol diklik
            toggleBtn.addEventListener('click', () => {
                body.classList.toggle('dark-mode');

                // Ganti Ikon & Simpan Pilihan
                if (body.classList.contains('dark-mode')) {
                    icon.classList.remove('fa-moon');
                    icon.classList.add('fa-sun');
                    localStorage.setItem('theme', 'dark');
                } else {
                    icon.classList.remove('fa-sun');
                    icon.classList.add('fa-moon');
                    localStorage.setItem('theme', 'light');
                }
            });
        }
    </script>
</body>

</html>
