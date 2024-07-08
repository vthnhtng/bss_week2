-- Create the database if it doesn't exist
CREATE DATABASE IF NOT EXISTS mydb;

-- Switch to the newly created database
USE mydb;


CREATE TABLE IF NOT EXISTS devices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    MAC VARCHAR(20) UNIQUE NOT NULL,
    IP VARCHAR(20) UNIQUE NOT NULL,
    createdDate DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    powerConsumption INT NOT NULL
);

CREATE TABLE IF NOT EXISTS logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    deviceId INT NOT NULL,
    logAction VARCHAR(20),
    logDate DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (deviceId) REFERENCES devices(id) ON DELETE CASCADE
);

INSERT INTO devices (name, MAC, IP, powerConsumption) VALUES
('Device1', '00:1A:2B:3C:4D:5E', '192.168.1.2', 1575),
('Device2', '00:1A:2B:3C:4D:1F', '192.168.1.3', 1050),
('Device3', '00:1A:2B:3C:4D:3F', '192.168.1.4', 1050),
('Device4', '00:1A:2B:3C:4D:7F', '192.168.1.5', 1050),
('Device5', '00:1A:2B:3C:4D:60', '192.168.1.6', 2025);


INSERT INTO logs (deviceId, logAction) VALUES
(1, 'Turn On'),
(1, 'Sleep'),
(2, 'Turn On'),
(2, 'Turn Off'),
(3, 'Turn On'),
(3, 'Turn On'),
(4, 'Turn Off'),
(4, 'Turn Off'),
(5, 'Sleep'),
(5, 'Turn On'),
(1, 'Turn On'),
(1, 'Sleep'),
(2, 'Turn On'),
(2, 'Turn Off'),
(3, 'Turn On'),
(3, 'Turn On'),
(4, 'Turn Off'),
(4, 'Turn Off'),
(5, 'Sleep'),
(5, 'Turn On');
