CREATE TABLE users (
    id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `address` VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    `password` VARCHAR(64) NOT NULL,
    phone VARCHAR(15) ,
    created_at DATETIME NOT NULL DEFAULT NOW(),
    PRIMARY KEY(id)
);
CREATE TABLE Categories (
  category_id INT PRIMARY KEY UNSIGNED NOT NULL AUTO_INCREMENT,
  category_name VARCHAR(255)
);
CREATE TABLE Products (
  product_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255),
  `description` TEXT,
  `image` VARCHAR(255),
  price DECIMAL(10, 2) UNSIGNED NOT NULL,
  quantity DECIMAL(10, 2),
  category_id INT UNSIGNED NOT NULL,
  CONSTRAINT category_product FOREIGN KEY (category_id) REFERENCES Categories(category_id)
);
CREATE TABLE Reviews (
  review_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  product_id INT UNSIGNED NOT NULL,
  user_id INT UNSIGNED NOT NULL,
  rating INT UNSIGNED NOT NULL,
  comment TEXT,
  timestamp TIMESTAMP,

  CONSTRAINT product_reviews
  FOREIGN KEY (product_id) REFERENCES Products(product_id) ON UPDATE CASCADE ON DELETE CASCADE,

  CONSTRAINT review_user
  FOREIGN KEY (user_id) REFERENCES Users(user_id) ON UPDATE CASCADE ON DELETE CASCADE
);
CREATE TABLE Orders (
  order_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  order_date DATE,
  total_amount DECIMAL(10, 2),
  CONSTRAINT order_user
  FOREIGN KEY (user_id) REFERENCES Users(user_id) ON UPDATE CASCADE ON DELETE CASCADE
);
CREATE TABLE OrderItems (
  order_item_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  order_id INT UNSIGNED NOT NULL,
  product_id INT UNSIGNED NOT NULL,
  quantity INT UNSIGNED NOT NULL,
  price DECIMAL(10, 2),
  subtotal DECIMAL(10, 2),
  
  CONSTRAINT orderitem_order
  FOREIGN KEY (order_id) REFERENCES Orders(order_id) ON UPDATE CASCADE ON DELETE CASCADE,

  CONSTRAINT orderitem_product
  FOREIGN KEY (product_id) REFERENCES Products(product_id) ON UPDATE CASCADE ON DELETE CASCADE
);

INSERT INTO users (name, email, password,phone,address,field) 
VALUES ('admin', 'Admin@gmail.com', '123456',"01025874685","admin");