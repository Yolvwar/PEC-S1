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
('Entretien', 'Service dentretien régulier.'),
('Dépannage durgence', 'Service de dépannage en cas durgence.');

CREATE TABLE locations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    address TEXT
);

INSERT INTO locations (name, address) VALUES
('Domicile', '123 Rue Principale, Ville, Pays'),
('Bureau', '456 Avenue des Entreprises, Ville, Pays'),
('Adresse personnalisée', '789 Boulevard des Champs, Ville, Pays');

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
    phone VARCHAR(20),
    available BOOLEAN DEFAULT TRUE
);

INSERT INTO technicians (name, email, phone) VALUES
('Technician 1', 'tech1@example.com', '1234567890'),
('Technician 2', 'tech2@example.com', '0987654321');

CREATE TABLE service_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    service_id INT NOT NULL,
    location_id INT NOT NULL,
    time_slot_id INT NOT NULL,
    technician_id INT,
    description TEXT,
    completed BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (service_id) REFERENCES services(id),
    FOREIGN KEY (location_id) REFERENCES locations(id),
    FOREIGN KEY (time_slot_id) REFERENCES time_slots(id),
    FOREIGN KEY (technician_id) REFERENCES technicians(id)
);

INSERT INTO service_requests (user_id, service_id, location_id, time_slot_id, description) VALUES
(1, 1, 1, 1, 'Réparation de la machine à laver.'),
(2, 2, 2, 2, 'Entretien annuel du système de chauffage.'),
(3, 3, 3, 3, 'Dépannage durgence pour une fuite deau.');

CREATE TABLE evaluations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    service_request_id INT NOT NULL,
    rating INT NOT NULL,
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (service_request_id) REFERENCES service_requests(id)
);