create table reservation (
    reservation_num     int          auto_increment primary key,
    phone varchar(50) not null,
    title  varchar(200) not null,
    theater   varchar(100) not null,
    reservation_date date not null,
    headcount    int not null
);

insert into reservation(phone, title, theater, reservation_date, headcount) values
    ('010-8559-2434','꿀벌의하루', 'gangnam', '2020-09-09', 2),
    ('010-8559-2434','꿀벌의하루', 'gangnam', '2020-09-10', 2),
    ('010-8559-2434','꿀벌의하루', 'gangnam', '2020-09-11', 2),
    ('010-8559-2434','꿀벌의하루', 'gangnam', '2020-09-12', 2)

