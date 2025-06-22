CREATE DATABASE ventas;
USE ventas;

CREATE TABLE vendedores (
  codigo_v INT PRIMARY KEY,
  apellidos_v VARCHAR(50),
  nombres_v VARCHAR(50),
  identificacion_v VARCHAR(15),
  parroquia_domicilio_v VARCHAR(50),
  sexo_v VARCHAR(15),
  salario_v DECIMAL(6,2),
  edad_v INT
);

CREATE TABLE productos (
  codigo_p INT PRIMARY KEY,
  tipo_producto_p VARCHAR(50),
  descripcion_p VARCHAR(100),
  valor_unitario_p DECIMAL(6,2)
);

CREATE TABLE ventas (
  codigo_vt INT PRIMARY KEY,
  codigo_v INT,
  codigo_p INT,
  fecha DATE,
  cantidad INT,
  total DECIMAL(6,2),
  FOREIGN KEY (codigo_v) REFERENCES vendedores(codigo_v),
  FOREIGN KEY (codigo_p) REFERENCES productos(codigo_p)
);