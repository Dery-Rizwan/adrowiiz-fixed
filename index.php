<?php
session_start();
$nama = isset($_SESSION['user']) ? $_SESSION['user'] : 'Pengunjung';
// echo "👤 Halo, $nama";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ADROWIIZ STORE</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="style/style.css" />
</head>

<body>
<header>
  <div class="header-container">
 <div class="brand-area">
  <img src="style/logoo.png" alt="ADROWIIZ Logo" class="header-logo">
  <h1>ADROWIIZ</h1>
 </div>
 <div class="user-menu">
    <button class="user-menu-trigger">
        <i class="fas fa-user-circle"></i>
        <span>Hai, <?= htmlspecialchars($nama) ?>!</span>
        <i class="fas fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
        <a href="profile.php"><i class="fas fa-user-edit"></i> Profil Saya</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</div>
</div>
</header>


  <main>
    <section id="produk">
      <h2 style="text-align:center;">Produk Unggulan</h2>
      <form method="GET" action="index.php" style="text-align:center; margin-bottom: 20px;">
        <input type="text" name="search" placeholder="Cari produk..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" style="padding: 8px; width: 250px; border-radius: 4px; border: 1px solid #ccc;">
        <button type="submit" class="btn btn-icon-find" aria-label="Cari">
    <i class="fas fa-search"></i>
</button>
      </form>
      <div class="produk-container">
        <?php include 'produk.php'; ?>
      </div>
    </section>
  </main>

  <button class="chatbot-toggle" onclick="toggleChatbot()">💬</button>

  <div class="chat-container" id="chat-container">
    <div id="chat-box"></div>
    <div style="display: flex; gap: 5px;">
      <input type="text" id="user-input" placeholder="Tulis kebutuhan HP kamu...">
      <button class="send-btn" onclick="sendMessage()">Kirim</button>
    </div>
  </div>


  <footer>
    <section id="kontak">
      <p>&copy; 2025 ADROWIIZ Store. All rights reserved.</p>
    </section>
  </footer>

  <script src="main.js"></script>
</body>

</html>