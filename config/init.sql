create database dotinstall_sns_php;

grant all on dotinstall_sns_php.* to dbuser@localhost identified by 'mu4uJsif';

use dotinstall_sns_php

create table users (
  id int not null auto_increment primary key,
  name varchar(255),
  email varchar(255) unique,
  password varchar(255),
  created datetime,
  modified datetime,
  picture varchar(255)
);

create table posts (
  id int not null auto_increment primary key,
  user_id int not null,
  message varchar(255),
  image varchar(255),
  reply_message_id int not null default 0,
  created datetime,
  modified datetime
);

create table relation (
  id int not null auto_increment primary key,
  follow_id int not null,
  follower_id int not null,
  created datetime
);

create table likes (
  id int not null auto_increment primary key,
  post_id int not null,
  user_id int not null,
  created datetime
);



 select u.name, u.id, rank()over(order by count(*) desc) as ranking
  from users u
  left outer join relation r
  on u.id=r.follow_id
  group by u.id
  having u.id=107;


select u.id, u.name, count(*) as count,rank()over(order by count(*) desc) as ranking
    from users u
    left outer join relation r
    on u.id=r.follow_id
    group by u.id
    order by count(*) desc;
______________________________________________
create table users_width_follower as
select u.id, u.name , count(*) as follower, rank()over(order by count(*) desc) as ranking
    from users u
    left outer join relation r
    on u.id=r.follow_id
    group by u.id;


select count(*) + 1 as ranking
  from users_width_follower
  where follower > 2
  order by follower desc;
__________________________________________________

select 
  count(*) + 1 as ranking
from 
  (select u.id, u.name , count(*) as follower
    from users u
    left outer join relation r
    on u.id=r.follow_id
    group by u.id) as t
where t.follower > 2
order by t.follower desc;
___________________________________________

select u.*, count(*) as count,rank()over(order by count(*) desc) as ranking
    from users u
    left outer join relation r
    on u.id=r.follow_id
    group by u.id
    order by count(*) desc;

select 
  t.id, t.name, t.count, t.ranking
from
  (select u.*, count(*) as count,rank()over(order by count(*) desc) as ranking
    from users u
    left outer join relation r
    on u.id=r.follow_id
    group by u.id
    order by count(*) desc) as t
_____________________________________________________________


select u.*, count(*), rank()over(order by count(*) desc) as ranking
      from users u
      left outer join relation r
      on u.id=r.follow_id
      group by u.id

//count(follow_id)にすることでgroup byからのcount でNULLが一として数えられるのを防ぐ
select u.id, u.name, count(follow_id) as count
from users u
left join relation r
on u.id=r.follow_id
group by u.id
<<<<<<< HEAD

__________________________________________

SELECT c.id, c.name, c.count, c.picture, FIND_IN_SET(
  c.count, (
    SELECT GROUP_CONCAT(
      c.count ORDER BY c.count DESC
    )
    FROM (select u.id, u.name, u.picture, count(follow_id) as count
from users u
left join relation r
on u.id=r.follow_id
group by u.id) as c
  )
) AS rank
FROM (select u.id, u.name, u.picture, count(follow_id) as count
from users u
left join relation r
on u.id=r.follow_id
group by u.id) as c
order by count desc;

---------------------------------------

INSERT INTO posts SET user_id='2', message='hello', image='', reply_message_id='', created=now(), modified=now()
あ
