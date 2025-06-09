<?php
include 'koneksi.php';

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

if ($search != '') {
  $sql = "SELECT * FROM product WHERE name LIKE '%$search%'";
} else {
  $sql = "SELECT * FROM product";
}

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
  echo "
    <div class='produk-card'>
      <img src='{$row['image']}' alt='{$row['name']}'>
      <h3>{$row['name']}</h3>
      <p class='price'>Rp" . number_format($row['price'], 0, ',', '.') . "</p>
    </div>
  ";
}
