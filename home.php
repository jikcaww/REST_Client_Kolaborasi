<?php
// Ambil semua Pokemon
$api_url = "https://pokeapi.co/api/v2/pokemon?limit=2000"; 
$response = file_get_contents($api_url);
$data = json_decode($response, true);
$pokemon_list = $data["results"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - All Pokémon</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="logo">Pokédex</div>
        <ul>
            <li><a href="index.php">Search</a></li>
            <li><a href="home.php" class="active">Home</a></li>
        </ul>
    </nav>

    <header>
        <h1>All Pokémon</h1>
        <p class="subtitle">Menampilkan semua Pokémon dari API PokeAPI</p>
    </header>

    <div class="pokemon-grid">

        <?php foreach ($pokemon_list as $pokemon): 
            // Ambil ID pokemon dari URL (https://pokeapi.co/api/v2/pokemon/1/)
            $url_parts = explode("/", rtrim($pokemon["url"], "/"));
            $pokemon_id = end($url_parts);
            $img_url = "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/$pokemon_id.png";
        ?>

        <div class="pokemon-card">
            <img src="<?= $img_url ?>" alt="<?= $pokemon['name'] ?>">
            <h3><?= ucfirst($pokemon["name"]) ?></h3>
            <p>#<?= $pokemon_id ?></p>
        </div>

        <?php endforeach; ?>

    </div>

</body>
</html>
