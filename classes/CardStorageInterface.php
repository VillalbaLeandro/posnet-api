<?php

interface CardStorageInterface {
    public function loadCards(): array;
    public function saveCards(array $cards): void;
}
