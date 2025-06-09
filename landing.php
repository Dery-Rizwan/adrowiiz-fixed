<?php
session_start();

if(isset($_POST["register"])) {
    header ("location:register.php");
}

if(isset($_POST["login"])) {
  header ("location:login.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ADROWIIZ Store - Gadget Premium & Terpercaya</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="style/landing1.css">
</head>
<body>

    <header class="main-header">
        <nav class="navbar">
            <div class="container">
                <div class="navbar-brand">
                  <a href="#" class="navbar-logo">
                  <img src="style/logoo.png" alt="ADROWIIZ Logo">
                  </a>
                  <h1 class="brand-text">ADROWIIZ</h1>
                </div>
                <div class="navbar-menu-toggle" id="menu-toggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <ul class="navbar-nav" id="navbar-nav">
                    <li><a href="#tentang">Tentang</a></li>
                    <li><a href="#produk">Produk</a></li>
                    <li><a href="#fitur">Fitur</a></li>
                    <li><a href="#kontak">Kontak</a></li>
                    <li><a href="login.php" class="btn btn-outline">Login</a></li>
                </ul>
            </div>
        </nav>
        <div class="hero-section">
            <div class="container">
                <h1 class="hero-title">Temukan Gadget Impian Anda</h1>
                <p class="hero-subtitle">Platform cerdas dengan rekomendasi AI untuk menemukan gadget yang paling sesuai untuk Anda.</p>
                <a href="register.php" class="btn btn-primary">Daftar Sekarang</a>
            </div>
        </div>
    </header>

    <main>
        <section id="tentang" class="content-section">
            <div class="container animated-section">
                <h2 class="section-title">Solusi Cerdas Pencarian Gadget</h2>
                <div class="about-content">
                    <div class="about-text">
                        <p>ADROWIIZ adalah platform web inovatif yang dirancang untuk memandu Anda menemukan handphone ideal. Kami menyajikan dua metode rekomendasi utama: pencarian manual dengan filter canggih dan interaksi intuitif melalui chatbot AI.</p>
                        <p>Dengan filter, Anda bisa menentukan spesifikasi detail seperti RAM, baterai, kamera, hingga rentang harga. Sementara itu, chatbot AI kami yang didukung teknologi Natural Language Processing (NLP) siap memahami kebutuhan Anda melalui percakapan biasa, memberikan rekomendasi yang personal dan akurat.</p>
                        <p>Kami memadukan data dan kecerdasan buatan dalam antarmuka yang modern dan adaptif, memastikan pengalaman pencarian gadget Anda menjadi lebih efisien, nyaman, dan menyenangkan.</p>
                    </div>
                    <div class="about-image">
                        <img src="style/bgadrowiiz.webp" alt="Produk Gadget Berkualitas">
                    </div>
                </div>
            </div>
        </section>

        <section id="produk" class="content-section bg-light">
            <div class="container animated-section">
                <h2 class="section-title">Kategori Produk Unggulan</h2>
                <p class="section-intro">Jelajahi kategori yang dirancang khusus untuk setiap kebutuhan.</p>
                <div class="produk-grid">
                    <div class="produk-card">
                        <span class="produk-icon">🎮</span>
                        <h3 class="produk-title">Gaming Phones</h3>
                    </div>
                    <div class="produk-card">
                        <span class="produk-icon">📸</span>
                        <h3 class="produk-title">Camera Phones</h3>
                    </div>
                    <div class="produk-card">
                        <span class="produk-icon">🔋</span>
                        <h3 class="produk-title">Battery Kings</h3>
                    </div>
                    <div class="produk-card">
                        <span class="produk-icon">🛡️</span>
                        <h3 class="produk-title">Rugged Phones</h3>
                    </div>
                    <div class="produk-card">
                        <span class="produk-icon">💰</span>
                        <h3 class="produk-title">Budget Friendly</h3>
                    </div>
                </div>
            </div>
        </section>

        <section id="fitur" class="content-section">
            <div class="container animated-section">
                <h2 class="section-title">Mengapa Memilih ADROWIIZ?</h2>
                <div class="features-grid">
                    <div class="feature-card">
                        <h4>Produk Terkurasi</h4>
                        <p>Setiap perangkat yang kami rekomendasikan telah melewati proses seleksi kualitas yang ketat.</p>
                    </div>
                    <div class="feature-card">
                        <h4>Transaksi Aman & Terpercaya</h4>
                        <p>Keamanan data dan transaksi Anda adalah prioritas utama kami dengan teknologi enkripsi terkini.</p>
                    </div>
                    <div class="feature-card">
                        <h4>Pelayanan Responsif</h4>
                        <p>Tim kami siap memberikan respon cepat dan dukungan penuh untuk setiap pertanyaan Anda.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="kontak" class="content-section bg-dark">
            <div class="container animated-section">
                <h2 class="section-title">Hubungi Kami</h2>
                <p class="section-intro">Punya pertanyaan atau masukan? Kami siap mendengarkan.</p>
                <form class="contact-form">
                    <div class="form-group">
                        <input type="text" id="name" name="name" required placeholder="Nama Anda">
                    </div>
                    <div class="form-group">
                        <input type="email" id="email" name="email" required placeholder="Email Anda">
                    </div>
                    <div class="form-group">
                        <textarea id="message" name="message" rows="5" required placeholder="Pesan Anda"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                </form>
            </div>
        </section>
    </main>

    <footer class="main-footer-bottom">
        <div class="container">
            <p>&copy; <?php echo date("Y"); ?> ADROWIIZ Store. All Rights Reserved.</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Animasi Scroll
            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('.navbar-nav a').forEach(link => {
            link.addEventListener('click', () => {
            navbarNav.classList.remove('is-active');
            menuToggle.classList.remove('is-active');
            });
              });

            document.querySelectorAll('.animated-section').forEach(section => {
                observer.observe(section);
            });

            // Menu Toggle untuk Mobile
            const menuToggle = document.getElementById('menu-toggle');
            const navbarNav = document.getElementById('navbar-nav');
            menuToggle.addEventListener('click', () => {
                navbarNav.classList.toggle('is-active');
                menuToggle.classList.toggle('is-active');
            });
        });
    </script>
</body>
</html>
