-- this table stores guest information
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

-- this table stores information about guest children
create table child(
	id INT,
	name VARCHAR(20), 
	dob DATE, 
	age INT, 
	sex CHAR(1), 
	FOREIGN KEY (id) REFERENCES guests(id),
	PRIMARY KEY (id, name)
);

-- this table contains all of the activities that guests can participate in while at the resort
create table activities(
	name VARCHAR(30) PRIMARY KEY,
	price DECIMAL(6, 2), 
	location VARCHAR(20)
);

-- this table keeps a record of which guests are scheduled for which activities
create table assign_activities(
	id INT, 
	name VARCHAR(30), 
	scheduled DATETIME NOT NULL,
	status VARCHAR(10),
	PRIMARY KEY (id, name, scheduled),
	FOREIGN KEY (id) REFERENCES guests (id),
	FOREIGN KEY (name) REFERENCES activities (name)
);

-- this table stores information regarding a specific booking
-- the information in this table is not considered  sensitive
create table booking( 
	id INT PRIMARY KEY AUTO_INCREMENT, 
	arrive DATE NOT NULL, 
	depart DATE NOT NULL, 
	special VARCHAR(60), 
	type VARCHAR(30), 
	event VARCHAR(30),
	referral VARCHAR(30)
); 

-- this table stores information regarding a reservation
-- the information in this table is considered sensitive
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

-- this table contains all of the lodging options at the resort
create table lodging(
	site_name VARCHAR(20), 
	number INT, 
	rate DECIMAL(6,2),
	max_occupancy INT, 
	PRIMARY KEY (site_name, number)
);

-- this table tracks lodging assignments for each guest
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

-- this table stores all items which may be billed to a booking
create table billables(
	id INT AUTO_INCREMENT PRIMARY KEY,  
	description VARCHAR(30), 
	location VARCHAR(20), 
	amount DECIMAL(6,2)
);

-- this table keeps a record of what items have been charged to a booking
create table charge(
	booking_id INT, 
	billable_id INT, 
	occurred DATETIME NOT NULL, 
	PRIMARY KEY (booking_id, billable_id, occurred),
	FOREIGN KEY (booking_id) REFERENCES booking (id),
	FOREIGN KEY (billable_id) REFERENCES billables (id)
);

-- this table contains information about all resort employees
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

-- this table lists all potential roles an employee may be assigned
create table role(
	name VARCHAR(20) PRIMARY KEY, 
	location VARCHAR(20)
);

-- this table records which guests each employee is assigned to
create table assign_staff(
	staff_id INT, 
	booking_id INT, 
	feedback VARCHAR(120),
	PRIMARY KEY (staff_id, booking_id),
	FOREIGN KEY (staff_id) REFERENCES staff (id),
	FOREIGN KEY (booking_id) REFERENCES booking (id)
);

-- this table keeps a record of what role each employee is assigned
create table assign_role(
	role_name VARCHAR(20), 
	staff_id INT, 
	start DATE NOT NULL, 
	end DATE,
	PRIMARY KEY (role_name, staff_id), 
	FOREIGN KEY (role_name) REFERENCES role (name), 
	FOREIGN KEY (staff_id) REFERENCES staff (id)
);

-- this tale records information regarding the dependents of each employee
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
