<?php 
	//Fonction qui permet la connection de la base
	function connect_bd(){
		$dsn="mysql:dbname=".BASE.";host=".SERVER;
		try{
			$connexion=new PDO($dsn,USER,PASSWD);
		}
		catch(PDOException $e){
			printf("Echec de la connexion : %s\n", $e->getMessage());
			exit();
		}
		$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $connexion;
	}

	//Fonction qui permet d'obtenir les comptes utilisateur
	function getCompte($connexionBDD){
		$compte=[];
		$req = 'SELECT *
				FROM listecompte';
		try{
			//Prépare et exécute la requête
			$stmt = $connexionBDD->query($req);
			//données récupéré sous forme de tableau
			while($donnees = $stmt->fetch(PDO::FETCH_ASSOC)){
				$compte[]=$donnees;
			}
			//on ferme la base
			$stmt->closeCursor();
			return $compte;
		}
		catch(PDOException $e){
			echo "Erreur : ".$e->getMessage();
		}
	}

	//Fonction qui ajoute un nouveau compte 
	function setCompte($connexionBDD,$loginUser,$passwdUser,$typeUser){

		$req = 'INSERT INTO listecompte (login,passwd,type) VALUES
					(:login,:passwd,:type)';
		try{
			//Prépare et exécute la requête
			$stmt = $connexionBDD->prepare($req);
			
			$stmt->bindValue(':login',$loginUser, PDO::PARAM_STR);
			$stmt->bindValue(':passwd',$passwdUser, PDO::PARAM_STR);
			$stmt->bindValue(':type',$typeUser, PDO::PARAM_STR);

			//Exécute la requête
			$stmt->execute();

			//On ferme la base
			$stmt->closeCursor();

		}
		catch(PDOException $e){
			echo "Erreur : ".$e->getMessage();
		}
	}

	//Fonction qui permet l'ajout d'un nouveau compte professeur
	function setListeProf($connexionBDD,$listProf,$post,$newId){

		$req = 'INSERT INTO listeprof (id_prof,loginProf,matiere_cours,nom_prof,prenom_prof) VALUES
					(:id_prof,:loginProf,:matiere_cours,:nom_prof,:prenom_prof)';
		try{
			//Prépare et exécute la requête
			$stmt = $connexionBDD->prepare($req);

			$stmt->bindValue(':id_prof',$newId, PDO::PARAM_STR);
			$stmt->bindValue(':loginProf',$post['loginInsc'], PDO::PARAM_STR);
			$stmt->bindValue(':matiere_cours',$post['matInsc'], PDO::PARAM_STR);
			$stmt->bindValue(':nom_prof',$post['nomInsc'], PDO::PARAM_STR);
			$stmt->bindValue(':prenom_prof',$post['prenomInsc'], PDO::PARAM_STR);

			//Exécute la requête
			$stmt->execute();

			//On ferme la base
			$stmt->closeCursor();

		}
		catch(PDOException $e){
			echo "Erreur : ".$e->getMessage();
		}
	}

	//Fonction qui permet l'ajout d'un nouveau compte dans liste etudiant
	function setListeEleve($connexionBDD,$listEtud,$post,$newId){

		$req = 'INSERT INTO listeetudiant (id_etudiant,loginEtud,nom_etudiant,prenom_etudiant) VALUES
					(:id_etudiant,:loginEtud,:nom_etudiant,:prenom_etudiant)';
		try{
			//Prépare et exécute la requête
			$stmt = $connexionBDD->prepare($req);

			$stmt->bindValue(':id_etudiant',$newId, PDO::PARAM_STR);
			$stmt->bindValue(':loginEtud',$post['loginInsc'], PDO::PARAM_STR);
			$stmt->bindValue(':nom_etudiant',$post['nomInsc'], PDO::PARAM_STR);
			$stmt->bindValue(':prenom_etudiant',$post['prenomInsc'], PDO::PARAM_STR);

			//Exécute la requête
			$stmt->execute();

			//On ferme la base
			$stmt->closeCursor();

		}
		catch(PDOException $e){
			echo "Erreur : ".$e->getMessage();
		}
	}

	//set groupe avec nouveau prof
	function setGroupProf($connexionBDD,$listProf,$listEleve,$newId){
		foreach ($listEleve as $key => $value) {
			$req = 'INSERT INTO listegroupe (id_etudiant,id_prof) VALUES
					(:id_etudiant,:id_prof)';

			try{
				$stmt = $connexionBDD->prepare($req);

				$stmt->bindValue(':id_etudiant',$listEleve[$key]['id_etudiant'], PDO::PARAM_STR);
				$stmt->bindValue(':id_prof',$newId, PDO::PARAM_STR);


				//Exécute la requête
				$stmt->execute();
			}
			catch(PDOException $e){
				echo "Erreur : ".$e->getMessage();
			}
		}
		
	}

	//set groupe avec nouveau eleve
	function setGroupEleve($connexionBDD,$listProf,$listEleve,$newId){
		foreach ($listProf as $key => $value) {
			$req = 'INSERT INTO listegroupe (id_etudiant,id_prof) VALUES
					(:id_etudiant,:id_prof)';

			try{
				$stmt = $connexionBDD->prepare($req);

				$stmt->bindValue(':id_etudiant',$newId, PDO::PARAM_STR);
				$stmt->bindValue(':id_prof',$listProf[$key]['id_prof'], PDO::PARAM_STR);


				//Exécute la requête
				$stmt->execute();
			}
			catch(PDOException $e){
				echo "Erreur : ".$e->getMessage();
			}
		}
		
	}

	//Récupère les noms prof
	function getUserKeyProf($connexionBDD,$log){
		$userKey=[];
		$req = 'SELECT nom_prof
				FROM listecompte, listeprof
				WHERE listecompte.login = listeprof.loginProf and listecompte.login ="'.$log.'"';
		try{
			//Préparer et exécuter la requête
			$stmt = $connexionBDD->query($req);
			//On récupère les données sous forme d'un tableau
			while($donnees = $stmt->fetch(PDO::FETCH_ASSOC)){
				$userKey[]=$donnees;
			}
			//On ferme la base
			$stmt->closeCursor();

			return $userKey;
		}
		catch(PDOException $e){
			echo "Erreur : ".$e->getMessage();
		}
	}

	//Récupère les noms etudiant
	function getUserKeyEtud($connexionBDD,$log){
		$userKey=[];
		$req = 'SELECT nom_etudiant
				FROM listecompte, listeetudiant
				WHERE listecompte.login = listeetudiant.loginEtud and listecompte.login ="'.$log.'"';
		try{
			//Prépare et exécute la requête
			$stmt = $connexionBDD->query($req);
			//Données récupérées sous tableau
			while($donnees = $stmt->fetch(PDO::FETCH_ASSOC)){
				$userKey[]=$donnees;
			}
			//On ferme la base
			$stmt->closeCursor();

			return $userKey;
		}
		catch(PDOException $e){
			echo "Erreur : ".$e->getMessage();
		}
	}

	//Obtenir la liste des profs
	function getListeProf($connexionBDD){
		$prof=[];
		$req = 'SELECT *
				FROM listeprof';
		try{
			//Prépare et exécute la requête
			$stmt = $connexionBDD->query($req);
			//Donnée en tableau
			while($donnees = $stmt->fetch(PDO::FETCH_ASSOC)){
				$prof[]=$donnees;
			}
			//On ferme la base
			$stmt->closeCursor();
			return $prof;
		}
		catch(PDOException $e){
			echo "Erreur : ".$e->getMessage();
		}
	}

	//Obtenir la liste des élèves
	function getListeEleve($connexionBDD){
		$eleve=[];
		$req = 'SELECT *
				FROM listeetudiant';
		try{
			//Prépare et exécute la requête
			$stmt = $connexionBDD->query($req);
			//Données en tableau
			while($donnees = $stmt->fetch(PDO::FETCH_ASSOC)){
				$eleve[]=$donnees;
			}
			//On ferme la base
			$stmt->closeCursor();
			return $eleve;
		}
		catch(PDOException $e){
			echo "Erreur : ".$e->getMessage();
		}
	}

	//Obtenir la matière
	function getClass($keyUser,$listProf){
		foreach ($listProf[0] as $key => $value) {
			if($value['nom_prof'] == $keyUser){
				$class = $value['matiere_cours'];
			}
		}
		return $class;
	}

	//Obtenir prenom + nom prof
	function getPrenomNomProf($keyUser,$listProf){
		foreach ($listProf[0] as $key => $value) {
			if($value['nom_prof'] == $keyUser){
				$prenomNom = $value['prenom_prof'].' '.$value['nom_prof'];
			}
		}
		return $prenomNom;
	}

	//obtenir prenom + nom eleve
	function getPrenomNomEleve($keyUser,$listEleve){
		foreach ($listEleve[0] as $key => $value) {
			if($value['nom_etudiant'] == $keyUser){
				$prenomNom = $value['prenom_etudiant'].' '.$value['nom_etudiant'];
			}
		}
		return $prenomNom;
	}

	//obtenir les notes de tout les élèves
	function getNoteEleve($connexionBDD){
		$noteClass=[];
		$req = 'SELECT prenom_etudiant, nom_etudiant, valeur, matiere_test
				FROM listeetudiant, listenote
				WHERE listeetudiant.id_etudiant = listenote.id_etudiant
				ORDER BY nom_etudiant';
		try{
			//Prépare et exécute la requête
			$stmt = $connexionBDD->query($req);
			//Données en tableau
			while($donnees = $stmt->fetch(PDO::FETCH_ASSOC)){
				$noteClass[]=$donnees;
			}
			//On ferme la base
			$stmt->closeCursor();
			return $noteClass;
		}
		catch(PDOException $e){
			echo "Erreur : ".$e->getMessage();
		}
	}

	//Fonction qui permet d'ajouter une note
	function addNote($post,$connexionBDD,$class){
		$req = 'INSERT INTO listenote (matiere_test,valeur,id_etudiant) VALUES 
				(:matiere_test,:valeur,:id_etudiant)';

		try{
			//Prépare la requête
			$stmt = $connexionBDD->prepare($req);

			$stmt->bindValue(':matiere_test',$class,PDO::PARAM_STR);
			$stmt->bindValue(':valeur',$post['valeur'],PDO::PARAM_STR);
			$stmt->bindValue(':id_etudiant',$post['eleve'],PDO::PARAM_STR);

			//Exécute la requête
			$stmt->execute();

			//Vérification
			echo '<script>alert("Insertion de la nouvelle note effectuée");</script>';
		}
		catch(PDOException $e){
			echo 'Erreur : '.$e->getMessage();
		}
	}

	function getNbNoteEtud($connexionBDD,$nom){
		$noteEtud=[];
		$req = 'SELECT count(valeur) as nbNote
				FROM listeetudiant, listenote
				WHERE listeetudiant.id_etudiant = listenote.id_etudiant and nom_etudiant ="'.$nom.'"';
		try{
			//Prépare et exécute la requête
			$stmt = $connexionBDD->query($req);
			//Données en tableau
			while($donnees = $stmt->fetch(PDO::FETCH_ASSOC)){
				$noteClass[]=$donnees;
			}
			//On ferme la base
			$stmt->closeCursor();
			return $noteClass;
		}
		catch(PDOException $e){
			echo "Erreur : ".$e->getMessage();
		}
	}


?>

