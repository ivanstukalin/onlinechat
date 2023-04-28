create table if not exists chats
(
    id SERIAL PRIMARY KEY,
    operator_id int,
    user_id int,
    status varchar(255),
    created_at timestamp(0),
    updated_at timestamp(0)
);