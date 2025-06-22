CREATE DATABASE IF NOT EXISTS ventas;

-- Usa la base de datos
USE ventas;

-- Crea la tabla vendedores
CREATE TABLE IF NOT EXISTS vendedores (
  codigo_v INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  apellidos_m VARCHAR(50),
  nombres_v VARCHAR(50),
  identificacion_m VARCHAR(15),
  parroquia_domicilio_m VARCHAR(50),
  sexo_m VARCHAR(10),
  salario_m DECIMAL(10,2),
  edad_m INT
);

-- Crea la tabla productos
CREATE TABLE productos (
codigo_p INT PRIMARY KEY,
tipo_producto_p VARCHAR(30),
descripcion_p VARCHAR(100),
valor_unitario_p DECIMAL(10,2)
);

-- Crea la tabla t_ventas
CREATE TABLE t_ventas (
codigo_vt INT PRIMARY KEY,
codigo_v INT,
codigo_p INT,
fecha DATE,
cantidad INT,
total DECIMAL(10,2),
FOREIGN KEY (codigo_v) REFERENCES vendedores(codigo_v),
FOREIGN KEY (codigo_p) REFERENCES productos(codigo_p)
);

-- Insertar vendedores 
INSERT INTO vendedores (apellidos_m, nombres_v, identificacion_m, parroquia_domicilio_m, sexo_m, salario_m, edad_m)
VALUES 
('Grijalva', 'Santiago', '1758469524', 'Guamani', 'Masculino', 450.00, 35),
('Vera', 'Diana', '1758461234', 'La Magdalena', 'Femenino', 480.00, 28),
('Ríos', 'Carlos', '1751234567', 'Chillogallo', 'Masculino', 500.00, 42);
INSERT INTO vendedores (apellidos_m, nombres_v, identificacion_m, parroquia_domicilio_m, sexo_m, salario_m, edad_m) VALUES
('Rivas', 'David', '1234567891', 'Belisario Quevedo', 'Masculino', 470.00, 45),
('Cacuango', 'Santiago', '2345678912', 'Guangopolo', 'Masculino', 350.00, 35),
('Albán', 'Lorena', '3456789123', 'Belisario Quevedo', 'Femenino', 470.00, 20),
('Moreno', 'Karen', '1234566723', 'Cumbayá', 'Femenino', 300.00, 30),
('Alvares', 'Javier', '1712052345', 'Guangopolo', 'Masculino', 350.00, 38);
INSERT INTO Vendedores (apellidos_m, nombres_v, identificacion_m, parroquia_domicilio_m, sexo_m, salario_m, edad_m)VALUES
('Ortiz', 'Paulina', '1345678234', 'Cumbayá', 'Femenino', 300.00, 35),
('Andrade', 'Pedro', '1456789235', 'Tumbaco', 'Masculino', 500.00, 22),
('Tobar', 'Fátima', '2345678917', 'Nayón', 'Femenino', 470.00, 47),
('Obando', 'Belén', '1245678912', 'Cumbayá', 'Femenino', 350.00, 45),
('Romero', 'Héctor', '2341567895', 'Cotocollao', 'Masculino', 250.00, 37);
INSERT INTO vendedores (apellidos_m, nombres_v, identificacion_m, parroquia_domicilio_m, sexo_m, salario_m, edad_m)
VALUES 
('Mendoza', 'Andrea', '1758470001', 'Conocoto', 'Femenino', 520.00, 30),
('Paredes', 'Juan', '1758470002', 'Calderón', 'Masculino', 470.00, 29),
('Cárdenas', 'Luis', '1758470003', 'Carcelén', 'Masculino', 530.00, 40),
('Yépez', 'Marcela', '1758470004', 'La Ecuatoriana', 'Femenino', 510.00, 33),
('Navarrete', 'Esteban', '1758470005', 'El Quinche', 'Masculino', 490.00, 27);
INSERT INTO vendedores (apellidos_m, nombres_v, identificacion_m, parroquia_domicilio_m, sexo_m, salario_m, edad_m) 
VALUES
('Lema', 'Paola', '1723456789', 'Chillogallo', 'Femenino', 500, 29),
('Canchig', 'Luis', '1712345678', 'La Ecuatoriana', 'Masculino', 520, 42),
('Yumbo', 'Gabriela', '1767891234', 'Carcelén', 'Femenino', 480, 31),
('Quishpe', 'Daniel', '1734567890', 'Cotocollao', 'Masculino', 470, 28),
('Chiriboga', 'María', '1745678912', 'Conocoto', 'Femenino', 530, 33),
('Guamán', 'Diego', '1756789123', 'Calderón', 'Masculino', 490, 39),
('Titicota', 'Lucía', '1767892345', 'Solanda', 'Femenino', 460, 27),
('Chávez', 'Jorge', '1723987654', 'San Bartolo', 'Masculino', 510, 41),
('Cando', 'Elena', '1739876543', 'La Magdalena', 'Femenino', 475, 30);

-- Insertar Productos
INSERT INTO productos (codigo_p, tipo_producto_p, descripcion_p, valor_unitario_p) VALUES
(10, 'Papelería', 'Cuaderno universitario de cuadros de 100 hojas', 1.00),
(20, 'Ropa', 'Pantalón talla S', 30.00),
(30, 'Víveres', 'Aceite comestible de 1 litro', 5.60),
(40, 'Frutas', 'Manzanas', 0.25),
(50, 'Verduras', 'Pepinillo', 0.25),
(60, 'Papelería', 'Cuaderno universitario de línea de 100 hojas', 1.00);
insert into productos (codigo_p,tipo_producto_p, descripcion_p, valor_unitario_p) values
(70,'Papelería', 'Resma de hojas de papel bond', 4.50),
(80,'Ropa', 'Blusa deportiva talla M', 25.00),
(90,'Víveres', 'Quintas de arroz', 55.50),
(100,'Frutas', 'Sandía', 4.00),
(110,'Verduras', 'Rábanos', 0.50);
SELECT* from Productos;

-- Insertar ventas 
INSERT INTO t_ventas (codigo_vt, codigo_v, codigo_p, fecha, cantidad, total) VALUES
(1, 1, 10, '2025-06-05', 10, 10.00),
(2, 1, 60, '2025-06-05', 1, 1.00),
(3, 2, 20, '2025-06-06', 1, 30.00),
(4, 3, 30, '2025-06-06', 3, 16.80),
(5, 4, 40, '2025-06-07', 10, 2.50);

insert into t_ventas (codigo_vt, codigo_v, codigo_p, fecha, cantidad, total) values
(7, 6, 70, '2025-06-08', 5, 22.50),
(8, 6, 40, '2025-06-08', 4, 1.00),
(9, 7, 80, '2025-06-09', 4, 100.00),
(10, 8, 100, '2025-06-09', 3, 12.00),
(11, 9, 100, '2025-06-09', 1, 4.00),
(12, 10, 60, '2025-06-10', 5, 5.00),
(13, 6, 90, '2025-06-10', 2, 111.00),
(14, 4, 110, '2025-06-10', 4, 2.00),
(15, 2, 20, '2025-06-10', 6, 180.00);


