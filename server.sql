-- host.docker.internal,1433

CREATE TABLE items (
    item_id INT PRIMARY KEY,
    item_name VARCHAR(50),
    description VARCHAR(255),
    price DECIMAL(10, 2),
    quantity INT
)

INSERT INTO items (item_id, item_name, description, price, quantity)
VALUES (1, 'shirt', 'very durable', 10000, 10000);

SELECT * FROM items;