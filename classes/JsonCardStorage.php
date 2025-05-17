<?php

require_once 'CardStorageInterface.php';

class JsonCardStorage implements CardStorageInterface {
    private string $filePath;

    public function __construct(string $filePath = __DIR__ . '/../data/cards.json') {
        $this->filePath = $filePath;
    }

    public function loadCards(): array {
        if (!file_exists($this->filePath)) return [];
        $json = file_get_contents($this->filePath);
        return json_decode($json, true) ?? [];
    }

    public function saveCards(array $cards): void {
        file_put_contents($this->filePath, json_encode($cards, JSON_PRETTY_PRINT));
    }
}
