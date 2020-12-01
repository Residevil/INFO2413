CREATE TABLE users (
    id INT(11) NOT NULL AUTO_INCREMENT,
    username VARCHAR(50),
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255),
    usertype VARCHAR(20) NOT NULL,
    PRIMARY KEY(id)
);

CREATE TABLE herbs (
    herb_id INT(11) NOT NULL AUTO_INCREMENT,
    herb_name VARCHAR(50) NOT NULL,
    symptoms VARCHAR(255),
    medicinal_uses VARCHAR(1000),
    image VARCHAR(100),
    botanical_description VARCHAR(1000),
    sample_formula VARCHAR(1000),
    PRIMARY KEY(herb_id)
);
