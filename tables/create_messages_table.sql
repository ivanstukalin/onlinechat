create table if not exists messages
(
    id SERIAL PRIMARY KEY,
    sender_id int,
    chat_id int,
    text varchar(255),
    type varchar(255),
    created_at timestamp(0),
    updated_at timestamp(0)
);