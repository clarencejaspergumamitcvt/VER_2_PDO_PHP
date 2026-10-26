<?php
/**
 * Location: PDO/update_example.php
 * 
 * Demonstrates updating an existing record in the grocery_items table
 * using PDO prepared statements with named parameters.
 */

// Include the database configuration file from the PDO directory
require_once 'dbconfig.php';

try {
    // Define the primary key ID and updated values
    $itemIdToUpdate = 2; // Penne Rigate No. 41
    $newPrice = 1.65;
    $newStock = 145;

    // SQL query using named parameters for safe updating
    $sql = "UPDATE grocery_items 
            SET unit_price = :unit_price, 
                stock_quantity = :stock_quantity 
            WHERE item_id = :item_id";

    // Prepare the SQL statement
    $stmt = $pdo->prepare($sql);

    // Bind parameters and execute statement
    $stmt->execute([
        ':unit_price'     => $newPrice,
        ':stock_quantity'  => $newStock,
        ':item_id'        => $itemIdToUpdate
    ]);

    // Check how many rows were modified
    $updatedRowCount = $stmt->rowCount();

    echo "<pre>";
    if ($updatedRowCount > 0) {
        echo "Success: Record with item_id {$itemIdToUpdate} was successfully updated.\n";
        echo "Rows affected: {$updatedRowCount}\n\n";

        // Query and display the updated record to verify changes
        $fetchSql = "SELECT * FROM grocery_items WHERE item_id = :id";
        $fetchStmt = $pdo->prepare($fetchSql);
        $fetchStmt->execute([':id' => $itemIdToUpdate]);
        
        $updatedRecord = $fetchStmt->fetch(PDO::FETCH_ASSOC);
        print_r($updatedRecord);
    } else {
        echo "Notice: No changes were made or item_id {$itemIdToUpdate} does not exist.\n";
    }
    echo "</pre>";

} catch (PDOException $e) {
    // Handle update errors
    echo "Update Error: " . $e->getMessage();
}
?>
