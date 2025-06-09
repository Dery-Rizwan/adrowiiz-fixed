// Konfigurasi API Gemini 1.5
const API_KEY = "AIzaSyA_4kkpKuwZoMCL31Q-vf2hyQZgYMTd_uQ"; // Ganti dengan kunci API Gemini Anda yang sebenarnya
const API_URL = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent";

// Variabel untuk menyimpan percakapan untuk konteks
let conversationHistory = [];

function toggleChatbot() {
  const chat = document.getElementById('chat-container');
  chat.style.display = chat.style.display === 'none' || chat.style.display === '' ? 'block' : 'none';
}

// Inisialisasi chatbot saat halaman dimuat
document.addEventListener("DOMContentLoaded", () => {
  const chatBox = document.getElementById("chat-box");
  chatBox.innerHTML += `<div class="bubble ai">Halo! Aku ADROWIIZ. Ada yang bisa aku bantu tentang rekomendasi HP? 😊</div>`;
  
  // Menambahkan pesan pembuka ke history percakapan
  conversationHistory.push({
    role: "model",
    parts: [{ text: "Halo! Aku ADROWIIZ. Ada yang bisa aku bantu tentang rekomendasi HP? 😊" }]
  });
  
  // Menangani penekanan tombol "Enter" di kolom input
  document.getElementById('user-input').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
      sendMessage();
    }
  });
});

async function sendMessage() {
  const input = document.getElementById('user-input');
  const message = input.value.trim();
  if (!message) return;

  const chatBox = document.getElementById('chat-box');
  chatBox.innerHTML += `<div class="bubble user">${message}</div>`;
  
  // Tambahkan pesan pengguna ke riwayat percakapan
  conversationHistory.push({
    role: "user",
    parts: [{ text: message }]
  });

  // Tampilkan animasi loading
  const loadingBubble = document.createElement("div");
  loadingBubble.className = "bubble ai";
  loadingBubble.innerHTML = `<div class="loading"><span></span><span></span><span></span></div>`;
  chatBox.appendChild(loadingBubble);
  chatBox.scrollTop = chatBox.scrollHeight;

  // Kosongkan kolom input
  input.value = '';

  try {
    // Dapatkan respons AI menggunakan API Gemini 1.5
    const aiResponse = await getAIResponse(message);
    
    // Hapus animasi loading dan tampilkan respons
    loadingBubble.remove();
    chatBox.innerHTML += `<div class="bubble ai">${formatResponse(aiResponse)}</div>`;
    
    // Tambahkan respons AI ke riwayat percakapan
    conversationHistory.push({
      role: "model",
      parts: [{ text: aiResponse }]
    });
    
    // Batasi riwayat percakapan untuk menghemat token (opsional)
    if (conversationHistory.length > 12) {
      // Simpan pesan sistem dan 11 pesan terakhir
      const systemMessage = conversationHistory[0];
      conversationHistory = [systemMessage, ...conversationHistory.slice(-11)];
    }
    
    chatBox.scrollTop = chatBox.scrollHeight;
  } catch (error) {
    // Tangani kesalahan
    loadingBubble.remove();
    chatBox.innerHTML += `<div class="bubble ai">Maaf, terjadi kesalahan. Silakan coba lagi nanti.</div>`;
    console.error("Error mendapatkan respons AI:", error);
    chatBox.scrollTop = chatBox.scrollHeight;
  }
}

document.addEventListener('DOMContentLoaded', function() {
    // Fungsi Dropdown User Menu
    const userMenu = document.querySelector('.user-menu');
    if (userMenu) {
        const trigger = userMenu.querySelector('.user-menu-trigger');
        trigger.addEventListener('click', function(event) {
            event.stopPropagation(); // Mencegah window.onclick berjalan saat trigger di-klik
            userMenu.classList.toggle('active');
        });
    }

    // Menutup dropdown jika klik di luar area menu
    window.onclick = function(event) {
        const userMenu = document.querySelector('.user-menu');
        if (userMenu && !userMenu.contains(event.target)) {
            userMenu.classList.remove('active');
        }
    }

    // ... (kode chatbot Anda yang sudah ada bisa diletakkan di sini)
    // function toggleChatbot() { ... }
    // function sendMessage() { ... }
});

// Fungsi untuk membuat permintaan ke API Gemini 1.5
async function getAIResponse(userMessage) {
  // Database produk dengan spesifikasi lengkap untuk analisis komparatif
  const productDatabase = `
    DATABASE PRODUK HP LENGKAP:
    
    1. HP Gaming:
       - ASUS ROG Phone 9 FE: 
          * Prosesor: Snapdragon 8 Gen 3 (3.3 GHz, 8 core)
          * RAM: 16GB LPDDR5X (kategori: besar)
          * Storage: 512GB UFS 4.0
          * Layar: 6.78" 165Hz AMOLED (kategori: besar)
          * Baterai: 5500mAh (kategori: besar)
          * Kamera: 50MP utama, 13MP ultrawide, 5MP makro
          * Harga: Rp10.999.000 (kategori: mahal)
          * Keunggulan: Performa gaming tinggi, sistem pendingin khusus, trigger fisik
       
       - POCO X7: 
          * Prosesor: Snapdragon 695 (2.2 GHz, 8 core)
          * RAM: 8GB LPDDR4X (kategori: sedang)
          * Storage: 256GB UFS 2.2
          * Layar: 6.67" 120Hz AMOLED (kategori: besar)
          * Baterai: 5000mAh (kategori: besar)
          * Kamera: 64MP utama, 8MP ultrawide, 2MP makro
          * Harga: Rp3.299.000 (kategori: sedang)
          * Keunggulan: Harga terjangkau untuk performa gaming, layar responsif
    
    2. HP Kamera:
       - Samsung Galaxy S24 Ultra: 
          * Prosesor: Snapdragon 8 Gen 3 (3.3 GHz, 8 core)
          * RAM: 12GB LPDDR5X (kategori: besar)
          * Storage: 512GB UFS 4.0
          * Layar: 6.8" 120Hz LTPO AMOLED (kategori: besar)
          * Baterai: 5000mAh (kategori: besar)
          * Kamera: 200MP utama, 50MP telephoto (5x), 12MP ultrawide, 12MP selfie
          * Harga: Rp19.999.000 (kategori: sangat mahal)
          * Keunggulan: Kamera flagship terbaik, zoom optical 5x, sensor 200MP terbesar di kelasnya
       
       - Samsung Galaxy S21 Ultra 5G: 
          * Prosesor: Exynos 2100 (2.9 GHz, 8 core)
          * RAM: 16GB LPDDR5 (kategori: besar)
          * Storage: 256GB UFS 3.1
          * Layar: 6.8" 120Hz LTPO AMOLED (kategori: besar)
          * Baterai: 5000mAh (kategori: besar)
          * Kamera: 108MP utama, 10MP telephoto (10x), 12MP ultrawide, 40MP selfie
          * Harga: Rp15.999.000 (kategori: sangat mahal)
          * Keunggulan: Kamera zoom periskop, sensor 108MP dengan detail tinggi
    
    3. HP Murah:
       - Redmi Note 9: 
          * Prosesor: MediaTek Helio G85 (2.0 GHz, 8 core)
          * RAM: 4GB LPDDR4X (kategori: kecil)
          * Storage: 64GB eMMC 5.1
          * Layar: 6.53" IPS LCD (kategori: sedang)
          * Baterai: 5020mAh (kategori: besar)
          * Kamera: 48MP utama, 8MP ultrawide, 2MP makro, 2MP depth
          * Harga: Rp2.199.000 (kategori: murah)
          * Keunggulan: Baterai besar, harga sangat terjangkau
       
       - Realme C55: 
          * Prosesor: MediaTek Helio G88 (2.0 GHz, 8 core)
          * RAM: 6GB LPDDR4X (kategori: sedang)
          * Storage: 128GB UFS 2.2
          * Layar: 6.72" IPS LCD (kategori: besar)
          * Baterai: 5000mAh (kategori: besar)
          * Kamera: 64MP utama, 2MP depth
          * Harga: Rp2.499.000 (kategori: murah)
          * Keunggulan: Layar besar, RAM cukup untuk multitasking dasar
    
    4. HP Fokus Baterai:
       - Infinix GT10 Pro: 
          * Prosesor: Dimensity 8050 (3.0 GHz, 8 core)
          * RAM: 8GB LPDDR4X (kategori: sedang)
          * Storage: 256GB UFS 3.1
          * Layar: 6.67" 120Hz AMOLED (kategori: besar)
          * Baterai: 5000mAh, 45W fast charging (kategori: besar)
          * Kamera: 108MP utama, 2MP makro, 2MP depth
          * Harga: Rp4.999.000 (kategori: sedang)
          * Keunggulan: Fast charging cepat, baterai tahan seharian penuh
       
       - RedMagic 10 Pro: 
          * Prosesor: Snapdragon 8 Gen 3 (3.3 GHz, 8 core)
          * RAM: 12GB LPDDR5X (kategori: besar)
          * Storage: 256GB UFS 4.0
          * Layar: 6.8" 120Hz AMOLED (kategori: besar)
          * Baterai: 7050mAh, 80W fast charging (kategori: sangat besar)
          * Kamera: 50MP utama, 8MP ultrawide
          * Harga: Rp9.999.000 (kategori: mahal)
          * Keunggulan: Baterai terbesar di kelasnya, pengisian super cepat
    
    5. HP RAM Tinggi:
       - Realme 13 Pro+: 
          * Prosesor: Dimensity 7300 (2.8 GHz, 8 core)
          * RAM: 12GB LPDDR5 (kategori: besar)
          * Storage: 256GB UFS 3.1
          * Layar: 6.7" 120Hz AMOLED (kategori: besar)
          * Baterai: 5000mAh (kategori: besar)
          * Kamera: 50MP utama, 8MP ultrawide, 2MP makro
          * Harga: Rp5.999.000 (kategori: sedang)
          * Keunggulan: RAM besar untuk multitasking berat
       
       - Samsung Galaxy S21 Ultra 5G (16GB): 
          * Prosesor: Exynos 2100 (2.9 GHz, 8 core)
          * RAM: 16GB LPDDR5 (kategori: besar)
          * Storage: 512GB UFS 3.1
          * Layar: 6.8" 120Hz LTPO AMOLED (kategori: besar)
          * Baterai: 5000mAh (kategori: besar)
          * Kamera: 108MP utama, 10MP telephoto, 12MP ultrawide, 40MP selfie
          * Harga: Rp15.999.000 (kategori: sangat mahal)
          * Keunggulan: RAM terbesar di pasaran, multitasking ekstrem
    
    6. HP Serba Bisa:
       - Vivo Y27: 
          * Prosesor: Helio G85 (2.0 GHz, 8 core)
          * RAM: 6GB LPDDR4X (kategori: sedang)
          * Storage: 128GB eMMC 5.1
          * Layar: 6.64" IPS LCD (kategori: besar)
          * Baterai: 5000mAh (kategori: besar)
          * Kamera: 50MP utama, 2MP makro
          * Harga: Rp2.399.000 (kategori: murah)
          * Keunggulan: Seimbang di semua aspek, harga terjangkau
       
       - Samsung Galaxy S20: 
          * Prosesor: Exynos 990 (2.7 GHz, 8 core)
          * RAM: 8GB LPDDR5 (kategori: sedang)
          * Storage: 128GB UFS 3.0
          * Layar: 6.2" 120Hz Dynamic AMOLED (kategori: sedang)
          * Baterai: 4000mAh (kategori: sedang)
          * Kamera: 12MP utama, 64MP telephoto, 12MP ultrawide
          * Harga: Rp9.999.000 (kategori: mahal)
          * Keunggulan: Performa flagship yang masih relevan, kamera serbaguna
    
    7. HP Performa Tinggi:
       - Oppo A77s: 
          * Prosesor: Snapdragon 680 (2.4 GHz, 8 core)
          * RAM: 8GB LPDDR4X (kategori: sedang)
          * Storage: 128GB UFS 2.2
          * Layar: 6.56" IPS LCD (kategori: besar)
          * Baterai: 5000mAh (kategori: besar)
          * Kamera: 50MP utama, 2MP depth
          * Harga: Rp2.999.000 (kategori: murah)
          * Keunggulan: Performa stabil untuk harga terjangkau
       
       - Xiaomi 13T: 
          * Prosesor: Dimensity 8200-Ultra (3.1 GHz, 8 core)
          * RAM: 8GB LPDDR5 (kategori: sedang)
          * Storage: 256GB UFS 3.1
          * Layar: 6.67" 144Hz AMOLED (kategori: besar)
          * Baterai: 5000mAh, 67W fast charging (kategori: besar)
          * Kamera: 50MP utama, 8MP ultrawide, 2MP makro
          * Harga: Rp6.999.000 (kategori: sedang)
          * Keunggulan: Prosesor kuat, pendinginan efisien untuk performa stabil
  `;

  // Parameter analisis komparatif untuk klasifikasi
  const comparativeAnalysisGuide = `
    PANDUAN ANALISIS KOMPARATIF:
    
    1. Kategori RAM:
       - Kecil: 3-4GB (cukup untuk penggunaan dasar)
       - Sedang: 6-8GB (baik untuk multitasking umum)
       - Besar: 12-16GB (ideal untuk gaming berat dan multitasking intensif)
    
    2. Kategori Penyimpanan:
       - Kecil: 32-64GB (cukup untuk aplikasi dasar dan beberapa foto)
       - Sedang: 128-256GB (ideal untuk pengguna biasa)
       - Besar: 512GB-1TB (untuk pengguna yang banyak menyimpan media dan gamer)
    
    3. Kategori Layar:
       - Kecil: di bawah 6"
       - Sedang: 6"-6.5"
       - Besar: di atas 6.5"
    
    4. Refresh Rate Layar:
       - Standar: 60Hz
       - Menengah: 90Hz-120Hz (baik untuk gaming dan scrolling)
       - Tinggi: di atas 120Hz (optimal untuk gaming kompetitif)
    
    5. Kategori Baterai:
       - Kecil: kurang dari 4000mAh
       - Sedang: 4000-5000mAh
       - Besar: di atas 5000mAh
    
    6. Kategori Kamera Utama:
       - Dasar: 12-16MP
       - Menengah: 48-64MP
       - Flagship: di atas 100MP
    
    7. Kategori Prosesor:
       - Entry-level: MediaTek Helio G series atau Snapdragon seri 4xx-6xx
       - Mid-range: Snapdragon 7xx, Dimensity 700-8000
       - High-end: Snapdragon 8xx, Dimensity 9000
    
    8. Kategori Harga:
       - Murah: Rp1.000.000 - Rp3.000.000
       - Sedang: Rp3.000.001 - Rp7.000.000
       - Mahal: Rp7.000.001 - Rp12.000.000
       - Sangat mahal: di atas Rp12.000.000
    
    9. Kesesuaian Kebutuhan:
       - Gaming: Prioritas pada prosesor high-end, RAM besar (min. 8GB), refresh rate tinggi, sistem pendinginan
       - Fotografi: Prioritas pada kamera flagship, stabilisasi gambar, sensor besar
       - Produktivitas: Prioritas pada RAM besar, layar besar, baterai tahan lama
       - Multimedia: Prioritas pada layar berkualitas, speaker stereo, storage besar
       - Pengguna biasa: Seimbang di semua aspek, harga terjangkau
  `;

  // Buat prompt sistem untuk Gemini API dengan analisis komparatif
  const systemPrompt = `
    Kamu adalah ADROWIIZ, asisten AI canggih yang membantu pelanggan menemukan smartphone terbaik sesuai kebutuhan spesifik mereka.
    
    ${productDatabase}
    
    ${comparativeAnalysisGuide}
    
    Saat memberikan rekomendasi, kamu harus:
    
    1. Analisis kebutuhan pelanggan dengan mendalam melalui kata kunci dan konteks percakapan
    2. Lakukan analisis komparatif berdasarkan kategori-kategori di atas
    3. Berikan rekomendasi HP paling sesuai (maksimal 2-3 pilihan) dengan alasan spesifik yang mengacu pada spesifikasi
    4. Untuk setiap rekomendasi, jelaskan:
       - Kelebihan utama terkait kebutuhan pelanggan
       - Spesifikasi penting yang relevan dengan kebutuhan mereka
       - Kategori komponen (misal: RAM besar, harga sedang, dll)
       - Perbandingan singkat dengan alternatif lain
    5. Jika pelanggan menyebutkan budget, prioritaskan HP dalam rentang harga tersebut
    
    Jangan gunakan kata database, ganti ke kata produk
    Jangan sebutkan kategori nya, agar terlihat lebih natural
    Gunakan analisis komparatif untuk menjelaskan mengapa suatu HP lebih sesuai dibanding HP lain, dan berikan penjelasan teknis sesuai tingkat pemahaman pengguna. Buatlah jawaban dalam bahasa Indonesia yang santai dan ramah dengan emoji seperlunya.
    
    Contoh jawaban yang baik:
    "Halo! Berdasarkan kebutuhan kamu untuk gaming dengan budget sedang, saya rekomendasikan POCO X7 karena memiliki kombinasi RAM sedang (8GB) yang cukup untuk game modern, prosesor Snapdragon 695 yang handal untuk game dengan setelan medium, dan layar 120Hz yang membuat gameplay lebih responsif - semua dengan harga yang masuk kategori sedang (Rp3.299.000). Dibandingkan dengan Oppo A77s yang setipe, POCO X7 memiliki keunggulan di refresh rate layar (120Hz vs 60Hz) yang lebih baik untuk gaming."
  `;

  // Menyiapkan riwayat percakapan untuk API
  let apiConversation = [];
  
  // Tambahkan pesan sistem di awal riwayat
  apiConversation.push({
    role: "user",
    parts: [{ text: systemPrompt }]
  });
  
  apiConversation.push({
    role: "model",
    parts: [{ text: "Saya mengerti. Saya akan berperan sebagai ADROWIIZ, asisten AI yang menggunakan analisis komparatif mendalam untuk merekomendasikan smartphone yang paling sesuai dengan kebutuhan spesifik pelanggan. Saya akan menggunakan database produk dan panduan klasifikasi yang diberikan untuk memberikan rekomendasi yang tepat dan alasan yang detail." }]
  });
  
  // Tambahkan riwayat percakapan sebelumnya (tanpa pesan sistem awal)
  apiConversation = apiConversation.concat(conversationHistory.slice(1));

  // Buat permintaan ke API Gemini 1.5
  const response = await fetch(`${API_URL}?key=${API_KEY}`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      contents: apiConversation,
      generationConfig: {
        temperature: 0.7,
        maxOutputTokens: 1000,
        topP: 0.95,
        topK: 40
      }
    })
  });

  const data = await response.json();
  
  // Penanganan kesalahan untuk respons API
  if (!response.ok) {
    console.error("Kesalahan API Gemini:", data);
    throw new Error("Gagal mendapatkan respons dari AI");
  }
  
  if (!data.candidates || data.candidates.length === 0) {
    throw new Error("Tidak ada respons yang dihasilkan");
  }
  
  return data.candidates[0].content.parts[0].text;
}

// Format respons AI dengan HTML yang tepat
function formatResponse(text) {
  // Ganti pemisah baris dengan tag <br>
  let formatted = text.replace(/\n/g, '<br>');
  
  // Cetak tebal bagian penting menggunakan regex
  formatted = formatted.replace(/\*\*(.*?)\*\*/g, '<b>$1</b>');
  
  // Format untuk spesifikasi teknis
  formatted = formatted.replace(/- (.*?):/g, '- <b>$1</b>:');
  
  return formatted;
}

// Fungsi fallback ketika API tidak tersedia
function getRecommendation(message) {
  message = message.toLowerCase();
  
  // Respons awal
  let response = "Oke, mari kita cari HP yang cocok buat kamu ya 😎<br><br>";

  if (message.includes("gaming")) {
    response += " Kamu sedang cari HP untuk kebutuhan gaming, ya? Berikut rekomendasinya:<br>";
    response += "1. <b>ASUS ROG Phone 9 FE</b> – RAM besar (16GB) dan performa tinggi dengan prosesor Snapdragon 8 Gen 3. Layarnya 165Hz sangat responsif untuk gaming. Harga kategori mahal (Rp10.999.000)<br><br>";
    response += "2. <b>POCO X7</b> – RAM sedang (8GB) dengan Snapdragon 695 yang cukup untuk game populer. Refresh rate 120Hz dengan harga lebih terjangkau di kategori sedang (Rp3.299.000)<br>";
  } else if (message.includes("kamera")) {
    response += " Kalau kamera jadi prioritas utama, ini pilihannya:<br><br>";
    response += "1. <b>Samsung Galaxy S24 Ultra</b> – Kamera utama 200MP (kategori flagship) dengan sensor besar untuk hasil foto detail tinggi. Dilengkapi telephoto 50MP dengan zoom optik 5x. Harga kategori sangat mahal (Rp19.999.000)<br><br>";
    response += "2. <b>Samsung Galaxy S21 Ultra 5G</b> – Kamera utama 108MP (kategori flagship) dengan telephoto 10MP zoom periskop. Kamera selfie 40MP. Harga lebih terjangkau tapi tetap kategori sangat mahal (Rp15.999.000)<br>";
  } else if (message.includes("murah") || message.includes("budget")) {
    response += " Kalau kamu butuh HP dengan harga terjangkau, berikut pilihan terbaiknya:<br><br>";
    response += "1. <b>Redmi Note 9</b> – Harga kategori murah (Rp2.199.000) dengan RAM kecil (4GB) namun baterai besar (5020mAh). Kamera utama 48MP cukup baik untuk harganya.<br><br>";
    response += "2. <b>Realme C55</b> – Harga kategori murah (Rp2.499.000) dengan RAM sedang (6GB) yang lebih baik untuk multitasking. Storage 128GB kategori sedang untuk menyimpan banyak aplikasi dan foto.<br>";
  } else {
    response += "🤔 Bisa tolong dijelaskan lebih detail apa prioritas kamu? Misalnya: kamera, baterai, performa, harga murah, RAM besar, atau penggunaan gaming? Saya bisa memberikan analisis komparatif yang lebih sesuai dengan kebutuhanmu.";
    return response;
  }

  response += "<br>🔍 Ada lagi yang bisa saya bantu? 😊";
  return response;
}