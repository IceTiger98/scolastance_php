delete from listetype;

insert into listetype(type) values
	('etudiant'),
	('professeur'),
	('admin');

delete from listecompte;

insert into listecompte(login, passwd, type) values
	('gmadembo','1234','professeur'),
	('nvalentin','1234','professeur'),
	('nlehmann','1234','professeur'),
	('jzumkir','1234','etudiant'),
	('fgete','1234','etudiant'),
	('mschwartz','1234','etudiant');

delete from listeprof;

insert into listeprof(id_prof,nom_prof,prenom_prof,matiere_cours,loginProf) values
	('1','Madembo','Grace','Web','gmadembo'),
	('2','Valentin','Nicolas','GD','nvalentin'),
	('3','Lehman','Nicolas','Algo','nlehmann');

delete from listeetudiant;

insert into listeetudiant(id_etudiant,nom_etudiant,prenom_etudiant,loginEtud) values
	('1','Zumkir','Jeffrey','jzumkir'),
	('2','Gete','François','fgete'),
	('3','Schwartz','Marine','mschwartz');


delete from listegroupe;

insert into listegroupe(id_prof,id_etudiant) values
	('1','1'),
	('1','2'),
	('1','3'),
	('2','1'),
	('2','2'),
	('2','3'),
	('3','1'),
	('3','2'),
	('3','3');

delete from listenote;

insert into listenote(id_note,matiere_test,valeur,id_etudiant) values
	('1','Web','18','1'),
	('2','Web','17','2'),
	('3','Web','19','3'),
	('4','Web','14','1'),
	('5','Web','18','2'),
	('6','Web','13','3'),
	('7','GD','18','1'),
	('8','GD','16','1'),
	('9','GD','17','2'),
	('10','GD','18','3');

