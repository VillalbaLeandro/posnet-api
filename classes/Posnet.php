<?php

require_once 'Card.php';
require_once 'Ticket.php';

class Posnet {
    private string $dataFile;

    public function __construct(string $dataFile = __DIR__ . '/../data/cards.json') {
        $this->dataFile = $dataFile;
    }

    // Método para registrar una nueva tarjeta
    public function registerCard(Card $card): void {
        $cards = $this->loadCards();

        $updated = false;

        foreach ($cards as &$existingCard) {
            if ($existingCard['number'] === $card->getNumber()) {
                $existingCard = $card->toArray(); // Actualiza datos del cliente o nuevo límite
                $updated = true;
                break;
            }
        }
        
        if (!$updated) {
            $cards[] = $card->toArray(); // Tarjeta nueva
        }
        
        $this->saveCards($cards);
        
    }

    // Método para procesar un pago
    public function doPayment(string $cardNumber, float $amount, int $installments): Ticket {
        if ($installments < 1 || $installments > 6) {
            throw new Exception("La cantidad de cuotas debe estar entre 1 y 6.");
        }

        $cards = $this->loadCards();
        $found = false;

        foreach ($cards as &$cardData) {
            if ($cardData['number'] === $cardNumber) {
                $found = true;

                // Calcular recargo
                $recargo = ($installments > 1) ? ($amount * (($installments - 1) * 0.03)) : 0;
                $total = $amount + $recargo;

                if ($cardData['limit'] < $total) {
                    throw new Exception("La tarjeta no tiene límite suficiente para el pago.");
                }

                // Actualizar límite
                $cardData['limit'] -= $total;
                $this->saveCards($cards);

                // Crear y devolver ticket
                return new Ticket(
                    $cardData['name'],
                    round($total, 2),
                    round($total / $installments, 2),
                    $installments
                );
            }
        }

        if (!$found) {
            throw new Exception("Tarjeta no encontrada.");
        }

        throw new Exception("Error inesperado al procesar el pago.");
    }

    // Cargar tarjetas desde el archivo JSON
    private function loadCards(): array {
        if (!file_exists($this->dataFile)) return [];
        $json = file_get_contents($this->dataFile);
        return json_decode($json, true) ?? [];
    }

    // Guardar tarjetas en archivo JSON
    private function saveCards(array $cards): void {
        file_put_contents($this->dataFile, json_encode($cards, JSON_PRETTY_PRINT));
    }
}
