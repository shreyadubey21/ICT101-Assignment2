-- Paws & Polish Pet Grooming database
-- Import this file in phpMyAdmin (Import tab). It creates the database, the tables and some sample data.

DROP DATABASE IF EXISTS paws_polish;
CREATE DATABASE paws_polish CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE paws_polish;

-- Customers who register on the website
CREATE TABLE users (
    user_id    INT AUTO_INCREMENT PRIMARY KEY,
    full_name  VARCHAR(100) NOT NULL,
    username   VARCHAR(50)  NOT NULL UNIQUE,
    email      VARCHAR(100) NOT NULL,
    phone      VARCHAR(20)  NOT NULL,
    password   VARCHAR(255) NOT NULL
);

-- The services we offer, grouped by category
CREATE TABLE services (
    service_id   INT AUTO_INCREMENT PRIMARY KEY,
    category     VARCHAR(50)  NOT NULL,
    service_name VARCHAR(100) NOT NULL,
    description  VARCHAR(255) NOT NULL,
    price        DECIMAL(6,2) NOT NULL
);

-- Each customer's pets (our "pet profile" feature)
CREATE TABLE pets (
    pet_id     INT AUTO_INCREMENT PRIMARY KEY,
    user_id    INT NOT NULL,
    pet_name   VARCHAR(50) NOT NULL,
    pet_type   VARCHAR(20) NOT NULL,
    breed      VARCHAR(50),
    care_notes VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- Service requests / appointment bookings
CREATE TABLE bookings (
    booking_id   INT AUTO_INCREMENT PRIMARY KEY,
    user_id      INT NOT NULL,
    pet_id       INT NOT NULL,
    service_id   INT NOT NULL,
    booking_date DATE NOT NULL,
    booking_time VARCHAR(10) NOT NULL,
    notes        VARCHAR(255),
    status       VARCHAR(20) NOT NULL DEFAULT 'Confirmed',
    FOREIGN KEY (user_id)    REFERENCES users(user_id),
    FOREIGN KEY (pet_id)     REFERENCES pets(pet_id),
    FOREIGN KEY (service_id) REFERENCES services(service_id)
);

-- Feedback and suggestions from visitors
CREATE TABLE feedback (
    feedback_id INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100) NOT NULL,
    email       VARCHAR(100) NOT NULL,
    type        VARCHAR(20)  NOT NULL,
    rating      INT NOT NULL,
    message     TEXT NOT NULL,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ---------- Sample data ----------

INSERT INTO services (category, service_name, description, price) VALUES
('Grooming', 'Bath & Brush', 'Warm bath, blow-dry, full brush-out and ear clean.', 45.00),
('Grooming', 'Full Groom & Style', 'Bath plus a haircut, face trim and paw tidy.', 85.00),
('Grooming', 'Puppy First Groom', 'A short, gentle first groom for puppies under six months.', 40.00),
('Grooming', 'Nail Trim', 'Nails clipped and filed, with a soothing paw balm.', 20.00),
('Grooming', 'Cat Comfort Groom', 'A calm brush and bath for cats in a quiet room.', 70.00),
('Health Care', 'Flea & Tick Treatment', 'Medicated wash and treatment, plus prevention advice.', 35.00),
('Health Care', 'Teeth Brushing', 'Gentle tooth brushing to reduce plaque and bad breath.', 30.00),
('Health Care', 'Health Check & Vet Referral', 'Skin, coat and ear check, with a vet referral if needed.', 25.00),
('Boarding & Walking', 'Day Care', 'A supervised day of play and rest from 9 am to 5 pm.', 55.00),
('Boarding & Walking', 'Overnight Boarding', 'A cosy overnight stay with an evening walk and breakfast.', 75.00),
('Boarding & Walking', 'Dog Walk', 'A 30-minute walk around the neighbourhood.', 25.00),
('Training', 'Basic Obedience Session', 'One-on-one training: sit, stay, come and walking on a lead.', 60.00),
('Training', 'Puppy Class', 'A small group class to help puppies become confident and friendly.', 35.00);

-- Demo account: username demo, password Demo@1234
INSERT INTO users (full_name, username, email, phone, password) VALUES
('Alex Morgan', 'demo', 'alex@example.com', '0412345678', '$2y$10$AmuE.QghPOQwP7Xl8V33euJWKILV/Hy4uNoe2NSKRx/UJNuNtCkpy');

INSERT INTO pets (user_id, pet_name, pet_type, breed, care_notes) VALUES
(1, 'Biscuit', 'Dog', 'Cavoodle', 'Scared of the hair dryer. Sensitive skin.'),
(1, 'Miso', 'Cat', 'Ragdoll', '');

INSERT INTO bookings (user_id, pet_id, service_id, booking_date, booking_time, notes, status) VALUES
(1, 1, 2, '2026-10-20', '10:00 am', 'Short summer cut please.', 'Confirmed');

INSERT INTO feedback (name, email, type, rating, message) VALUES
('Alex Morgan', 'alex@example.com', 'Feedback', 5, 'Biscuit is usually scared of the dryer, but the team was so patient. He came home calm and fluffy!'),
('Priya S.', 'priya@example.com', 'Feedback', 5, 'Booking online was quick and easy. Great service and friendly staff.'),
('Tom W.', 'tom@example.com', 'Suggestion', 4, 'Lovely groom and fair prices. It would be great to have more Saturday times.');
