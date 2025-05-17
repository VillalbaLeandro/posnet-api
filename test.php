<?php

require_once 'classes/Client.php';
require_once 'classes/Card.php';
require_once 'classes/Ticket.php';
require_once 'classes/Posnet.php';
require_once 'classes/CardStorageInterface.php';
require_once 'classes/JsonCardStorage.php';
// require_once 'classes/MySQLCardStorage.php';
// require_once 'db/Connection.php';

// ==============================
//  SWITCH ENTRE JSON Y MYSQL
// ==============================

// - Usar almacenamiento JSON
$storage = new JsonCardStorage();

// - Usar almacenamiento MySQL:
// $pdo = Connection::getInstance();
// $storage = new MySQLCardStorage($pdo);

$posnet = new Posnet($storage);

function printHeader(string $title): void {
    echo "\n==============================\n";
    echo strtoupper($title) . "\n";
    echo "==============================\n";
}

function printTicket(Ticket $ticket) {
    $data = $ticket->toArray();
    echo "✔ Pago exitoso\n";
    echo "Cliente: " . $data['client'] . "\n";
    echo "Total a pagar: $" . $data['total_amount'] . "\n";
    echo "Cuotas: " . $data['installments'] . "\n";
    echo "Monto por cuota: $" . $data['installment_amount'] . "\n";
}

// ------------------------------
// CASE 1 - Successful registration and payment in 5 installments
// ------------------------------
printHeader("CASE 1 - Successful registration and payment in 5 installments");
try {
    $client1 = new Client("12345678", "Leandro", "Villalba");
    $card1 = new Card("VISA", "Banco Nación", "12345678", 100000, $client1);
    $posnet->registerCard($card1);
    echo "Tarjeta registrada correctamente.\n";

    $ticket1 = $posnet->doPayment("12345678", 25000, 5);
    printTicket($ticket1);
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

// ------------------------------
// CASE 2 - Successful payment in 1 installment (no surcharge)
// ------------------------------
printHeader("CASE 2 - Successful payment in 1 installment (no surcharge)");
try {
    $ticket2 = $posnet->doPayment("12345678", 5000, 1);
    printTicket($ticket2);
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

// ------------------------------
// CASE 3 - Invalid card type
// ------------------------------
printHeader("CASE 3 - Invalid card type");
try {
    $client2 = new Client("22334455", "María", "López");
    $card2 = new Card("MASTERCARD", "Banco Río", "87654321", 80000, $client2); // debe fallar
    $posnet->registerCard($card2);
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

// ------------------------------
// CASE 4 - Invalid card number (less than 8 digits)
// ------------------------------
printHeader("CASE 4 - Invalid card number (less than 8 digits)");
try {
    $client3 = new Client("99887766", "Juan", "Pérez");
    $card3 = new Card("VISA", "Banco Santander", "1234567", 50000, $client3); // debe fallar
    $posnet->registerCard($card3);
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

// ------------------------------
// CASE 5 - Installments out of allowed range
// ------------------------------
printHeader("CASE 5 - Installments out of allowed range");
try {
    $ticket3 = $posnet->doPayment("12345678", 10000, 7); // debe fallar
    printTicket($ticket3);
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

// ------------------------------
// CASE 6 - Insufficient credit limit
// ------------------------------
printHeader("CASE 6 - Insufficient credit limit");
try {
    $ticket4 = $posnet->doPayment("12345678", 999999, 2); // debe fallar
    printTicket($ticket4);
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

// ------------------------------
// CASE 7 - Nonexistent card number
// ------------------------------
printHeader("CASE 7 - Nonexistent card number");
try {
    $ticket5 = $posnet->doPayment("99999999", 10000, 3); // debe fallar
    printTicket($ticket5);
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
