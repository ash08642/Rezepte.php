CREATE TABLE gerichte (
    id int primary key AUTO_INCREMENT,
    email varchar(255),
    title varchar(255),
    catogori varchar(255),
    Ingredients varchar(255),
    time int,
    steps varchar(500),
    dateCreated timestamp,
    votes int
);