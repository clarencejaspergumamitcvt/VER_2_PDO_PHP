<?php
/**
 * Location: PDO/render_table_example.php
 * 
 * Demonstrates querying records from the grocery_items table
 * and dynamically rendering the result set inside an HTML table.
 */

// Include the database configuration file from the PDO directory
require_once 'dbconfig.php';

try {
    // SQL query joining grocery_items with categories
    $sql = "SELECT 
                i.item_id,
                i.item_name,
                i.brand_name,
                c.category_name,
                i.unit_price,
                i.unit_of_measure,
                i.stock_quantity,
                i.is_organic
            FROM grocery_items i
            JOIN categories c ON i.category_id = c.category_id
            ORDER BY c.category_name ASC, i.item_name ASC";

    // Prepare and execute the statement
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // Fetch all matching records as an associative array
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Stop execution and print error if query fails
    die("Database Query Failed: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Italian Grocery Inventory</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f6f9;
        }
        h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: #ffffff;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 0.5px;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        tr:hover {
            background-color: #e9ecef;
        }
        .organic-badge {
            color: #28a745;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <h2>Italian Grocery Inventory List</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Item Name</th>
                <th>Brand</th>
                <th>Category</th>
                <th>Price (€)</th>
                <th>Stock</th>
                <th>Organic</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($items)): ?>
                <?php foreach ($items as $row): ?>
                    <tr>
                        <!-- Escape output using htmlspecialchars() to prevent XSS attacks -->
                        <td><?= htmlspecialchars($row['item_id']); ?></td>
                        <td><?= htmlspecialchars($row['item_name']); ?></td>
                        <td><?= htmlspecialchars($row['brand_name']); ?></td>
                        <td><?= htmlspecialchars($row['category_name']); ?></td>
                        <td>€<?= number_format($row['unit_price'], 2); ?></td>
                        <td><?= htmlspecialchars($row['stock_quantity']) . ' ' . htmlspecialchars($row['unit_of_measure']); ?></td>
                        <td>
                            <?php if ($row['is_organic']): ?>
                                <span class="organic-badge">Yes</span>
                            <?php else: ?>
                                No
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align:center;">No grocery records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>
