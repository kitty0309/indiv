# symfony-individual


# db creation
```
create database my_db;
use my_db;
create table component(
    id int not null AUTO_INCREMENT primary key,
    name nvarchar(255) not null,
    price int null, 
    description text null,
    product int null
);
create table product(
    id int not null AUTO_INCREMENT primary key,
    name nvarchar(255) not null,
    price int null, 
    description text null,
    warranty int null 
);
```
