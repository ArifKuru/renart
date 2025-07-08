<?php
header('Content-Type: application/json');

require_once $_SERVER["DOCUMENT_ROOT"]."/backend/config/config.php";

function getGoldPricePerGram() {
    $apiKey = "goldapi-45f3dsmctkuaqm-io";
    $url = "https://www.goldapi.io/api/XAU/USD";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "x-access-token: $apiKey",
        "Content-Type: application/json"
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode == 200) {
        $data = json_decode($response, true);
        if (isset($data['price_gram_24k'])) {
            return (float)$data['price_gram_24k'];
        }
    }

    return 0.0;
}

$query = "
    SELECT 
        p.id AS product_id,
        p.name as product_name,
        p.popularityScore,
        p.weight,
        pi.id AS image_id,
        pi.url,
        pi.name,
        pi.color
    FROM products p
    LEFT JOIN product_images pi ON p.id = pi.product_id
    ORDER BY p.id
";

$stmt = $db->prepare($query);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$goldPrice = getGoldPricePerGram();

$products = [];

foreach ($rows as $row) {
    $id = $row['product_id'];

    if (!isset($products[$id])) {
        $products[$id] = [
            'id' => $id,
            'name' => $row['product_name'],
            'popularityScore' => (float)$row['popularityScore'],
            'weight' => (float)$row['weight'],
            'price' => ($goldPrice > 0) ? ceil(($row['popularityScore'] + 1) * $row['weight'] * $goldPrice) : null,
            'images' => []
        ];
    }

    if ($row['url'] && $row['name']) {
        $products[$id]['images'][$row['name']] = [
            'color' => $row['color'],
            'url' => $row['url']
        ];
    }
}

$products = array_values($products);

echo json_encode($products, JSON_PRETTY_PRINT);
?>