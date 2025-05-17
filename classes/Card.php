<?php

require_once 'Client.php';

class Card {
    private string $type; // VISA or AMEX
    private string $bank;
    private string $number;
    private float $limit;
    private Client $holder;

    public function __construct(string $type, string $bank, string $number, float $limit, Client $holder) {
        $type = strtoupper($type);
        if (!in_array($type, ['VISA', 'AMEX'])) {
            throw new Exception("Tipo de tarjeta inválido. Solo se acepta VISA o AMEX.");
        }

        if (!preg_match('/^\d{8}$/', $number)) {
            throw new Exception("El número de tarjeta debe tener exactamente 8 dígitos.");
        }

        $this->type = $type;
        $this->bank = $bank;
        $this->number = $number;
        $this->limit = $limit;
        $this->holder = $holder;
    }

    public function getNumber(): string {
        return $this->number;
    }

    public function getLimit(): float {
        return $this->limit;
    }

    public function getHolder(): Client {
        return $this->holder;
    }

    public function deductAmount(float $amount): void {
        if ($amount > $this->limit) {
            throw new Exception("Límite insuficiente para procesar el pago.");
        }
        $this->limit -= $amount;
    }

    public function toArray(): array {
        return [
            'type' => $this->type,
            'bank' => $this->bank,
            'number' => $this->number,
            'limit' => $this->limit,
            'dni' => $this->holder->getDni(),
            'name' => $this->holder->getFullName()
        ];
    }
}
