<?php
// abre conex�o com Postgres
$conn = pg_connect("host=localhost port=5432 dbname=livro user=postgres password=");

// insere v�rios registros
pg_query($conn, "INSERT INTO famosos (codigo, nome) VALUES (1, '�rico Ver�ssimo')");
pg_query($conn, "INSERT INTO famosos (codigo, nome) VALUES (2, 'John Lennon')");
pg_query($conn, "INSERT INTO famosos (codigo, nome) VALUES (3, 'Mahatma Gandhi')");
pg_query($conn, "INSERT INTO famosos (codigo, nome) VALUES (4, 'Ayrton Senna')");
pg_query($conn, "INSERT INTO famosos (codigo, nome) VALUES (5, 'Charlie Chaplin')");
pg_query($conn, "INSERT INTO famosos (codigo, nome) VALUES (6, 'Anita Garibaldi')");
pg_query($conn, "INSERT INTO famosos (codigo, nome) VALUES (7, 'M�rio Quintana')");

// fecha a conex�o
pg_close($conn);
?>