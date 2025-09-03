<?php
require_once('config.php');
validate_request_method("POST");

$filters = validate_request_body("POST", [], true); // allow empty request body

$user_id         = isset($filters['user_id']) ? intval($filters['user_id']) : null;
$category_id     = isset($filters['category_id']) ? intval($filters['category_id']) : null;
$sub_category_id = isset($filters['sub_category_id']) ? intval($filters['sub_category_id']) : null;
$brand_id        = isset($filters['brand_id']) ? intval($filters['brand_id']) : null;
$price_min       = isset($filters['price_min']) ? floatval($filters['price_min']) : null;
$price_max       = isset($filters['price_max']) ? floatval($filters['price_max']) : null;
$weight_min      = isset($filters['weight_min']) ? floatval($filters['weight_min']) : null;
$weight_max      = isset($filters['weight_max']) ? floatval($filters['weight_max']) : null;
$size_min        = isset($filters['size_min']) ? floatval($filters['size_min']) : null;
$size_max        = isset($filters['size_max']) ? floatval($filters['size_max']) : null;
$search_query    = isset($filters['search_query']) ? trim($filters['search_query']) : null;
$brand = isset($filters['brand']) ? trim($filters['brand']) : null;

$sql = "
  SELECT DISTINCT p.id, p.name, p.description, p.price, p.size, p.weight, p.image_url,
         b.name AS brand_name, c.name AS category_name, sc.name AS sub_category_name,
         IF(f.id IS NOT NULL AND f.status = 1, 1, 0) AS is_favorite,
         IF(ca.id IS NOT NULL AND ca.status = 1, 1, 0) AS is_cart
  FROM products p
  LEFT JOIN brands b ON p.brand_id = b.id
  LEFT JOIN product_sub_categories psc ON p.id = psc.product_id
  LEFT JOIN sub_categories sc ON psc.sub_category_id = sc.id
  LEFT JOIN categories c ON sc.category_id = c.id
  LEFT JOIN user_favorite f ON f.product_id = p.id AND f.user_id = ? AND f.status = 1
  LEFT JOIN user_cart ca ON ca.product_id = p.id AND ca.user_id = ? AND ca.status = 1
  WHERE p.status = 1
";

$params = [$user_id ?? 0, $user_id ?? 0]; // for f.user_id and ca.user_id
$types = "ii";

// Exact match filters
if ($category_id) {
  $sql .= " AND c.id = ? ";
  $types .= "i";
  $params[] = $category_id;
}
if ($sub_category_id) {
  $sql .= " AND sc.id = ? ";
  $types .= "i";
  $params[] = $sub_category_id;
}
if ($brand) {
  $sql .= " AND p.brand = ? ";
  $types .= "s";
  $params[] = $brand;
}

if ($price_min !== null) {
  $sql .= " AND p.price >= ? ";
  $types .= "d";
  $params[] = $price_min;
}
if ($price_max !== null) {
  $sql .= " AND p.price <= ? ";
  $types .= "d";
  $params[] = $price_max;
}
if ($weight_min !== null) {
  $sql .= " AND p.weight >= ? ";
  $types .= "d";
  $params[] = $weight_min;
}
if ($weight_max !== null) {
  $sql .= " AND p.weight <= ? ";
  $types .= "d";
  $params[] = $weight_max;
}
if ($size_min !== null) {
  $sql .= " AND p.size >= ? ";
  $types .= "d";
  $params[] = $size_min;
}
if ($size_max !== null) {
  $sql .= " AND p.size <= ? ";
  $types .= "d";
  $params[] = $size_max;
}

// Fuzzy Search
if ($search_query) {
  $wild = '%' . $search_query . '%';
  $sql .= " AND (
    p.name LIKE ? OR
    b.name LIKE ? OR
    c.name LIKE ? OR
    sc.name LIKE ? OR
    p.description LIKE ? OR
    p.size LIKE ? OR
    p.weight LIKE ? OR
    p.price LIKE ?
  )";
  $types .= "ssssssss";
  array_push($params, $wild, $wild, $wild, $wild, $wild, $wild, $wild, $wild);
}

$sql .= " ORDER BY p.id DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();

$result = $stmt->get_result();
$products = [];
while ($row = $result->fetch_assoc()) {
  $products[] = [
    "id" => $row['id'],
    "name" => $row['name'],
    "description" => $row['description'],
    "price" => floatval($row['price']),
    "size" => $row['size'],
    "weight" => $row['weight'],
    "image" => $row['image_url'],
    "brand" => $row['brand_name'],
    "category" => $row['category_name'],
    "sub_category" => $row['sub_category_name'],
    "is_favorite" => boolval($row['is_favorite']),
    "is_cart" => boolval($row['is_cart']),
  ];
}

print_response(true, "Filtered products fetched", [ "products" => $products ]);
