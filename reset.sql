drop table dependent;
drop table assign_role;
drop table assign_staff;
drop table role;
drop table staff;
drop table reservation;
drop table assign_activities;
drop table child;
drop table activities;
drop table assign_lodging;
drop table lodging;
drop table charge;
drop table guests;
drop table booking;
drop table billables;



create table guests(
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       fname VARCHAR(20) NOT NULL,
                       lname VARCHAR(20) NOT NULL,
                       dob DATE,
                       phone VARCHAR(18),
                       email VARCHAR(40),
                       age INT,
                       street VARCHAR(30),
                       city VARCHAR(20),
                       state VARCHAR(20),
                       country VARCHAR(20),
                       postal VARCHAR(10)
);

create table child(
                      id INT,
                      name VARCHAR(20),
                      dob DATE,
                      age INT,
                      sex CHAR(1),
                      FOREIGN KEY (id) REFERENCES guests(id),
                      PRIMARY KEY (id, name)
);

create table activities(
                           name VARCHAR(30) PRIMARY KEY,
                           price DECIMAL(6, 2),
                           location VARCHAR(20)
);


create table assign_activities(
                                  id INT,
                                  name VARCHAR(30),
                                  scheduled DATETIME NOT NULL,
                                  status VARCHAR(10),
                                  PRIMARY KEY (id, name, scheduled),
                                  FOREIGN KEY (id) REFERENCES guests (id),
                                  FOREIGN KEY (name) REFERENCES activities (name)
);

create table booking(
                        id INT PRIMARY KEY AUTO_INCREMENT,
                        arrive DATE NOT NULL,
                        depart DATE NOT NULL,
                        special VARCHAR(60),
                        type VARCHAR(30),
                        event VARCHAR(30),
                        referral VARCHAR(30)
);



create table reservation(
                            guest_id INT,
                            booking_id INT,
                            occurred DATETIME NOT NULL,
                            status VARCHAR(20) NOT NULL,
                            bank VARCHAR (20),
                            acct VARCHAR(20),
                            PRIMARY KEY (guest_id, booking_id),
                            FOREIGN KEY (guest_id) REFERENCES guests (id),
                            FOREIGN KEY (booking_id) REFERENCES booking (id)
);

create table lodging(
                        site_name VARCHAR(20),
                        number INT,
                        rate DECIMAL(6,2),
                        max_occupancy INT,
                        PRIMARY KEY (site_name, number)
);

create table assign_lodging(
                               booking_id INT,
                               guest_id INT,
                               site_name VARCHAR(20),
                               lodging_number INT,
                               PRIMARY KEY (booking_id, guest_id, site_name, lodging_number),
                               FOREIGN KEY (booking_id) REFERENCES booking (id),
                               FOREIGN KEY (guest_id) REFERENCES guests (id),
                               FOREIGN KEY (site_name, lodging_number) REFERENCES lodging (site_name, number)
);

create table billables(
                          id INT AUTO_INCREMENT PRIMARY KEY,
                          description VARCHAR(30),
                          location VARCHAR(20),
                          amount DECIMAL(6,2)
);

create table charge(
                       booking_id INT,
                       billable_id INT,
                       occurred DATETIME NOT NULL,
                       PRIMARY KEY (booking_id, billable_id, occurred),
                       FOREIGN KEY (booking_id) REFERENCES booking (id),
                       FOREIGN KEY (billable_id) REFERENCES billables (id)
);


create table staff(
                      id INT AUTO_INCREMENT PRIMARY KEY,
                      fname VARCHAR(20) NOT NULL,
                      lname VARCHAR(20) NOT NULL,
                      dept VARCHAR(10),
                      phone VARCHAR(10),
                      email VARCHAR(40),
                      street VARCHAR(30),
                      city VARCHAR(20),
                      state VARCHAR(20),
                      zip VARCHAR(10)
);

create table role(
                     name VARCHAR(20) PRIMARY KEY,
                     location VARCHAR(20)
);

create table assign_staff(
                             staff_id INT,
                             booking_id INT,
                             feedback VARCHAR(120),
                             PRIMARY KEY (staff_id, booking_id),
                             FOREIGN KEY (staff_id) REFERENCES staff (id),
                             FOREIGN KEY (booking_id) REFERENCES booking (id)
);




create table assign_role(
                            role_name VARCHAR(20),
                            staff_id INT,
                            start DATE NOT NULL,
                            end DATE,
                            PRIMARY KEY (role_name, staff_id),
                            FOREIGN KEY (role_name) REFERENCES role (name),
                            FOREIGN KEY (staff_id) REFERENCES staff (id)
);


create table dependent(
                          staff_id INT,
                          name VARCHAR(20),
                          sex CHAR(1),
                          dob DATE,
                          age INT,
                          relation VARCHAR(10),
                          PRIMARY KEY (staff_id, name),
                          FOREIGN KEY (staff_id) REFERENCES staff (id)
);


insert into activities (name, price, location) values
('Whitewater Rafting', 700.00, 'Blackfoot River'),
('Trap Shooting', 450.00, 'East Range'), 
('Archery', 300.00, 'Archery Range'),
('Horseback Riding', 500.00, 'Ovando'),
('Horseback Riding Overnight', 1500.00, 'Bob Marshall'), 
('ATV Track', 400.00, 'ATV Track'), 
('ATV Backcountry Tour', 2000.00, 'Ovando'), 
('Cross Country Skiing', 200.00, 'Blast Park'), 
('Snow Tubing', 200.00, 'Blast Park'), 
('Canoeing', 300.00, 'Seely Lake'), 
('Dog Sledding', 1200, 'Ovando'), 
('Fitness Center', 30.00, 'Fitness Center'), 
('Fly Fishing', 400.00, 'Blackfoot River'), 
('Garnet Ghost Town Tour', 500.00, 'Garnet Ghost Town'), 
('Hot Air Balooning', 7000.00, 'Launch Pad One');

insert into billables (description, location, amount) values 
('Continental Breakfast', 'Colonels Cafe', 70.99), 
('Lunch Buffet Classic', 'Colonels Cafe', 90.99), 
('Lunch Buffet Asian', 'Colonels Cafe', 99.99), 
('Lunch Buffet Octoberfest', 'Colonels Cafe', 120.99), 
('Lunch Buffet Indian', 'Colonels Cafe', 80.99), 
('Pizza Limit 5 Toppings', 'Colonels Cafe', 30.99), 
('Pizza Unlimited', 'Colonels Cafe', 40.99), 
('Steak Sirloin', 'Colonels Cafe', 50.99), 
('Steak Ribeye', 'Colonels Cafe', 60.99),
('Beer Tier 1', 'Colonels Cafe', 10.99), 
('Beer Tier 2', 'Colonels Cafe', 15.99), 
('Wine Tier 1', 'Colonels Cafe', 20.00), 
('Wine Tier 2', 'Colonels Cafe', 30.00), 
('Wine Tier 3', 'Colonels Cafe', 40.00);

insert into role (name, location) values 
('Guest Reception', 'Main Entrance'), 
('Transportation', 'Garage'), 
('Security', 'Main Entrance'), 
('Fleet Mechanic', 'Garage'), 
('Housekeeping', 'Guest Services'), 
('Yoga Instructor', 'Fitness Center'), 
('Glamping Butler', 'Guest Services'), 
('Raft Guide', 'Activities'), 
('Firearms Instructor', 'Activities'), 
('Archery Instructor', 'Activities'), 
('Watercraft Guide', 'Activities'), 
('Winter Guide', 'Activities'), 
('Plumber', 'Guest Services'), 
('Chef', 'Dining'), 
('Concierge', 'Guest Services');

insert into lodging (site_name, number, rate, max_occupancy) values 
('Lewis', 101, 1200.00, 4), 
('Lewis', 102, 1200.00, 4), 
('Lewis', 103, 1400.00, 4), 
('Lewis', 104, 1400.00, 4), 
('Clark', 101, 900.00, 6), 
('Clark', 102, 1150.00, 6), 
('Clark', 103, 1300.00, 8), 
('Clark', 104, 1250.00, 8), 
('Clark', 201, 1100.00, 6), 
('Clark', 202, 1250.00, 6), 
('Clark', 203, 1350.00, 8), 
('Clark', 204, 1400.00, 8),
('Island Lodge', 000, 9999.00, 21), 
('Glamping', 1, 3000.00, 9), 
('Glamping', 2, 4000.00, 9), 
('Glamping', 3, 5000.00, 6);

insert into staff (fname, lname, dept, phone, street, city, state, zip) values 
('Harry', 'Truman', 'Security', '4067230911', '1424 W 259th St.', 'Tukwila', 'WA', '98188-3716'), 
('Donna', 'Hayward', 'Reception', '4067291484', '288 W 6th St.', 'Missoula', 'MT', '59802-1232'), 
('Richard', 'Horne', 'Transport', '4067345439', '211 Mansion Heights Drive', 'Missoula', 'MT', '59808-0133'), 
('Josie', 'Packard', 'Concierge', '3102345984', '1319 Imposter Lane', 'Potomac', 'MT', '59814'), 
('Norma', 'Jennings', 'Chef', '6514876566', '1776 Sunset Loop', 'Polson', 'MT', '59834'), 
('Jaques', 'Renault', 'Plumber', '3178345767', '6458 Rollercoaster Road', 'Frenchtown', 'MT', '59819'), 
('Bobby', 'Briggs', 'Raft Guide', '4067398799', '911 SW Higgins Avenue', 'Missoula', 'MT', '59801'), 
('Leo', 'Johnson', 'Archery', '8704523434', '710 South Avenue', 'Missoula', 'MT', '59801'),
('Lawrence', 'Jacoby', 'Winter', '4065456777', '3452 Bass Road', 'Nisswa', 'MN', '56474'), 
('Shelly', 'Johnson', 'Yoga', '6512398704', '2911 Snelling Avenue', 'Saint Paul', 'MN', '55119');

insert into dependent (staff_id, name, sex, dob, age, relation) values 
(3, 'Jerry Jr.', 'M', 20110113, null, 'child'), 
(5, 'Becky', 'F', 20180908, null, 'child'), 
(10, 'Burt', 'M', 20090203, null, 'child'), 
(6, 'Pierre', 'M', 20140919, null, 'child'), 
(9, 'April', 'F', 20120402, null, 'child');

insert into guests (fname, lname, dob, phone, email, age, street, city, state, country, postal) values
('Gordon', 'Cole', 19540809, '2103049879', 'gcole@fbi.gov', null, '935 Pennsylvania Avenue', 'Washington', 'D.C.','USA', '20535-0001'), 
('Chester', 'Desmond', 19720811, '2023243000', 'ddesmond@fbi.gov', null, '935 Pennsylvannia Avenue', 'Washington', 'D.C.', 'USA', '20535-0001'), 
('Phillip', 'Jeffries', 19580711, '2023458789', 'pjeffries@fbi.gov', null, 'Avenida Colombia 4300', 'C1425 Buenos Aires', 'Buenos Aires', 'Argentina', null), 
('Albert', 'Rosenfield', 19650211, '3109293451', 'arosenfield@fbi.gov', null, ' 11000 Wilshire Blvd,', 'Los Angeles', 'CA', 'USA', '90024'), 
('Tamara', 'Preston',19940519, '2023198988', 'tpreston@fbi.gov', null, '935 Pennsylvannia Avenue', 'Washington', 'D.C.', 'USA', '20535-0001'),
('Abraham', 'Atkins', 19990221, '7196453232', null, null, '1424 Airway Blvd.', 'Fort Collins', 'CO', 'USA', '34512'), 
('Alice', 'Anderson', 20000718, '7183456767', 'a_anderson@hotmail.com', null, '1230 S 5th St. W', 'MIssoula', 'MT', 'USA', '59801'), 
('Hans', 'Heinzleman', 19540921, '4103498787', null, null, '3900 Willow Ave.', 'Long Beach', 'CA', 'USA', '90805'), 
('Jimmy', 'Johnson', 19800118, '4064591772', 'johnsons_4ever@yahoo.com', null, '8700 HWY 93', 'Kalispell', 'MT', 'USA', '58719'), 
('Patty', 'Johnson', 19600415, null, null, null, '8700 HWY 93', 'Kalispell', 'MT', 'USA', '58719'),
('Elon', 'Musk', 19710628, null, 'elonmusk@tesla.com', null, null, null, null, null, null);


insert into booking (arrive, depart, special, type, event, referral) values 
(20210613, 20210715, 'Government', 'Retreat', null, 'Garland Briggs'), 
(20210401, 20210415, null, 'Wedding', null, null), 
(20211004, 20211009, null, 'Festival', 'Octoberfest', null), 
(20221228, 20230103, 'Peanut Allergy', 'Family', null, null), 
(20210813, 20210911, 'VIP', 'Concert', null, 'Elton John');

insert into child (id, name, dob, age, sex) values
(1, 'Ike', 20110911, null, 'M'),
(1, 'Peter', 20090414, null, 'M'),
(1, 'Mary', 20130813, null, 'F'),
(5, 'DJ', 20181111, null, 'M'),
(5, 'Todd', 20181111, null, 'M');


insert into assign_activities (id, name, scheduled, status) values 
(1, 'Archery', '2021-06-14 14:30:00', 'scheduled'),
(1, 'Canoeing', '2021-06-15 10:00:00', 'scheduled'),
(1, 'Garnet Ghost Town Tour', '2021-06-16 10:00:00', 'scheduled'),
(2, 'ATV Track', '2021-06-14 10:00:00', 'scheduled'),
(2, 'Horseback Riding', '2021-06-15 14:00:00', 'scheduled'),
(3, 'Horseback Riding', '2021-06-15 14:00:00', 'scheduled'),
(4, 'Horseback Riding', '2021-06-15 14:00:00', 'scheduled'),
(5, 'Horseback Riding', '2021-06-15 14:00:00', 'scheduled'),
(4, 'Trap Shooting', '2021-06-16 10:00:00', 'scheduled'),
(5, 'Horseback Riding Overnight', '2021-06-17 09:00:00', 'scheduled');


insert into reservation (guest_id, booking_id, occurred, status, bank, acct) values
(1, 1, '2021-02-14 09:34:22', 'scheduled', 'Chase', '8569652125'),
(2, 1, '2021-02-14 09:34:22', 'scheduled', 'Chase', '854145521'),
(3, 1, '2021-02-14 09:34:22', 'scheduled', 'Chase', '5852586596'),
(4, 1, '2021-02-14 09:34:22', 'scheduled', 'Chase', '85452158963'),
(5, 1, '2010-02-14 09:34:22', 'scheduled', 'Chase', '58541254478'),
(6, 2, '2021-02-12 17:39:12', 'scheduled', 'First Security', '0712343423'),
(7, 2,'2020-12-12 17:39:12', 'scheduled', 'First Security', '0712343423'),
(8, 3, '2020-08-19 12:33:09', 'scheduled', 'Deutsch Bank', '999081564-21'),
(9, 4, '2021-01-01 08:30:12', 'scheduled', 'First Farmers', '444302100'),
(10, 4, '2021-01-01 08:30:12', 'scheduled', 'First Farmers', '444302100'),
(11, 5, '2017-10-12 23:11:23', 'scheduled', 'Wells Fargo', '5896545215');


insert into assign_lodging (booking_id, guest_id, site_name, lodging_number) values 
(1, 1, 'Clark', 101),
(1, 2, 'Clark', 102),
(1, 3, 'Clark', 103),
(1, 4, 'Clark', 104),
(1, 5, 'Clark', 201),
(2, 6, 'Glamping', 1),
(2, 7, 'Glamping', 1),
(3, 8, 'Glamping', 2),
(4, 9, 'Lewis', 101),
(4, 10, 'Lewis', 101),
(5, 11, 'Island Lodge', 0);


insert into assign_role (role_name, staff_id, start, end) values 
('Archery Instructor', 8, 19800101, null), 
('Chef', 5, 19890304, null), 
('Concierge', 4, 19920818, null), 
('Guest Reception', 2, 19940621, null), 
('Security', 1, 19700101, null), 
('Transportation', 3, 20100701, null), 
('Plumber', 6, 19810901, null), 
('Raft Guide', 7, 20000528, null), 
('Winter Guide', 9, 19540101, null), 
('Yoga Instructor', 10, 20070812, null);



insert into assign_staff (staff_id, booking_id, feedback) values 
(1, 1, 'Slight body odor but he spends most his time outdoors'),
(3, 1, 'A little too friendly'),
(3, 2, 'Kept asking us where we were from'),
(3, 3, 'Very fast driver, I thought I would be sick'),
(3, 4, 'Needs to trim fingernails'),
(3, 5, 'Something not quite right about this guy'),
(1, 5, 'Not very talkative'),
(4, 1, 'She seems familiar for some reason'),
(4, 2, 'Wears a lot of makeup'),
(4, 3, 'Great customer service'),
(4, 4, 'A delight to be around'),
(4, 5, 'Very warm personality'),
(7, 1, 'Seems to anger easily'),
(8, 1, 'Has a lot of insight into the human condition');


insert into charge (booking_id, billable_id, occurred) values 
(1, 1, '2021-07-11 08:17:33'), 
(1, 2, '2021-07-11 12:34:11'), 
(1, 11, '2021-07-11 12:34:11'),
(1, 1, '2021-07-12 08:17:33'), 
(1, 2, '2021-07-12 12:34:11'), 
(1, 14, '2021-07-12 12:34:11'),
(1, 1, '2021-07-13 08:17:33'), 
(1, 2, '2021-07-13 12:34:11'), 
(1, 11, '2021-07-13 12:34:11'),
(1, 1, '2021-07-14 08:17:33'), 
(1, 2, '2021-07-14 12:34:11'), 
(1, 14, '2021-07-14 12:34:11'),
(1, 1, '2021-07-15 08:17:33'), 
(1, 2, '2021-07-15 12:34:11'), 
(1, 11, '2021-07-15 12:34:11');
















