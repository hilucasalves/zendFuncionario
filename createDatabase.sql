create database devmedia_site;
  use devmedia_site;
  create table funcionario(
                  id int auto_increment primary key,
                  nome varchar(50),
                  cpf varchar(15),
                  salario double
  );