-- Create the database if it doesn't already exist
CREATE DATABASE IF NOT EXISTS sai_praneeth;

-- Select the database for use
USE sai_praneeth;

-- Create the 'shoes' table
CREATE TABLE IF NOT EXISTS shoes (
    ShoeID INT(11) AUTO_INCREMENT PRIMARY KEY,
    ShoeName VARCHAR(100) NOT NULL,
    Description TEXT,
    QuantityAvailable INT(11) NOT NULL,
    Price DECIMAL(10, 2) NOT NULL,
    ProductAddedBy VARCHAR(100) DEFAULT 'Sai Praneeth',
    Size VARCHAR(10) NOT NULL
);
