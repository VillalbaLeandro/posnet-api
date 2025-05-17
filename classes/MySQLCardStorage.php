<?php

require_once 'CardStorageInterface.php';

class MySQLCardStorage implements CardStorageInterface {
    private PDO $db;

    public function __construct(PDO $pdo) {
        $this->db = $pdo;
    }

    public function loadCards(): array {
        $stmt = $this->db->query("SELECT * FROM cards");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function saveCards(array $cards): void {
        $this->db->exec("DELETE FROM cards");

        $stmt = $this->db->prepare(
            "INSERT INTO cards (number, type, bank, limit_amount, dni, name) VALUES (?, ?, ?, ?, ?, ?)"
        );

        foreach ($cards as $card) {
            $stmt->execute([
                $card['number'],
                $card['type'],
                $card['bank'],
                $card['limit'],
                $card['dni'],
                $card['name']
            ]);
        }
    }
}
