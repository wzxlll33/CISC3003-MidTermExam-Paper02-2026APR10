<?php
/**
 * CISC3003 Suggested Exercise 10 - CRM Admin
 * Mid-Term Exam Paper 02
 * Student ID: DC228114
 * Name: Kris Wu
 * Date: 2026APR10
 */

include 'includes/book-utilities.inc.php';

// Read all customers
$customers = readCustomers('data/customers.txt');

// Read all books for cover lookup
$books = readBooks('data/books.txt');

// Get selected customer from query string
$selectedCustomer = isset($_GET['customer']) ? $_GET['customer'] : null;
$customerDetails = null;
$customerOrders = array();

// If a customer is selected, get their details and orders
if ($selectedCustomer) {
    foreach ($customers as $customer) {
        if ($customer['id'] == $selectedCustomer) {
            $customerDetails = $customer;
            break;
        }
    }
    
    if ($customerDetails) {
        $customerOrders = readOrders($selectedCustomer, 'data/orders.txt');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DC228114 Kris Wu</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/demo-styles.css">
    <link rel="stylesheet" href="css/material.min.css">
    <script src="js/material.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/jquery.sparkline.2.1.2.js"></script>
    <style>
        .sales-sparkline {
            display: inline-block;
            width: 80px;
            height: 30px;
        }
        .customer-link {
            color: #1976d2;
            text-decoration: none;
            font-weight: 500;
        }
        .customer-link:hover {
            text-decoration: underline;
        }
        .customer-details-card {
            margin-top: 20px;
            padding: 20px;
            background: white;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .orders-table {
            width: 100%;
            margin-top: 10px;
        }
        .no-orders {
            color: #666;
            font-style: italic;
            padding: 20px;
            text-align: center;
        }
        .page-footer {
            margin-top: 40px;
            padding: 20px;
            text-align: center;
            background: #37474f;
            color: white;
            font-size: 14px;
        }
        /* Book Cover Styles */
        .book-cover {
            width: 60px;
            height: 80px;
            object-fit: cover;
            border-radius: 3px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        .book-cover-placeholder {
            width: 60px;
            height: 80px;
            background: #e0e0e0;
            border-radius: 3px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: #666;
            text-align: center;
            padding: 5px;
        }
        .order-row {
            vertical-align: middle;
        }
        .order-cover-cell {
            width: 80px;
            text-align: center;
        }
        .order-info-cell {
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
        
        <!-- Left Navigation -->
        <div class="demo-drawer mdl-layout__drawer mdl-color--blue-grey-900 mdl-color-text--blue-grey-50">
            <header class="demo-drawer-header">
                <img src="images/profile.jpg" class="demo-avatar" alt="Profile">
                <div class="demo-avatar-dropdown">
                    <span>CRM Admin</span>
                </div>
            </header>
            <nav class="demo-navigation mdl-navigation mdl-color--blue-grey-800">
                <a class="mdl-navigation__link" href="cisc3003-sugex10-after.php">
                    <i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">home</i>Home
                </a>
                <a class="mdl-navigation__link" href="cisc3003-sugex10-after.php">
                    <i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">people</i>Customers
                </a>
                <div class="mdl-layout-spacer"></div>
            </nav>
        </div>

        <!-- Main Content -->
        <main class="mdl-layout__content mdl-color--grey-100">
            <div class="mdl-grid demo-content">
                
                <!-- Customers Table Card -->
                <div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col">
                    <div class="mdl-card__title mdl-color--indigo-500 mdl-color-text--white">
                        <h2 class="mdl-card__title-text">Customers</h2>
                    </div>
                    <div class="mdl-card__supporting-text">
                        <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="mdl-data-table__cell--non-numeric">Name</th>
                                    <th class="mdl-data-table__cell--non-numeric">Email</th>
                                    <th class="mdl-data-table__cell--non-numeric">University</th>
                                    <th class="mdl-data-table__cell--non-numeric">City</th>
                                    <th class="mdl-data-table__cell--non-numeric">Country</th>
                                    <th>Sales</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($customers as $customer): ?>
                                <tr>
                                    <td class="mdl-data-table__cell--non-numeric">
                                        <a href="cisc3003-sugex10-after.php?customer=<?php echo $customer['id']; ?>" class="customer-link">
                                            <?php echo $customer['firstname'] . ' ' . $customer['lastname']; ?>
                                        </a>
                                    </td>
                                    <td class="mdl-data-table__cell--non-numeric"><?php echo $customer['email']; ?></td>
                                    <td class="mdl-data-table__cell--non-numeric"><?php echo $customer['university']; ?></td>
                                    <td class="mdl-data-table__cell--non-numeric"><?php echo $customer['city']; ?></td>
                                    <td class="mdl-data-table__cell--non-numeric"><?php echo $customer['country']; ?></td>
                                    <td>
                                        <span class="sales-sparkline" data-values="<?php echo $customer['sales']; ?>"></span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Customer Details Card (shown when customer is selected) -->
                <?php if ($customerDetails): ?>
                <div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col customer-details-card">
                    <div class="mdl-card__title mdl-color--teal-500 mdl-color-text--white">
                        <h2 class="mdl-card__title-text">
                            Customer Details: <?php echo $customerDetails['firstname'] . ' ' . $customerDetails['lastname']; ?>
                        </h2>
                    </div>
                    <div class="mdl-card__supporting-text">
                        <p><strong>ID:</strong> <?php echo $customerDetails['id']; ?></p>
                        <p><strong>Email:</strong> <?php echo $customerDetails['email']; ?></p>
                        <p><strong>University:</strong> <?php echo $customerDetails['university']; ?></p>
                        <p><strong>Address:</strong> <?php echo $customerDetails['address']; ?></p>
                        <p><strong>City:</strong> <?php echo $customerDetails['city']; ?></p>
                        <p><strong>State:</strong> <?php echo $customerDetails['state'] ? $customerDetails['state'] : 'N/A'; ?></p>
                        <p><strong>Country:</strong> <?php echo $customerDetails['country']; ?></p>
                        <p><strong>ZIP:</strong> <?php echo $customerDetails['zip']; ?></p>
                        <p><strong>Phone:</strong> <?php echo $customerDetails['phone']; ?></p>
                        
                        <h4 style="margin-top: 20px;">Orders for <?php echo $customerDetails['firstname'] . ' ' . $customerDetails['lastname']; ?></h4>
                        
                        <?php if (count($customerOrders) > 0): ?>
                        <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp orders-table">
                            <thead>
                                <tr>
                                    <th class="order-cover-cell">Cover</th>
                                    <th>Order ID</th>
                                    <th class="mdl-data-table__cell--non-numeric">ISBN</th>
                                    <th class="mdl-data-table__cell--non-numeric">Book Title</th>
                                    <th class="mdl-data-table__cell--non-numeric">Category</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($customerOrders as $order): 
                                    // Get cover path for this order's book
                                    $coverPath = getBookCoverPath($order['isbn']);
                                ?>
                                <tr class="order-row">
                                    <td class="order-cover-cell">
                                        <?php if (file_exists($coverPath) && $coverPath != 'images/tinysquare/default.jpg'): ?>
                                            <img src="<?php echo $coverPath; ?>" alt="<?php echo $order['title']; ?>" class="book-cover">
                                        <?php else: ?>
                                            <div class="book-cover-placeholder">No Cover</div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="order-info-cell"><?php echo $order['order_id']; ?></td>
                                    <td class="mdl-data-table__cell--non-numeric order-info-cell"><?php echo $order['isbn']; ?></td>
                                    <td class="mdl-data-table__cell--non-numeric order-info-cell"><?php echo $order['title']; ?></td>
                                    <td class="mdl-data-table__cell--non-numeric order-info-cell"><?php echo $order['category']; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php else: ?>
                        <div class="no-orders">
                            <p>No orders found for this customer.</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

            </div>
            
            <!-- FOOTER - REQUIRED FOR MID-TERM EXAM -->
            <footer class="page-footer">
                CISC3003 Web Programming: DC228114 Kris Wu 2026
            </footer>
            
        </main>
    </div>

    <!-- Initialize Sparklines -->
    <script>
        $(document).ready(function() {
            $('.sales-sparkline').each(function() {
                var values = $(this).data('values').split(',');
                $(this).sparkline(values, {
                    type: 'bar',
                    barWidth: 4,
                    height: '30px',
                    barColor: '#1976d2'
                });
            });
        });
    </script>
</body>
</html>