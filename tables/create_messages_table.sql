create table if not exists messages
(
    id SERIAL PRIMARY KEY,
    user_id int,
    chat_id int,
    text varchar(255),
    created_at timestamp(0)
);