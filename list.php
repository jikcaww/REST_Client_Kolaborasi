<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pokemon</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <header>
            <h1>📜 Daftar Pokemon</h1>
            <p class="subtitle">Lihat semua Pokemon dari PokeAPI</p>

            <a href="index.php" style="text-decoration: none;">
                <button style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color:white;">
                    ⬅ Kembali
                </button>
            </a>
        </header>

        <div id="pokemonList" class="pokemon-grid"></div>

        <div class="pagination">
            <button id="prevBtn" onclick="loadPage(currentPage - 1)">⬅ Sebelumnya</button>
            <span id="pageInfo"></span>
            <button id="nextBtn" onclick="loadPage(currentPage + 1)">Berikutnya ➡</button>
        </div>
    </div>

<script>
const API_BASE_URL = "https://pokeapi.co/api/v2";
let currentPage = 1;
const limit = 20;

async function loadPage(page) {
    if (page < 1) return;

    const offset = (page - 1) * limit;
    const response = await fetch(`${API_BASE_URL}/pokemon?limit=${limit}&offset=${offset}`);
    const data = await response.json();

    currentPage = page;
    document.getElementById("pageInfo").textContent = `Halaman ${currentPage}`;

    renderList(data.results);
}

async function renderList(pokemonList) {
    const container = document.getElementById("pokemonList");
    container.innerHTML = "";

    for (let p of pokemonList) {
        const res = await fetch(p.url);
        const details = await res.json();

        const card = `
            <div class="pokemon-card small-card">
                <img src="${details.sprites.front_default}" class="pokemon-thumb">
                <h3>${capitalize(details.name)}</h3>
                <p>#${details.id.toString().padStart(3, "0")}</p>
                <a href="index.php?pokemon=${details.name}">
                    <button class="view-btn">Lihat Detail</button>
                </a>
            </div>
        `;

        container.innerHTML += card;
    }
}

function capitalize(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}

window.onload = () => loadPage(1);
</script>

<style>
/* Grid */
.pokemon-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

/* Smaller card */
.small-card {
    padding: 15px;
    text-align: center;
}

.pokemon-thumb {
    width: 100px;
    height: 100px;
}

/* Pagination */
.pagination {
    display: flex;
    justify-content: center;
    margin: 20px 0;
    gap: 20px;
}
</style>

</body>
</html>
