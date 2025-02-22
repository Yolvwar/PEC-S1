CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    account_activation_hash VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (name, email, username, password) VALUES
('John Doe', 'test@example.com', 'johndoe', 'password123'),
('Jane Smith', 'test2@example.com', 'janesmith', 'password123');


CREATE TABLE services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT
);

INSERT INTO services (name, description) VALUES
('Réparation', 'Service de réparation pour divers appareils.'),
('Entretien', 'Service d entretien régulier.'),
('Dépannage d\'urgence', 'Service de dépannage en cas d\'urgence.');

CREATE TABLE locations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    street VARCHAR(255) NOT NULL,
    address TEXT NOT NULL,
    city VARCHAR(255) NOT NULL,
    postal_code VARCHAR(10) NOT NULL
);

INSERT INTO locations (street, address, city, postal_code) VALUES
('123 Rue Principale', 'Adresse 1', 'Paris', '12345'),
('456 Avenue des Entreprises', 'Adresse 2', 'Lyon', '67890'),
('789 Boulevard des Champs', 'Adresse 3', 'Marseille', '11223');

CREATE TABLE time_slots (
    id INT AUTO_INCREMENT PRIMARY KEY,
    time_range VARCHAR(255) NOT NULL
);

INSERT INTO time_slots (time_range) VALUES
('08:00 - 10:00'),
('10:00 - 12:00'),
('14:00 - 16:00'),
('16:00 - 18:00');

CREATE TABLE technicians (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    speciality VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    available TINYINT DEFAULT 1,
    status ENUM('available', 'busy', 'offline') NOT NULL,
    experience INT NOT NULL,
    location_id INT,
    FOREIGN KEY (location_id) REFERENCES locations(id)
);

INSERT INTO technicians (name, email, speciality, phone, status, experience, location_id) VALUES
('Technician 1', 'tech1@example.com', 'Carroserie', '1234567890', 'available', 5, 1),
('Technician 2', 'tech2@example.com', 'Électrique', '0987654321', 'busy', 3, 2),
('Technician 3', 'tech3@example.com', 'Mécanique', '0987654321', 'offline', 4, 2);


CREATE TABLE service_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    service_id INT NOT NULL,
    location_id INT NOT NULL,
    time_slot_id INT NOT NULL,
    technician_id INT,
    description TEXT,
    completed TINYINT DEFAULT 0,
    vehicle_type ENUM('scooter', 'moto') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (service_id) REFERENCES services(id),
    FOREIGN KEY (location_id) REFERENCES locations(id),
    FOREIGN KEY (time_slot_id) REFERENCES time_slots(id),
    FOREIGN KEY (technician_id) REFERENCES technicians(id)
);

INSERT INTO service_requests (user_id, service_id, location_id, time_slot_id, technician_id, description, completed, vehicle_type) VALUES
(1, 1, 1, 1, 1, 'Réparation de la machine à laver.', 1, 'scooter'),
(1, 2, 2, 2, 2, 'Entretien annuel du système de chauffage.', 0, 'moto'),
(1, 3, 3, 3, 3, 'Dépannage d\'urgence pour une fuite d\'eau.', 0, 'scooter'),
(2, 1, 1, 1, NULL, 'Réparation de la machine à laver.', 0, 'scooter'),
(2, 2, 2, 2, NULL, 'Entretien annuel du système de chauffage.', 0, 'moto'),
(2, 3, 3, 3, NULL, 'Dépannage d\'urgence pour une fuite d\'eau.', 0, 'scooter');

CREATE TABLE evaluations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    service_request_id INT NOT NULL,
    rating INT NOT NULL,
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (service_request_id) REFERENCES service_requests(id)
);

CREATE TABLE devis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    service_request_id INT NOT NULL,
    estimated_cost DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (service_request_id) REFERENCES service_requests(id)
);

-- Insertion de devis en mars
INSERT INTO devis (service_request_id, estimated_cost, created_at) VALUES
(1, 100.00, '2025-03-10 10:00:00');

-- Insertion de devis en avril
INSERT INTO devis (service_request_id, estimated_cost, created_at) VALUES
(2, 110.00, '2025-04-05 10:00:00');


-- Insertion de devis en juin
INSERT INTO devis (service_request_id, estimated_cost, created_at) VALUES
(3, 250.00, '2025-06-05 10:00:00');



-- Insertion de devis en juillet
INSERT INTO devis (service_request_id, estimated_cost, created_at) VALUES
(4, 130.00, '2025-07-05 10:00:00');



-- Insertion de devis en août
INSERT INTO devis (service_request_id, estimated_cost, created_at) VALUES
(5, 89.00, '2025-08-05 10:00:00');



-- Insertion de devis en septembre
INSERT INTO devis (service_request_id, estimated_cost, created_at) VALUES
(6, 179.00, '2025-09-05 10:00:00');
