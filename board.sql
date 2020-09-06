create table reservation (
    reservation_num     int          auto_increment primary key,
    title  varchar(20),
    theater   varchar(60),
    reservation_date date,
    headcount    int
);

insert into reservation(title, theater, reservation_date, headcount) values
    ('꿀벌의하루', 'gangnam', '2020-09-09', 2),
    ('꿀벌의하루', 'gangnam', '2020-09-10', 2),
    ('꿀벌의하루', 'gangnam', '2020-09-11', 2),
    ('꿀벌의하루', 'gangnam', '2020-09-12', 2)

