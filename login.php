<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Scolastance - Connection</title>
	<meta charset="utf-8">
	<link rel="shortcut icon" type="image/x-icon" href="../images/logo.png" />
	<link rel="stylesheet" type="text/css" href="./Model.css">
	<script type="text/javascript"></script>

	<style type="text/css">

		.divBody {
			margin-top: 10px;
			display: flex;
			align-items: center;
			justify-content: center;
		}

		.divScreenLogin {
			background-color: #a9bbbe;
			width: 30%;
			border: black solid 10px;
		}

		#divLog, #divMdp{
			width: 100%;
			height: 60px;
			margin: 10px;
			text-align: center;
			border-bottom: black solid 10px;
		}


		.firstDiv{
			display: flex;
		}

		.formDiv{
			border: solid black 2px;
			border-radius: 40%;
			width: 30%;
			margin: 30px 30px;
			flex-wrap: wrap;
			height: 40px;
			text-align: center;
			line-height: 50px;
			font-size: 1.2em;
		}


		.deleteBtn{
			border: solid red 1px;
			color: red;
		}

		.enterBtn{
			border: solid green 1px;
			color: green;
		}

		.deleteBtn:hover, .enterBtn:hover{
			background-color: grey;
		}

		.clickable:hover{
			background-color: white;
		}



	</style>
</head>
<body id="theBody">
	<header>
			<li><a href="#home">Home</a></li>
	</header>

	<?php		
		include 'bdd_fonctions.php';

		define('USER',"root");
		define('PASSWD',"");
		define('SERVER',"localhost");
		define('BASE',"scolastest");

		//Connexion à la base de donnée
		$connexionBDD = connect_bd();

		//Si nous ne sommes pas connecté, on affiche un moyen de se connecter
		if(!isset($_SESSION["login"])){
	
	?>
	<form action="" method="post">
		<div class="divBody">
			<div class="divScreenLogin">
				<div class="firstDiv">
					<div id="divLog">
						<input type="text" name="login" placeholder="login" required="required">
					</div>
				</div>
				<div class="firstDiv">
					<div id="divMdp">
						<input id="inputPassword" type="password" name="password" placeholder="password" required="required">
					</div>
				</div>
				<div class="firstDiv">
					<div id="divL2C0" name="divCaps" class="clickable formDiv"></div>
					<div id="divL2C1" name="divCaps" class="clickable formDiv"></div>
					<div id="divL2C2" name="divCaps" class="clickable formDiv"></div>
				</div>
				<div class="firstDiv">
					<div id="divL3C0" name="divCaps" class="clickable formDiv"></div>
					<div id="divL3C1" name="divCaps" class="clickable formDiv"></div>
					<div id="divL3C2" name="divCaps" class="clickable formDiv"></div>
				</div>
				<div class="firstDiv">
					<div id="divL4C0" name="divCaps" class="clickable formDiv"></div>
					<div id="divL4C1" name="divCaps" class="clickable formDiv"></div>
					<div id="divL4C2" name="divCaps" class="clickable formDiv"></div>
				</div>
				<div class="firstDiv">
					<div id="divL5C0" name="divDelete" class="deleteBtn formDiv">Retour</div>
					<div id="divL5C1" name="divCaps" class="clickable formDiv"></div>
					<div id="divL5C2" name="divEnter" class="enterBtn formDiv"><input type="submit" name="Envoyer" value="OK" onclick="checkIdentifiant()"></div>
				</div>
			</div>
		</div>
	</form>

	<?php 

	
			
		//Afficher des nombres dans des divs tous différent
		echo'<script>	var theDiv = document.getElementsByName("divCaps");
		var numberUsed = [];
		var x;

		for (i = 0; i < theDiv.length; i++){
			//Choisir un premier nombre random
			x = Math.floor(Math.random()*10).toString();
			//Si le nombre est déjà utilisé, reprendre un nouveau nombre
			while (numberUsed.includes(x)){
				x = Math.floor(Math.random()*10).toString();
			}
			//Ajouter le nombre dans mon tableau des anciennes valeurs
			numberUsed.push(x);
			//console.log(numberUsed);
			//document.getElementById("div " + i).innerHTML = x;
			theDiv[i].setAttribute(\'value\', x);
			theDiv[i].innerHTML = x;
		}

		</script>';

			//var_dump($_POST);
			if(isset($_POST["Envoyer"])){
				$connexionBDD = connect_bd();
				$compte = getCompte($connexionBDD);
				$bool = false;
				//Vérification login et mdp
				foreach ($compte as $key => $value) {
					if($_POST["login"]==$value['login'] && $_POST["password"]==$value['passwd']){
						$_SESSION["login"]=$value['login'];
						header("Location: http://localhost/EcranLogin/page3.php");
						$bool = true;
					}
				}
				if($bool == false){
					echo '<script>alert ("Login ou mot de passe incorrect")</script>';
					header("Location: login.php?erreur=1");
				}
				
			}

		}else{
			echo 'Bonjour '.$_SESSION['login'].'<br/>';
			echo '<a href="logout.php">Déconnexion</a>';
		}

	?>
	<!--Formulaire d'inscription-->
	<form method="post" action="#">
		<fieldset><legend>Formulaire d'inscription</legend>
			<input type="text" name="loginInsc" placeholder="Login" required="required"><br/>
			<input type="text" name="nomInsc" placeholder="Nom" required="required"><br/>
			<input type="text" name="prenomInsc" placeholder="Prenom" required="required"><br/>
			<input type="password" name="passwdInsc" placeholder="Mot de passe (chiffre)" required="required"><br/>
			<input type="password" name="passwdConfInsc" placeholder="Confirmation du mot de passe" required="required"><br/>
			<select required="required" name="typeInsc">
				<?php 
					$req = 'SELECT type FROM listetype';
					$sql = $connexionBDD->query($req);
					foreach ($sql as $key => $value) {
						if($value['type']=='etudiant'){
							echo '<option value="'.$value['type'].'" selected>'.$value['type'].'</option>';
						}else{
							echo '<option value="'.$value['type'].'">'.$value['type'].'</option>';
						}
					}
				?>
			</select><br/>
			<select name="matInsc">
				<option value="Algo">Algorithmie</option>
				<option value="GD">Game Design</option>
				<option value="Web">Web</option>
			</select>
			<input type="submit" name="NewAccount">
		</fieldset>

	</form>

	<?php  
		//Inscription
		if(isset($_POST["NewAccount"])){
			//Check si il n'y a pas de caractère spéciaux
			if(ctype_alpha($_POST['loginInsc'])){
				//Check si le mdp est uniquement avec des chiffres
				if(is_numeric($_POST['passwdInsc'])){
					//Check si la confirmation est égale au mdp
					if($_POST['passwdInsc'] == $_POST['passwdConfInsc']){
						$connexionBDD = connect_bd();
						$comptePresent = getCompte($connexionBDD);
						$freeLogin = true;
						//Check si le login est libre
						foreach ($comptePresent as $key => $value) {
							if($value['login'] == $_POST['loginInsc']){
								$freeLogin = false;
							}
						}
						if($freeLogin == true){
							$post = $_POST;
							$listProf = getListeProf($connexionBDD);
							$listEleve = getListeEleve($connexionBDD);
							//Ajout des éléments dans les tables
							setCompte($connexionBDD, $_POST['loginInsc'],$_POST['passwdInsc'],$_POST['typeInsc']);
							if($_POST['typeInsc']=='professeur'){
								$doId = true;
								while ($doId==true) {
									$newId = rand(1,150);
									$doId = false;
									foreach ($listProf as $key => $value) {
										if($value['loginProf'] == $newId){
											$doId = true;
										}
									}
								}
								setListeProf($connexionBDD,$listProf,$post,$newId);
								$listProf = getListeProf($connexionBDD);
								setGroupProf($connexionBDD,$listProf,$listEleve,$newId);
								echo '<script>alert ("Nouveau compte professeur créé!");</script>';
							}else if($_POST['typeInsc']=='etudiant'){
								$doId = true;
								while ($doId==true) {
									$newId = rand(1,150);
									$doId = false;
									foreach ($listEleve as $key => $value) {
										if($value['loginEtud'] == $newId){
											$doId = true;
										}
									}
								}
								setListeEleve($connexionBDD,$listEleve,$post,$newId);
								$listEleve = getListeEleve($connexionBDD);
								setGroupEleve($connexionBDD,$listProf,$listEleve,$newId);
								echo '<script>alert ("Nouveau compte étudiant créé!");</script>';
							}
						}else{
							echo '<script>alert ("Identifiant déjà existant!");</script>';
						}
					}else{
						echo '<script>alert ("Confirmation du mot de passe incorrect!");</script>';
					}
				}else{
					echo '<script>alert ("Mot de passe incorrect!");</script>';
				}
			}else{
				echo '<script>alert ("Identifiant incorrect!");</script>';
			}
		}

	?>

	<script type="text/javascript">
		//Mettre une valeur à tout les backgrounds color des divs clickable
		var theDivGuess = document.getElementsByName("divCaps");
		var password_value = "";
		var theInputPassword = document.getElementById("inputPassword");

		
		//Rendre mes divs clickables
		$("#divL2C0").click(function(){		
			var theDivClicked = document.getElementById("divL2C0");
			password_value += theDivClicked.getAttribute('value');
			theInputPassword.value = password_value;
		});

		$("#divL2C1").click(function(){
			var theDivClicked = document.getElementById("divL2C1");
			password_value += theDivClicked.getAttribute('value');
			theInputPassword.value = password_value;
		});

		$("#divL2C2").click(function(){
			var theDivClicked = document.getElementById("divL2C2");
			password_value += theDivClicked.getAttribute('value');
			theInputPassword.value = password_value;
		});

		$("#divL3C0").click(function(){
			var theDivClicked = document.getElementById("divL3C0");
			password_value += theDivClicked.getAttribute('value');
			theInputPassword.value = password_value;
		});

		$("#divL3C1").click(function(){
			var theDivClicked = document.getElementById("divL3C1");
			password_value += theDivClicked.getAttribute('value');
			theInputPassword.value = password_value;
		});

		$("#divL3C2").click(function(){
			var theDivClicked = document.getElementById("divL3C2");
			password_value += theDivClicked.getAttribute('value');
			theInputPassword.value = password_value;
		});

		$("#divL4C0").click(function(){
			var theDivClicked = document.getElementById("divL4C0");
			password_value += theDivClicked.getAttribute('value');
			theInputPassword.value = password_value;
		});

		$("#divL4C1").click(function(){
			var theDivClicked = document.getElementById("divL4C1");
			password_value += theDivClicked.getAttribute('value');
			theInputPassword.value = password_value;
		});

		$("#divL4C2").click(function(){
			var theDivClicked = document.getElementById("divL4C2");
			password_value += theDivClicked.getAttribute('value');
			theInputPassword.value = password_value;
		});

		$("#divL5C1").click(function(){
			var theDivClicked = document.getElementById("divL5C1");
			password_value += theDivClicked.getAttribute('value');
			theInputPassword.value = password_value;
		});

		//delete btn
		$("#divL5C0").click(function(){
			var theDivClicked = document.getElementById("divL5C0");
			password_value = "";
			theInputPassword.value = password_value;
		});
	
	</script>

<footer id="BBody" name="BBody">
        
        <div id="dF1" name="dF1" class="divFooter">
        
            <img src="../images/logo.png" id="logo2" name="signature" class="logo" width="8%" height="3%">

            <p id="pF1" name="pF1" class="FooterP"> Quentin KUNZ | 2020 - 2021 </p>
            
            <p id="pF2" name="pF2" class="FooterP"> Contact : q.kunz@ludus-academie.com </p>

        </div>
    
    </footer>
</body>
</html>