create table if not exists users
(
    id SERIAL PRIMARY KEY,
    name varchar(255),
    created_at timestamp(0),
    updated_at timestamp(0)
);