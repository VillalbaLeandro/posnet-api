CREATE TABLE cards (
    number CHAR(8) PRIMARY KEY,
    type VARCHAR(10) NOT NULL,
    bank VARCHAR(50) NOT NULL,
    limit_amount FLOAT NOT NULL,
    dni VARCHAR(20) NOT NULL,
    name VARCHAR(100) NOT NULL
);
