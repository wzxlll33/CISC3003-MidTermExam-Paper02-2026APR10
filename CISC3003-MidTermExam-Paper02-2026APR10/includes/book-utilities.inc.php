<?php
/**
 * Book Utilities Functions
 * CISC3003 Web Programming - Suggested Exercise 10
 * Student ID: DC228114
 * Name: Kris Wu
 */

/**
 * Read customers from file and return as array
 * @param string $filename Path to customers file
 * @return array Array of customer data
 */
function readCustomers($filename) {
    $customers = array();
    
    if (file_exists($filename)) {
        $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        foreach ($lines as $line) {
            $data = explode(';', $line);
            
            if (count($data) >= 12) {
                $customer = array(
                    'id' => trim($data[0]),
                    'firstname' => trim($data[1]),
                    'lastname' => trim($data[2]),
                    'email' => trim($data[3]),
                    'university' => trim($data[4]),
                    'address' => trim($data[5]),
                    'city' => trim($data[6]),
                    'state' => trim($data[7]),
                    'country' => trim($data[8]),
                    'zip' => trim($data[9]),
                    'phone' => trim($data[10]),
                    'sales' => trim($data[11])
                );
                $customers[] = $customer;
            }
        }
    }
    
    return $customers;
}

/**
 * Read orders for a specific customer from file
 * @param string $customer Customer ID to search for
 * @param string $filename Path to orders file
 * @return array Array of order data for the customer
 */
function readOrders($customer, $filename) {
    $orders = array();
    
    if (file_exists($filename)) {
        $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        foreach ($lines as $line) {
            $data = explode(',', $line);
            
            if (count($data) >= 5) {
                // Check if this order belongs to the customer
                if (trim($data[1]) == $customer) {
                    $order = array(
                        'order_id' => trim($data[0]),
                        'customer_id' => trim($data[1]),
                        'isbn' => trim($data[2]),
                        'title' => trim($data[3]),
                        'category' => trim($data[4])
                    );
                    $orders[] = $order;
                }
            }
        }
    }
    
    return $orders;
}

/**
 * Read all books from file into associative array (keyed by ISBN)
 * @param string $filename Path to books file
 * @return array Array of book data keyed by ISBN
 */
function readBooks($filename) {
    $books = array();
    
    if (file_exists($filename)) {
        $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        foreach ($lines as $line) {
            // Skip lines that don't start with a number (book ID)
            if (!preg_match('/^\d+,/', $line)) {
                continue;
            }
            
            $data = explode(',', $line);
            
            if (count($data) >= 4) {
                $isbn = trim($data[1]);
                $book = array(
                    'book_id' => trim($data[0]),
                    'isbn' => $isbn,
                    'isbn13' => trim($data[2]),
                    'title' => trim($data[3]),
                    'year' => isset($data[4]) ? trim($data[4]) : '',
                    'category_id' => isset($data[5]) ? trim($data[5]) : '',
                    'publisher_id' => isset($data[6]) ? trim($data[6]) : '',
                    'available' => isset($data[7]) ? trim($data[7]) : ''
                );
                $books[$isbn] = $book;
            }
        }
    }
    
    return $books;
}

/**
 * Get book cover image path based on ISBN
 * @param string $isbn Book ISBN
 * @return string Path to cover image (relative)
 */
function getBookCoverPath($isbn) {
    // Check if cover image exists in tinysquare folder
    $coverPath = 'images/tinysquare/' . $isbn . '.jpg';
    
    if (file_exists($coverPath)) {
        return $coverPath;
    }
    
    // Return default placeholder if no cover found
    return 'images/tinysquare/default.jpg';
}
?>