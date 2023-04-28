create table if not exists operators
(
    id SERIAL PRIMARY KEY,
    name varchar(255),
    created_at timestamp(0),
    updated_at timestamp(0)
);

insert into operators (name, created_at) VALUES ('Admin', now())