<?php
/**
 * Location: PDO/insert_example.php
 * 
 * Demonstrates inserting a new record into the grocery_items table
 * using PDO prepared statements with named parameters.
 */

// Include the database configuration file from the PDO directory
require_once 'dbconfig.php';

try {
    // SQL query using named placeholders for prepared statements
    $sql = "INSERT INTO grocery_items (
                item_name, 
                brand_name, 
                category_id, 
                unit_price, 
                unit_of_measure, 
                stock_quantity, 
                is_organic
            ) VALUES (
                :item_name, 
                :brand_name, 
                :category_id, 
                :unit_price, 
                :unit_of_measure, 
                :stock_quantity, 
                :is_organic
            )";

    // Prepare the SQL statement
    $stmt = $pdo->prepare($sql);

    // Define data array for the new grocery item
    $newItem = [
        ':item_name'       => 'Pesto alla Genovese Biologico (190g)',
        ':brand_name'      => 'Barilla',
        ':category_id'     => 4,        // Olio, Aceto & Condimenti
        ':unit_price'      => 2.89,
        ':unit_of_measure' => 'jar',
        ':stock_quantity'  => 50,
        ':is_organic'      => 1         // TRUE
    ];

    // Execute statement with parameters
    $stmt->execute($newItem);

    // Retrieve the auto-generated primary key ID
    $lastInsertedId = $pdo->lastInsertId();

    echo "<pre>";
    echo "Record successfully inserted!\n";
    echo "Newly Created Item ID: " . $lastInsertedId . "\n\n";

    // Query and display the newly inserted record to verify
    $fetchSql = "SELECT * FROM grocery_items WHERE item_id = :id";
    $fetchStmt = $pdo->prepare($fetchSql);
    $fetchStmt->execute([':id' => $lastInsertedId]);
    
    $insertedRecord = $fetchStmt->fetch(PDO::FETCH_ASSOC);
    print_r($insertedRecord);
    echo "</pre>";

} catch (PDOException $e) {
    // Handle insertion errors
    echo "Insertion Error: " . $e->getMessage();
}
?>
