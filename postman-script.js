// Postman Script untuk Pokemon REST Client
// Script ini dapat digunakan di Postman Pre-request Script atau Tests tab

// ============================================
// KONFIGURASI
// ============================================
const API_BASE_URL = 'https://pokeapi.co/api/v2';
const API_KEY = '45085cc92b974b4ba1935516454e8ec7';

// ============================================
// PRE-REQUEST SCRIPT
// ============================================
// Tambahkan script ini di tab "Pre-request Script" di Postman

// Set API Key sebagai environment variable
pm.environment.set("api_key", API_KEY);
pm.environment.set("api_base_url", API_BASE_URL);

// Set API Key sebagai header otomatis
pm.request.headers.add({
    key: 'X-API-Key',
    value: API_KEY
});

// Atau gunakan Authorization header
// pm.request.headers.add({
//     key: 'Authorization',
//     value: `Bearer ${API_KEY}`
// });

// ============================================
// TEST SCRIPT
// ============================================
// Tambahkan script ini di tab "Tests" di Postman

// Test 0: API Connection Check
pm.test("API is connected and reachable", function () {
    pm.expect(pm.response.code).to.be.oneOf([200, 201, 204]);
    pm.expect(pm.response.responseTime).to.be.below(10000); // Response time should be less than 10 seconds
});

// Test 1: Status Code Check
pm.test("Status code is 200", function () {
    pm.response.to.have.status(200);
});

// Test 2: Response Time Check
pm.test("Response time is less than 2000ms", function () {
    pm.expect(pm.response.responseTime).to.be.below(2000);
});

// Test 3: Content Type Check
pm.test("Content-Type is application/json", function () {
    pm.expect(pm.response.headers.get("Content-Type")).to.include("application/json");
});

// Test 4: Pokemon Data Structure Check
pm.test("Response has Pokemon data structure", function () {
    const jsonData = pm.response.json();
    pm.expect(jsonData).to.have.property('id');
    pm.expect(jsonData).to.have.property('name');
    pm.expect(jsonData).to.have.property('types');
    pm.expect(jsonData).to.have.property('abilities');
    pm.expect(jsonData).to.have.property('stats');
    pm.expect(jsonData).to.have.property('sprites');
});

// Test 5: Pokemon ID Validation
pm.test("Pokemon ID is a number", function () {
    const jsonData = pm.response.json();
    pm.expect(jsonData.id).to.be.a('number');
});

// Test 6: Pokemon Name Validation
pm.test("Pokemon name is a string", function () {
    const jsonData = pm.response.json();
    pm.expect(jsonData.name).to.be.a('string');
});

// Test 7: Types Array Check
pm.test("Types is an array", function () {
    const jsonData = pm.response.json();
    pm.expect(jsonData.types).to.be.an('array');
    pm.expect(jsonData.types.length).to.be.above(0);
});

// Test 8: Abilities Array Check
pm.test("Abilities is an array", function () {
    const jsonData = pm.response.json();
    pm.expect(jsonData.abilities).to.be.an('array');
    pm.expect(jsonData.abilities.length).to.be.above(0);
});

// Test 9: Stats Array Check
pm.test("Stats is an array with 6 items", function () {
    const jsonData = pm.response.json();
    pm.expect(jsonData.stats).to.be.an('array');
    pm.expect(jsonData.stats.length).to.equal(6);
});

// Test 10: Save Pokemon Data to Environment
pm.test("Save Pokemon data to environment", function () {
    const jsonData = pm.response.json();
    pm.environment.set("pokemon_id", jsonData.id);
    pm.environment.set("pokemon_name", jsonData.name);
    pm.environment.set("pokemon_types", JSON.stringify(jsonData.types.map(t => t.type.name)));
});

// ============================================
// HELPER FUNCTIONS
// ============================================

// Function untuk format Pokemon name
function capitalizeFirst(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}

// Function untuk mendapatkan random Pokemon ID
function getRandomPokemonId() {
    return Math.floor(Math.random() * 898) + 1;
}

// Function untuk set random Pokemon ID
pm.environment.set("random_pokemon_id", getRandomPokemonId());

// ============================================
// CONSOLE LOGS (untuk debugging)
// ============================================
console.log("API Key:", API_KEY);
console.log("API Base URL:", API_BASE_URL);
console.log("Request URL:", pm.request.url.toString());

// Log response jika berhasil
if (pm.response.code === 200) {
    const jsonData = pm.response.json();
    console.log("Pokemon Name:", capitalizeFirst(jsonData.name));
    console.log("Pokemon ID:", jsonData.id);
    console.log("Pokemon Types:", jsonData.types.map(t => t.type.name).join(", "));
}

// ============================================
// CONTOH REQUEST BODY (jika diperlukan)
// ============================================
// Untuk POST/PUT requests, gunakan format berikut:
/*
{
    "pokemon_id": {{pokemon_id}},
    "pokemon_name": "{{pokemon_name}}"
}
*/

// ============================================
// CONTOH COLLECTION VARIABLES
// ============================================
// Di Postman, set Collection Variables:
// - api_key: 45085cc92b974b4ba1935516454e8ec7
// - api_base_url: https://pokeapi.co/api/v2
// - pokemon_id: 1
// - pokemon_name: bulbasaur

// ============================================
// CONTOH ENVIRONMENT VARIABLES
// ============================================
// Di Postman, set Environment Variables:
// - api_key: 45085cc92b974b4ba1935516454e8ec7
// - api_base_url: https://pokeapi.co/api/v2

