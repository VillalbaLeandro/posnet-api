<?php

class Client {
    private string $dni;
    private string $firstName;
    private string $lastName;

    public function __construct(string $dni, string $firstName, string $lastName) {
        $this->dni = $dni;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function getFullName(): string {
        return "{$this->firstName} {$this->lastName}";
    }

    public function getDni(): string {
        return $this->dni;
    }
}
