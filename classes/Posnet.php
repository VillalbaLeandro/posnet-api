<?php

require_once 'Card.php';
require_once 'Ticket.php';
require_once 'CardStorageInterface.php';

class Posnet {
    private CardStorageInterface $storage;

    public function __construct(CardStorageInterface $storage) {
        $this->storage = $storage;
    }

    // Método para registrar una nueva tarjeta
    public function registerCard(Card $card): void {
        $cards = $this->storage->loadCards();

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

        $this->storage->saveCards($cards);
    }

    // Método para procesar un pago
    public function doPayment(string $cardNumber, float $amount, int $installments): Ticket {
        if ($installments < 1 || $installments > 6) {
            throw new Exception("La cantidad de cuotas debe estar entre 1 y 6.");
        }

        $cards = $this->storage->loadCards();
        $found = false;

        foreach ($cards as &$cardData) {
            if ($cardData['number'] === $cardNumber) {
                $found = true;

                // Calcular recargo por cuotas
                $surcharge = ($installments > 1) ? ($amount * (($installments - 1) * 0.03)) : 0;
                $total = $amount + $surcharge;

                if ($cardData['limit'] < $total) {
                    throw new Exception("La tarjeta no tiene límite suficiente para el pago.");
                }

                // Actualizar límite disponible
                $cardData['limit'] -= $total;
                $this->storage->saveCards($cards);

                // Retornar ticket de pago
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
}
