<?php

SHOW DATABASES;		//LISTAR TODAS LAS BASES DE DATOS
SHOW TABLES;		//MOSTRAR TODAS LAS TABLAS EN LA BASE DE DATOS SELECCIONADA

SHOW COLUMNS FROM customers;									//MOSTRAR TODAS LAS COLUMNAS DE LA TABLA customers
SELECT FirstName FROM customers;								//MOSTRAR LA COLUMNA FirstName DE LA TABLA customers
SELECT FirstName, LastName, City FROM customers;				//MOSTRAR LA COLUMNA FirstName, LastName, City DE LA TABLA customers
SELECT * FROM customers;										//MOSTRAR TODAS LAS COLUMNAS DE LA TABLA customers
SELECT DISTINCT City FROM customers; 							//MOSTRAR LA COLUMNA City DE LA TABLA customers eliminando duplicados de City
SELECT ID, FirstName, LastName, City FROM customers LIMIT 5;	//MOSTRAR LA COLUMNA ID, FirstName, LastName, City DE LA TABLA customers LIMITANDO A 5 FILAS
SELECT ID, FirstName, LastName, City FROM customers LIMIT 3, 4; //MOSTRAR LA COLUMNA ID, FirstName, LastName, City DE LA TABLA customers LIMITANDO A 4 FILAS A PARTIR DE LA 3º POSICION


SELECT City FROM customers;					//EQUIVALENTE
SELECT customers.City FROM customers;		//EQUIVALENTE


SELECT * FROM customers ORDER BY FirstName;						//MOSTRAR TODAS LAS COLUMNAS DE LA TABLA customers ORDENADAS ALF-NUM SEGUN LA COLUMNA FirstName
SELECT * FROM customers ORDER BY LastName, Age;					//MOSTRAR TODAS LAS COLUMNAS DE LA TABLA customers ORDENADAS ALF-NUM SEGUN LA COLUMNA LastName Y DENTRO DE ESE ORDEN POR Age

SELECT * FROM customers WHERE ID = 7;							//MOSTRAR TODAS LAS COLUMNAS DE LA TABLA customers DONDE ID = 7
SELECT * FROM customers WHERE ID != 5;							//MOSTRAR TODAS LAS COLUMNAS DE LA TABLA customers DONDE ID != 5
SELECT * FROM customers WHERE ID BETWEEN 3 AND 7;				//MOSTRAR TODAS LAS COLUMNAS DE LA TABLA customers DONDE 3 <= ID <= 7

SELECT id, name FROM students WHERE id BETWEEN 13 AND 45;		//MOSTRAR LOS NOMBRES DE LOS ESTUDIANTES CUYAS IDS ESTAN ENTRE 13 Y 14

SELECT ID, FirstName, LastName, City FROM customers WHERE City = 'New York';	//MOSTRAR LA COLUMNA ID, FirstName, LastName, City DE LA TABLA customers CUYA CIUDAD ES New York

SELECT ID, FirstName, LastName, Age FROM customers WHERE Age >= 30 AND Age <= 40;
SELECT * FROM customers WHERE City = 'New York' OR City = 'Chicago';
SELECT * FROM customers WHERE City = 'New York' AND (Age=30 OR Age=35);
SELECT * FROM customers WHERE City = 'New York' OR City = 'Los Angeles' OR City = 'Chicago';

SELECT * FROM customers WHERE City IN ('New York', 'Los Angeles', 'Chicago');	//ES COMO VARIOS OR
SELECT * FROM customers WHERE City NOT IN ('New York', 'Los Angeles', 'Chicago');

SELECT CONCAT(FirstName, ', ' , City) FROM customers;					//CONCATENA 2 COLUMNAS
SELECT CONCAT(FirstName,', ', City) AS new_column FROM customers;		//AS CREA UNA NUEVA COLUMNA
SELECT ID, FirstName, LastName, Salary+500 AS Salary FROM employees;	//AÑADE 500 A CADA EMPLEADO EN LA COLUMNA Salary

SELECT FirstName, UPPER(LastName) AS LastName FROM employees;			//UPPER CONVIERTE EN MAYUSCULAS EL RESULTADO, LOWER AL REVES
SELECT FirstName, LOWER(LastName) AS LastName FROM employees;			//UPPER CONVIERTE EN MAYUSCULAS EL RESULTADO, LOWER AL REVES

SELECT Salary, SQRT(Salary) FROM employees;								//SQRT DEVUELVE LA RAIZ CREANDO UNA NUEVA COLUMNA SQRT(Salary) ADEMAS DE Salary
SELECT AVG(Salary) FROM employees;										//AVG DEVUELVE LA MEDIA DE TODO CREANDO UNA NUEVA COLUMNA AVG(Salary)
SELECT SUM(Salary) FROM employees;										//DEVUELVE LA SUMA DE TODO CREANDO UNA NUEVA COLUMNA SUM(Salary)

SELECT FirstName, Salary FROM employees WHERE  Salary > 3100 ORDER BY Salary DESC;		//DESC ORDENA DESCENDENTEMENTE Y ASC ASCENDENTEMENTE
SELECT FirstName, Salary FROM employees WHERE  Salary > 3100 ORDER BY Salary ASC;		//DESC ORDENA DESCENDENTEMENTE Y ASC ASCENDENTEMENTE

SELECT FirstName, Salary FROM employees WHERE  Salary > (SELECT AVG(Salary) FROM employees) ORDER BY Salary DESC;

SELECT * FROM employees WHERE FirstName LIKE 'A%';				//LOS QUE EMPIEZAN POR A
SELECT * FROM employees WHERE LastName LIKE '%s';				//LOS QUE TERMINAN EN S

SELECT MIN(Salary) AS Salary FROM employees;					//SELECCIONA EL SALARIO MINIMO





?>