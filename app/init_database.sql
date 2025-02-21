CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    account_activation_hash VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (id, name, email, username, password, account_activation_hash) VALUES
(1, 'John Doe', 'john.doe@example.com', 'johndoe', 'password_hash_1', NULL),
(2, 'Jane Smith', 'jane.smith@example.com', 'janesmith', 'password_hash_2', NULL),
(3, 'Alice Johnson', 'alice.johnson@example.com', 'alicejohnson', 'password_hash_3', 'activation_hash_1');

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
('123 Rue Principale', 'Adresse 1', 'Ville 1', '12345'),
('456 Avenue des Entreprises', 'Adresse 2', 'Ville 2', '67890'),
('789 Boulevard des Champs', 'Adresse 3', 'Ville 3', '11223');

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
('Technician 1', 'tech1@example.com', 'Speciality 1', '1234567890', 'available', 5, 1),
('Technician 2', 'tech2@example.com', 'Speciality 2', '0987654321', 'busy', 3, 2);

CREATE TABLE service_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    service_id INT NOT NULL,
    location_id INT NOT NULL,
    time_slot_id INT NOT NULL,
    technician_id INT,
    description TEXT,
    completed TINYINT DEFAULT 0,
    vehicle_type ENUM('car', 'moto') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (service_id) REFERENCES services(id),
    FOREIGN KEY (location_id) REFERENCES locations(id),
    FOREIGN KEY (time_slot_id) REFERENCES time_slots(id),
    FOREIGN KEY (technician_id) REFERENCES technicians(id)
);

INSERT INTO service_requests (user_id, service_id, location_id, time_slot_id, description, vehicle_type) VALUES
(1, 1, 1, 1, 'Réparation de la machine à laver.', 'car'),
(2, 2, 2, 2, 'Entretien annuel du système de chauffage.', 'moto'),
(3, 3, 3, 3, 'Dépannage d\'urgence pour une fuite d\'eau.', 'car');

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
(35, 100.00, '2025-03-10 10:00:00'),
(36, 150.00, '2025-03-15 11:00:00'),
(37, 200.00, '2025-03-20 12:00:00'),
(38, 250.00, '2025-03-25 13:00:00'),
(39, 300.00, '2025-03-30 14:00:00');

-- Insertion de devis en avril
INSERT INTO devis (service_request_id, estimated_cost, created_at) VALUES
(40, 110.00, '2025-04-05 10:00:00'),
(41, 160.00, '2025-04-10 11:00:00'),
(42, 210.00, '2025-04-15 12:00:00');

-- Insertion de devis en juin
INSERT INTO devis (service_request_id, estimated_cost, created_at) VALUES
(43, 120.00, '2025-06-05 10:00:00'),
(44, 170.00, '2025-06-10 11:00:00'),
(45, 220.00, '2025-06-15 12:00:00'),
(46, 270.00, '2025-06-20 13:00:00'),
(47, 320.00, '2025-06-25 14:00:00'),
(48, 370.00, '2025-06-30 15:00:00');

-- Insertion de devis en juillet
INSERT INTO devis (service_request_id, estimated_cost, created_at) VALUES
(49, 130.00, '2025-07-05 10:00:00'),
(50, 180.00, '2025-07-10 11:00:00'),
(51, 230.00, '2025-07-15 12:00:00');

-- Insertion de devis en août
INSERT INTO devis (service_request_id, estimated_cost, created_at) VALUES
(52, 140.00, '2025-08-05 10:00:00'),
(53, 190.00, '2025-08-10 11:00:00'),
(54, 240.00, '2025-08-15 12:00:00');

-- Insertion de devis en septembre
INSERT INTO devis (service_request_id, estimated_cost, created_at) VALUES
(55, 150.00, '2025-09-05 10:00:00'),
(56, 200.00, '2025-09-10 11:00:00'),
(57, 250.00, '2025-09-15 12:00:00');