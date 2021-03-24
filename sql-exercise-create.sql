/************************************************************************/
/*																		*/
/*	These are the Microsoft SQL Server 2012 SQL code solutions			*/
/*				›														*/
/************************************************************************/

CREATE TABLE OWNER(
	OwnerID			Int				NOT NULL AUTO_INCREMENT,
	OwnerName		VarChar(50)		NOT NULL,
	OwnerEmail		VarChar(100)	NULL,
	OwnerType		VarChar(12)		NULL,
	CONSTRAINT		OWNER_PK		PRIMARY KEY(OwnerID)
);

CREATE TABLE PROPERTY(
	PropertyID		Int				NOT NULL AUTO_INCREMENT,
	PropertyName	VarChar(50)		NOT NULL,
	Street			VarChar(35)		NOT NULL,
	City			VarChar(35)		NOT NULL,
	State			VarChar(2)			NOT NULL,
	ZIP				VarChar(10)		NOT NULL,
	OwnerID			Int				NOT NULL,
	CONSTRAINT		PROPERTY_PK	PRIMARY KEY(PropertyID),
	CONSTRAINT		PROP_OWNER_FK	FOREIGN KEY (OwnerID)
							REFERENCES OWNER(OwnerID)
									ON DELETE NO ACTION
);

CREATE TABLE GG_EMPLOYEE(
	EmployeeID		Int				NOT NULL AUTO_INCREMENT,
	LastName		VarChar(25)		NOT NULL,
	FirstName		VarChar(25)		NOT NULL,
	CellPhone		VarChar(12)		NOT NULL,
	ExperienceLevel	VarChar(15)		NOT NULL,
	CONSTRAINT		EMPLOYEE_PK		PRIMARY KEY(EmployeeID)
);

CREATE TABLE SERVICE(
	PropertyID		Int				NOT NULL,
	EmployeeID		Int				NOT NULL,
	ServiceDate		DateTime		NOT NULL,
	HoursWorked		Numeric (4,2)	NULL,
	CONSTRAINT		SERVICE_PK
							PRIMARY KEY(PropertyID, EmployeeID, ServiceDate),
	CONSTRAINT		SERVICE_PROP_FK FOREIGN KEY (PropertyID)
							REFERENCES PROPERTY(PropertyID)
									ON DELETE NO ACTION,
	CONSTRAINT		SERVICE_EMP_FK FOREIGN KEY (EmployeeID)
							REFERENCES GG_EMPLOYEE(EmployeeID)
									ON DELETE NO ACTION
									ON UPDATE CASCADE
);

/********************************************************************************/
