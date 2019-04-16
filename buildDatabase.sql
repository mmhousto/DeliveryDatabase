create database test;
use test;
/* tables  */

CREATE TABLE company
(
  CID int not null auto_increment unique primary key,
  OID int not null,
  serviceFee int,
  tip int,
  name varchar(10),
  foreign key (OID) references orders(id) on delete cascade on update cascade
);

CREATE TABLE restaurants
(
  RID int not null auto_increment primary key,
  OID int not null,
  IID int not null,
  name varchar(30),
  address varchar(30),
  city varchar(20),
  state char(2),
  zipcode char(5),
  deliverFee int,
  estTime time,
  foreign key (OID) references orders(id) on delete cascade on update cascade,
  foreign key (IID) references items(IID) on delete cascade on update cascade
);

CREATE TABLE items
(
  IID int not null auto_increment unique primary key,
  OID int not null,
  quantity int,
  description varchar(300),
  price decimal(4,2), -- decimal format covers 0.00 to 99.99
  foreign key (OID) references orders(id) on delete cascade on update cascade
);

CREATE TABLE orders
(
id int not null auto_increment unique primary key,
  RID int not null,
  IID int not null,
  CID int not null,
  address varchar(30),
  city varchar(20),
  state char(2),
  zipcode char(5),
  totalPrice decimal(5, 2), -- incase someone orders over $99 worth of food
  foreign key (CID) references company(CID) on delete cascade on update cascade,
  foreign key (RID) references restaurants(RID) on delete cascade on update cascade,
  foreign key (IID) references items(IID) on delete cascade on update cascade
);

/* Insertion for testing */
insert into restaurants( name, phone, address, city, state, zipcode, email)
  values
(
   "Andy's Tacos",
   '9188943647',
   '222 S. Mission',
   'Sapulpa',
   'OK',
   '74066',
   'tacoguy@gmail.com'
 ),
 (
 "Subway",
 '9182214441',
 '611 S. Main St',
 'Sapulpa',
 'OK',
 '74066',
 'SubsaretheWay@subway.com'
),
(
 "Arby's",
 '9182249595',
 '1025 E Dewey Ave',
 'Sapulpa',
 'OK',
 '74066',
 'wegotthemeats@arbys.com'
)
;

insert into items(name, description, price, restaurantID)
  values
  (
      'Carne Asada tacos',
      'Authentic Carne Asada street tacos, cheese, onion and cilantro served with lime and shredded cabbage',
      1.26,
      1
  ),
  (
    'Carne Pollo tacos',
    'Authentic chicken street tacos, cheese, onion and cilantro served with lime and shredded cabbage',
    1.26,
    1
  ),
  (
    'Fajitas Plater',
    'Your choice or Carne Asada or Pollo fajitas, served with rice, beans, lettuce, sour cream, and pico de gallo',
    11.99,
    1
  ),
  (
    'Carne Asada Burrito',
    'Carne Asada, beans, cheese, onion and cilantro, pico de gallo',
    5.89,
    1
  ),
  (
    'Enchilada Platter',
    '3 Enchiladas, Your choice of Beef, Chicken, or Cheese, covered in Enchilada sauce, served with rice and beens',
    7.89,
    1
  ),
  (
    'Black Forest Ham',
    "Black Forest Ham sandwich is classic. Just add your own flavor. Oh, and it's one of eight six-inch Fresh Fit™ subs with two servings of crisp veggies on freshly baked bread for under 400 calories.",
    5.80,
    2
  ),
  (
    'Cold Cut Combo',
    "The Cold Cut Combo sandwich with ham, salami, and bologna (all turkey based) is a long-time Subway® favorite. Yeah. It's that good.",
    5.80,
    2
  ),
  (
    'Italian B.M.T.',
    "The Italian B.M.T.® sandwich is filled with Genoa salami, spicy pepperoni, and Black Forest Ham. Big. Meaty. Tasty. Get it.",
    7.19,
    2
  ),
  (
    'Meatball Marinara',
    "The Meatball Marinara sandwich is drenched in irresistible marinara sauce, sprinkled with Parmesan cheese, topped with whatever you want (no judgement) and perfectly toasted just for you.",
    6.59,
    2
  ),
  (
    'Ruben',
    "Marbled rye bread filled with freshly sliced corned beef, melty Swiss Cheese, tangy sauerkraut and creamy Thousand Island dressing. This is a reuben sandwich inspired by the New York standard.",
    5.48,
    3
  ),
  (
    'Smokehouse Brisket',
    "We set out to make a sandwich with layers of smoky flavor, and this is the result. Our brisket is smoked for at least 13 hours in a pit smoker. We top that delicious smoked beef with smoked gouda, crispy onions, mayo and BBQ sauce and serve it all on an artisan-style roll.",
    3.89,
    3
  ),
  (
    'Roast Beef',
    "This is the sandwich that put roast beef on the map. Our classic roast beef is thinly sliced and piled on a toasted sesame seed bun. Try it with our delicious Arby's Sauce®, or for an extra kick go with the zesty Horsey Sauce®.",
    2.89,
    3
  ),
  (
    "Beef'n'Cheddar",
    "People said there was no way Arby's beef n cheddar sandwich could get even better. We took our famous roast beef, topped it with Cheddar cheese sauce and zesty Red Ranch and served it on a toasted onion roll.",
    3.26,
    3
  ),
  (
    "French Dip & Swiss",
    "Roast beef. Swiss Italian roll. French au jus sauce. It's half the countries in the world on one sandwich",
    4.86,
    3
  ),
  (
    "French Dip & Swiss",
    "Roast beef. Swiss Italian roll. French au jus sauce. It's half the countries in the world on one sandwich",
    4.86,
    3
  )
  ;

