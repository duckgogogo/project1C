create table Movie(
	id int, 
	title varchar(100) NOT NULL, -- the title of a movie cannot be NULL
	year int, 
	rating varchar(10), 
	company varchar(50),
	PRIMARY KEY(id), -- every movie should have a unique id
	CHECK(id>=0)) -- id should larger than or equal to 0
ENGINE = InnoDB;

create table Actor(
	id int, 
	last varchar(20), 
	first varchar(20), 
	sex varchar(6), 
	dob date NOT NULL, -- the date of birth cannot be NULL
	dod date,
	PRIMARY KEY(id), -- every actor should have a unique id
	CHECK(dod = NULL OR TO_DAYS(dob)<TO_DAYS(dod))) -- date of death(if applicable) should be later than the date of birth
ENGINE = InnoDB;

create table Director(
	id int, 
	last varchar(20), 
	first varchar(20), 
	dob date NOT NULL, -- the date of birth cannot be NULL
	dod date,
	PRIMARY KEY(id), -- every director should have a unique id
	CHECK(dod = NULL OR TO_DAYS(dob)<TO_DAYS(dod))) -- date of death(if applicable) should be later than the date of birth
ENGINE = InnoDB;

create table MovieGenre(
	mid int, 
	genre varchar(20),
	FOREIGN KEY(mid) REFERENCES Movie(id) ON DELETE CASCADE ON UPDATE CASCADE) -- mid is referred to id in Movie, using CASCADE for delete and update
ENGINE = InnoDB;

create table MovieDirector(
	mid int, 
	did int,
	FOREIGN KEY(mid) REFERENCES Movie(id) ON DELETE CASCADE ON UPDATE CASCADE, -- mid is referred to id in Movie, using CASCADE for delete and update
	FOREIGN KEY(did) REFERENCES Director(id) ON DELETE CASCADE ON UPDATE CASCADE) -- did is referred to id in Director, using CASCADE for delete and update
ENGINE = InnoDB;

create table MovieActor(
	mid int, 
	aid int, 
	role varchar(50),
	FOREIGN KEY(mid) REFERENCES Movie(id) ON DELETE CASCADE ON UPDATE CASCADE, -- mid is referred to id in Movie, using CASCADE for delete and update
	FOREIGN KEY(aid) REFERENCES Actor(id) ON DELETE CASCADE ON UPDATE CASCADE) -- aid is referred to id in Actor, using CASCADE for delete and update
ENGINE = InnoDB;

create table Review(
	name varchar(20), 
	time timestamp, 
	mid int, 
	rating int, 
	comment varchar(500),
	FOREIGN KEY(mid) REFERENCES Movie(id) ON DELETE CASCADE ON UPDATE CASCADE) -- mid is referred to id in Movie, using CASCADE for delete and update
ENGINE = InnoDB;

create table MaxPersonID(
	id int)
ENGINE = InnoDB;

create table MaxMovieID(
	id int)
ENGINE = InnoDB;