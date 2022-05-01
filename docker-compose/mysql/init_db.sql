DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `properties`;
DROP TABLE IF EXISTS `search_profiles`;

CREATE TABLE `users` (
  `id` INT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `properties` (
  `id` INT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `propertyType` varchar(255) NOT NULL,
  `fields` JSON NOT NULL
);


CREATE TABLE `search_profiles` (
  `id` INT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `propertyType` varchar(255) NOT NULL,
  `searchFields` JSON NULL
);

-- INSERT INTO `places` (name, visited, lat, lng) VALUES ('Berlin',1,52.52,13.405),('Budapest',1,47.4979,19.0402),('Cincinnati',0,39.1031,-84.512),('Denver',0,39.7392,-104.99),('Helsinki',1,60.1699,24.9384),('Lisbon',1,38.7223,-9.13934),('Moscow',0,55.7558,37.6173),('Nairobi',0,-1.29207,36.8219),('Oslo',1,59.9139,10.7522),('Rio',1,-22.9068,-43.1729),('Tokyo',0,35.6895,139.692);

SET @UUID = (SELECT UUID() AS UUID);

INSERT INTO `properties` (name, address, propertyType, fields) VALUES ('Awesome house in the middle of my town', 'Main street 17, 12456 Berlin', @UUID, '{
  "area" : "180",
  "yearOfConstruction" : "2010",
  "rooms" : "5",
  "heatingType" : "gas",
  "parking" : true,
  "returnActual" : "12.8",
  "price" : "1500000"
	}');
    
INSERT INTO `search_profiles` (name, propertyType, searchFields) VALUES ('Looking for any Awesome realestate!', @UUID , '{
  "price": ["0","2000000"],
  "area": ["150",null],
  "yearOfConstruction": ["2010",null],
  "rooms": ["4",null],
  "returnActual": ["15",null]
}');
