<?php

class Ticket {
    private string $clientName;
    private float $totalAmount;
    private float $installmentAmount;
    private int $installments;

    public function __construct(string $clientName, float $totalAmount, float $installmentAmount, int $installments) {
        $this->clientName = $clientName;
        $this->totalAmount = $totalAmount;
        $this->installmentAmount = $installmentAmount;
        $this->installments = $installments;
    }

    // Devuelve los datos como array (útil para retornar como JSON o para pruebas)
    public function toArray(): array {
        return [
            'client' => $this->clientName,
            'total_amount' => $this->totalAmount,
            'installments' => $this->installments,
            'installment_amount' => $this->installmentAmount
        ];
    }
}
