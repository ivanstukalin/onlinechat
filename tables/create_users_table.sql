create table if not exists users
(
    id SERIAL PRIMARY KEY,
    name varchar(255),
    role_id int,
    created_at timestamp(0)
);

insert into users (name, role_id, created_at) VALUES ('Admin', 1, now())