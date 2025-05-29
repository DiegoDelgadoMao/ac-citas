-- Tabla de roles
CREATE TABLE roles (
  id_rol INT AUTO_INCREMENT PRIMARY KEY,
  nombre_rol VARCHAR(50) NOT NULL
);


-- Datos iniciales
INSERT INTO roles (nombre_rol) VALUES
  ('ADMIN'),
  ('TECNICO'),
  ('CLIENTE');

-- Tabla de usuarios
CREATE TABLE usuarios (
  id_usuario INT AUTO_INCREMENT PRIMARY KEY,
  nombre_completo VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  telefono VARCHAR(20),
  password VARCHAR(255),
  id_rol INT NOT NULL,
  FOREIGN KEY (id_rol) REFERENCES roles(id_rol)
);

-- Tabla de servicios
CREATE TABLE servicios (
  id_servicio INT AUTO_INCREMENT PRIMARY KEY,
  tipo_servicio ENUM('MANT_PREV','MANT_CORR','INST') NOT NULL,
  descripcion TEXT
);

-- Datos iniciales de servicios
INSERT INTO servicios (id_servicio, tipo_servicio, descripcion) VALUES
  (1, 'MANT_PREV',  'Aseo general, limpieza de filtros, verificación de niveles de refrigerante y parámetros eléctricos.'),
  (2, 'MANT_CORR',  'Diagnóstico y reparación de fallas, reemplazo de componentes defectuosos, pruebas de funcionamiento.'),
  (3, 'INST',              'Montaje completo del equipo de aire acondicionado, puesta en marcha y verificación de rendimiento.');

-- Tabla de técnicos
CREATE TABLE tecnicos (
  id_tecnico INT AUTO_INCREMENT PRIMARY KEY,
  id_usuario INT NOT NULL UNIQUE,
  especialidad VARCHAR(100),
  FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

-- Tabla de citas
CREATE TABLE citas (
  id_cita INT AUTO_INCREMENT PRIMARY KEY,
  id_cliente INT NOT NULL,
  id_tecnico INT NOT NULL,
  id_servicio INT NOT NULL,
  fecha DATE NOT NULL,
  hora TIME NOT NULL,
  estado ENUM('Programada','Realizada','Cancelada') DEFAULT 'Programada',
  FOREIGN KEY (id_cliente) REFERENCES usuarios(id_usuario),
  FOREIGN KEY (id_tecnico) REFERENCES tecnicos(id_tecnico),
  FOREIGN KEY (id_servicio) REFERENCES servicios(id_servicio)
);

-- Tabla de notificaciones
CREATE TABLE notificaciones (
  id_notificacion INT AUTO_INCREMENT PRIMARY KEY,
  id_usuario INT NOT NULL,
  id_cita INT NOT NULL,
  canal ENUM('Email','WhatsApp') NOT NULL,
  mensaje TEXT NOT NULL,
  fecha_envio DATETIME NOT NULL,
  FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
  FOREIGN KEY (id_cita) REFERENCES citas(id_cita)
);
