create table if not exists user_chats
(
    id SERIAL PRIMARY KEY,
    chat_id int,
    user_id int
);
