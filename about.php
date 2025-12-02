<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang - Pokemon REST Client</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Tambahan style khusus untuk halaman about agar tombol kembali terlihat rapi */
        .nav-button {
            display: inline-flex;
            text-decoration: none;
            margin-bottom: 20px;
        }
        .tech-stack {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 10px;
        }
        .about-content p {
            line-height: 1.6;
            color: #555;
            margin-bottom: 15px;
        }
        .feature-list {
            list-style: none;
            margin-top: 10px;
        }
        .feature-list li {
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>ℹ️ Tentang Project</h1>
            <p class="subtitle">Informasi mengenai Aplikasi Pokemon REST Client</p>
        </header>

        <div class="pokemon-card">
            <div class="pokemon-header" style="border-bottom: none; padding-bottom: 0; margin-bottom: 10px;">
                <a href="index.php" id="searchBtn" class="nav-button">
                    <span>🏠</span> Kembali ke Home
                </a>
            </div>

            <div class="pokemon-info">
                <div class="info-section">
                    <h3>⚡ Apa ini?</h3>
                    <div class="about-content">
                        <p>
                            <strong>Pokemon REST Client</strong> adalah aplikasi web sederhana yang memanfaatkan teknologi REST API untuk menampilkan data ensiklopedia Pokemon (Pokedex). 
                            Aplikasi ini mengambil data secara <em>real-time</em> dari <strong>PokeAPI</strong>.
                        </p>
                        <p>
                            Tujuannya adalah untuk mendemonstrasikan bagaimana cara melakukan request API menggunakan JavaScript (Fetch API) dan menampilkannya dengan antarmuka yang modern dan responsif.
                        </p>
                    </div>
                </div>

                <div class="info-section">
                    <h3>🛠️ Teknologi</h3>
                    <p style="margin-bottom: 10px; color: #666;">Project ini dibangun menggunakan:</p>
                    <div class="tech-stack">
                        <span class="type-badge type-fire">HTML5</span>
                        <span class="type-badge type-water">CSS3</span>
                        <span class="type-badge type-electric">JavaScript (ES6+)</span>
                        <span class="type-badge type-psychic">Fetch API</span>
                        <span class="type-badge type-grass">PHP</span>
                        <span class="type-badge type-dragon">PokeAPI v2</span>
                    </div>
                </div>

                <div class="info-section">
                    <h3>✨ Fitur Utama</h3>
                    <ul class="feature-list">
                        <li><span>🔍</span> Pencarian Pokemon berdasarkan Nama atau ID</li>
                        <li><span>🎲</span> Fitur "Random" untuk menemukan Pokemon acak</li>
                        <li><span>📊</span> Visualisasi Statistik (HP, Attack, Defense, dll)</li>
                        <li><span>📱</span> Tampilan Responsif (Mobile Friendly)</li>
                        <li><span>📡</span> Indikator Status Koneksi API Real-time</li>
                    </ul>
                </div>

                <div class="info-section" style="text-align: center;">
                    <p style="font-size: 0.9rem; color: #888;">
                        Dibuat dengan ❤️ untuk pembelajaran Web Development.<br>
                        Data disediakan oleh <a href="https://pokeapi.co/" target="_blank" style="color: #667eea; text-decoration: none; font-weight: bold;">PokeAPI.co</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>