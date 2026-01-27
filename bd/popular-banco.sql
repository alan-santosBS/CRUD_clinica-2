-- Inserts para popular o banco clinica

-- Médicos
INSERT INTO medico (nome, especialidade) VALUES ('Dr. João Silva', 'Cardiologia');
INSERT INTO medico (nome, especialidade) VALUES ('Dra. Maria Oliveira', 'Pediatria');
INSERT INTO medico (nome, especialidade) VALUES ('Dr. Pedro Santos', 'Ortopedia');

-- Pacientes
INSERT INTO paciente (nome, data_nascimento, tipo_sanguineo) VALUES ('Ana Paula', '1990-05-12', 'A+');
INSERT INTO paciente (nome, data_nascimento, tipo_sanguineo) VALUES ('Carlos Souza', '1985-11-23', 'O-');
INSERT INTO paciente (nome, data_nascimento, tipo_sanguineo) VALUES ('Fernanda Lima', '2000-07-30', 'B+');

-- Consultas
INSERT INTO consulta (id_medico, id_paciente, data_hora, observacoes) VALUES (1, 1, '2026-01-21 09:00:00', 'Rotina anual.');
INSERT INTO consulta (id_medico, id_paciente, data_hora, observacoes) VALUES (2, 2, '2026-01-22 10:30:00', 'Consulta pediátrica.');
INSERT INTO consulta (id_medico, id_paciente, data_hora, observacoes) VALUES (3, 3, '2026-01-23 14:00:00', 'Dor no joelho direito.');


INSERT INTO usuarios (usuario, senha) VALUES ('admin', MD5('123'));