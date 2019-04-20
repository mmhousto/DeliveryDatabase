create database test;
use test;
/* tables  */

CREATE TABLE orders
(
  id int not null auto_increment unique primary key,
  RID int not null,
  CID int not null,
  subTotal double not null,
  address varchar(255),
  foreign key (CID) references company(CID) on delete cascade on update cascade,
  foreign key (RID) references restaurants(RID) on delete cascade on update cascade
);

CREATE TABLE company
(
  CID int not null auto_increment unique primary key,
  OID int not null,
  price double not null,
  serviceFee double,
  tip decimal(3,2),
  name varchar(10),
  foreign key (OID) references orders(id) on delete cascade on update cascade,
  foreign key (price) references orders(subTotal) on delete cascade on update cascade
);

CREATE TABLE restaurants
(
  RID int not null auto_increment primary key,
  OID int not null,
  price double not null,
  name varchar(30),
  address varchar(255),
  deliverFee double,
  estTime time,
  foreign key (OID) references orders(id) on delete cascade on update cascade,
  foreign key (price) references orders(subTotal) on delete cascade on update cascade
);

/* Insertion for testing */
insert into restaurants( name, address)
  values
(
   "Andy's Tacos",
   '222 S. Mission, Sapulpa OK 74066'
 ),
 (
 "Subway",
 '611 S. Main St, Sapulpa OK 74066'
),
(
 "Arby's",
 '1025 E Dewey Ave, Sapulpa OK 74066'
)
;
