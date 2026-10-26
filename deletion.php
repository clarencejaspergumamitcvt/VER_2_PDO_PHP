<?php
/**
 * Location: PDO/delete_example.php
 * 
 * Demonstrates deleting a record from the grocery_items table
 * using PDO prepared statements with named parameters.
 */

// Include the database configuration file from the PDO directory
require_once 'dbconfig.php';

try {
    // Define the primary key ID of the item to delete
    $itemIdToDelete = 1;

    // SQL query using named parameter for secure deletion
    $sql = "DELETE FROM grocery_items WHERE item_id = :item_id";

    // Prepare the SQL statement
    $stmt = $pdo->prepare($sql);

    // Bind parameters and execute statement
    $stmt->execute([':item_id' => $itemIdToDelete]);

    // Check row count to verify if a record was actually deleted
    $deletedRowCount = $stmt->rowCount();

    echo "<pre>";
    if ($deletedRowCount > 0) {
        echo "Success: Record with item_id {$itemIdToDelete} was successfully deleted.\n";
        echo "Rows affected: {$deletedRowCount}\n";
    } else {
        echo "Notice: No record found with item_id {$itemIdToDelete}.\n";
    }
    echo "</pre>";

} catch (PDOException $e) {
    // Handle deletion errors (e.g., foreign key constraints)
    echo "Deletion Error: " . $e->getMessage();
}
?>
