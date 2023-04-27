create table if not exists roles
(
    id SERIAL PRIMARY KEY,
    name varchar(255)
);

insert into roles (name) VALUES ('admin'),('user');