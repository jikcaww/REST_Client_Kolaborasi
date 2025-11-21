<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokemon REST Client</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <header>
            <h1>⚡ Pokemon REST Client ⚡</h1>
            <p class="subtitle">Explore the Pokemon World with PokeAPI</p>
            <div id="apiStatus" class="api-status">
                <span class="status-indicator" id="statusIndicator"></span>
                <span id="statusText">Memeriksa koneksi API...</span>
            </div>
        </header>

        <div class="search-section">
            <div class="search-box">
                <input type="text" id="pokemonSearch" placeholder="Cari Pokemon (nama atau ID)..." autocomplete="off">
                <button id="searchBtn" onclick="searchPokemon()">
                    <span>🔍</span> Cari
                </button>
                <button id="randomBtn" onclick="getRandomPokemon()">
                    <span>🎲</span> Random
                </button>
            </div>
        </div>

        <div id="loading" class="loading hidden">
            <div class="spinner"></div>
            <p>Memuat data Pokemon...</p>
        </div>

        <div id="error" class="error hidden"></div>

        <div id="pokemonContainer" class="pokemon-container"></div>
    </div>

    <script>
        const API_BASE_URL = 'https://pokeapi.co/api/v2';
        const API_KEY = '45085cc92b974b4ba1935516454e8ec7';

        // Function to check API connection
        async function checkAPIConnection() {
            const statusIndicator = document.getElementById('statusIndicator');
            const statusText = document.getElementById('statusText');
            
            try {
                // Test dengan endpoint sederhana untuk mengecek koneksi
                const controller = new AbortController();
                const timeoutId = setTimeout(() => controller.abort(), 5000); // 5 detik timeout
                
                const response = await fetch(`${API_BASE_URL}/pokemon/1`, {
                    method: 'GET',
                    headers: {
                        'X-API-Key': API_KEY,
                        'Content-Type': 'application/json'
                    },
                    signal: controller.signal
                });
                
                clearTimeout(timeoutId);
                
                if (response.ok) {
                    statusIndicator.className = 'status-indicator status-connected';
                    statusText.textContent = 'API Terhubung';
                    statusText.style.color = '#4ade80';
                } else {
                    throw new Error('API tidak merespon dengan benar');
                }
            } catch (error) {
                if (error.name === 'AbortError') {
                    statusIndicator.className = 'status-indicator status-timeout';
                    statusText.textContent = 'API Timeout - Periksa koneksi internet';
                    statusText.style.color = '#fbbf24';
                } else {
                    statusIndicator.className = 'status-indicator status-disconnected';
                    statusText.textContent = 'API Tidak Terhubung';
                    statusText.style.color = '#ef4444';
                }
            }
        }

        // Check API connection when page loads
        window.addEventListener('DOMContentLoaded', function() {
            checkAPIConnection();
            // Check connection every 30 seconds
            setInterval(checkAPIConnection, 30000);
        });

        // Search Pokemon function
        async function searchPokemon() {
            const searchInput = document.getElementById('pokemonSearch');
            const query = searchInput.value.trim().toLowerCase();
            
            if (!query) {
                showError('Silakan masukkan nama atau ID Pokemon!');
                return;
            }

            showLoading();
            hideError();
            clearContainer();

            try {
                const response = await fetch(`${API_BASE_URL}/pokemon/${query}`, {
                    method: 'GET',
                    headers: {
                        'X-API-Key': API_KEY,
                        'Content-Type': 'application/json'
                    }
                });
                
                if (!response.ok) {
                    throw new Error('Pokemon tidak ditemukan!');
                }

                const data = await response.json();
                displayPokemon(data);
            } catch (error) {
                showError(error.message || 'Terjadi kesalahan saat mengambil data Pokemon');
            } finally {
                hideLoading();
            }
        }

        // Get random Pokemon
        async function getRandomPokemon() {
            const randomId = Math.floor(Math.random() * 898) + 1; // Pokemon IDs 1-898
            document.getElementById('pokemonSearch').value = randomId;
            searchPokemon();
        }

        // Display Pokemon data
        function displayPokemon(pokemon) {
            const container = document.getElementById('pokemonContainer');
            
            const types = pokemon.types.map(t => t.type.name).join(', ');
            const abilities = pokemon.abilities.map(a => a.ability.name).join(', ');
            
            const statsHTML = pokemon.stats.map(stat => `
                <div class="stat-item">
                    <span class="stat-name">${formatStatName(stat.stat.name)}</span>
                    <div class="stat-bar">
                        <div class="stat-fill" style="width: ${(stat.base_stat / 255) * 100}%"></div>
                    </div>
                    <span class="stat-value">${stat.base_stat}</span>
                </div>
            `).join('');

            container.innerHTML = `
                <div class="pokemon-card">
                    <div class="pokemon-header">
                        <h2 class="pokemon-name">${capitalizeFirst(pokemon.name)}</h2>
                        <span class="pokemon-id">#${String(pokemon.id).padStart(3, '0')}</span>
                    </div>
                    
                    <div class="pokemon-image-section">
                        <img src="${pokemon.sprites.other['official-artwork'].front_default || pokemon.sprites.front_default}" 
                             alt="${pokemon.name}" 
                             class="pokemon-image">
                    </div>

                    <div class="pokemon-info">
                        <div class="info-section">
                            <h3>📊 Tipe</h3>
                            <div class="types">
                                ${pokemon.types.map(t => `
                                    <span class="type-badge type-${t.type.name}">${capitalizeFirst(t.type.name)}</span>
                                `).join('')}
                            </div>
                        </div>

                        <div class="info-section">
                            <h3>⚡ Kemampuan</h3>
                            <p class="abilities">${abilities.split(', ').map(a => capitalizeFirst(a)).join(', ')}</p>
                        </div>

                        <div class="info-section">
                            <h3>📈 Statistik</h3>
                            <div class="stats">
                                ${statsHTML}
                            </div>
                        </div>

                        <div class="info-section">
                            <h3>📏 Informasi</h3>
                            <div class="details-grid">
                                <div class="detail-item">
                                    <span class="detail-label">Tinggi</span>
                                    <span class="detail-value">${(pokemon.height / 10).toFixed(1)} m</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Berat</span>
                                    <span class="detail-value">${(pokemon.weight / 10).toFixed(1)} kg</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Base Experience</span>
                                    <span class="detail-value">${pokemon.base_experience}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            container.classList.add('show');
        }

        // Helper functions
        function capitalizeFirst(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }

        function formatStatName(statName) {
            const statMap = {
                'hp': 'HP',
                'attack': 'Attack',
                'defense': 'Defense',
                'special-attack': 'Sp. Attack',
                'special-defense': 'Sp. Defense',
                'speed': 'Speed'
            };
            return statMap[statName] || statName;
        }

        function showLoading() {
            document.getElementById('loading').classList.remove('hidden');
        }

        function hideLoading() {
            document.getElementById('loading').classList.add('hidden');
        }

        function showError(message) {
            const errorDiv = document.getElementById('error');
            errorDiv.textContent = message;
            errorDiv.classList.remove('hidden');
        }

        function hideError() {
            document.getElementById('error').classList.add('hidden');
        }

        function clearContainer() {
            document.getElementById('pokemonContainer').innerHTML = '';
            document.getElementById('pokemonContainer').classList.remove('show');
        }

        // Enter key support
        document.getElementById('pokemonSearch').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                searchPokemon();
            }
        });
    </script>
</body>
</html>
