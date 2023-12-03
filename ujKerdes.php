<html lang="en">
<?php
		session_start();
		
		//Ha nem létezik a session visszadob a loginhoz
		if(!isset($_SESSION["Name"])){
			header("Location: login.php");
		}
	?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="ujKerdes.css">
    <title>Új kérdés felvétele</title>
</head>
<body>
    
    <div id="header">
        <a href="index.php"><button id="back" class="login">⬅</button></a>
        
        
        <button class="login"><?php echo $_SESSION["Name"];?></button>
    </div>
    <div class="container">
        <form action="ujKerdes.php" method="post" enctype="multipart/form-data">
            
            <input type="text" name="ujKerdes" id="ujKerdes" placeholder="Új kérdés...">
            <div class="kerdesFajta">
                <p>
                    <input type="radio" name="fajta" value="felet">
                    <label>Felet választós</label>
                </p>
                
                <p >
                    <input type="radio" name="fajta" value="önálló">
                    <label>Önálló válasz</label>
                </p>
            </div>
            <div class="radio-grid">
                
                    <input class="radioStyle" type="radio" name="radio" value="1">
                    <input type="text" class="valasz" name="valasz1">

                    <input class="radioStyle" type="radio" name="radio" value="2">
                    <input type="text" class="valasz" name="valasz2"><br>
                
                    <input class="radioStyle" type="radio" name="radio" value="3">
                    <input type="text" class="valasz" name="valasz3">

                    <input class="radioStyle" type="radio" name="radio" value="4">
                    <input type="text" class="valasz" name="valasz4">
                
            </div>
            <div class="footer">
                <p>
                    <input class="pont" type="text" name="pont" id="pont" value="">
                    <label for="pont">Pont</label>
                </p>
                <p>
                    <input class="next" type="submit" value="Következő→" name="next">
                </p>
                
            </div>
                <input name="import" type="file" id="import" class="login"  accept=".json" required><br>
                <input class="next" type="submit" value="Feltöltés" name="upload" id="upload">
        </form>
    </div>
    <?php
    try {
        $connDB = new PDO("mysql:host=localhost;dbname=project_testing","root","");
        $connDB->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e){
        echo "<p class=\"error\">Adatbázis kapcsolódási hiba: {$e->getMessage()}</p>\n";
        die();
    } catch (Throwable $e){
        echo "<p class=\"error\">Ismeretlen hiba: {$e->getMessage()}</p>\n";
        die();
    }
    if (isset($_POST["next"])){
        $ujKerdes = trim($_POST["ujKerdes"]);
        $helyes = (int)$_POST["radio"];
        $valasz1 = trim($_POST["valasz1"]);
        $valasz2 = trim($_POST["valasz2"]);
        $valasz3 = trim($_POST["valasz3"]);
        $valasz4 = trim($_POST["valasz4"]);
        $pont = (int)$_POST["pont"];

        //összetettebb if feltétel
        //!empty($ujKerdes) && !empty($radio) && !empty($valasz1) && !empty($valasz2) && !empty($valasz3) && !empty($valasz4) && !empty($pont)
        if (!empty($ujKerdes)){
            try{
                $sql = "INSERT INTO questions (question, correct, answer1, answer2, answer3, answer4, point)
                    VALUES ('$ujKerdes', '$helyes', '$valasz1', '$valasz2', '$valasz3', '$valasz4', '$pont')";         
                $connDB->exec($sql);
                echo "<p>Új kérdés felvéve</p>"; 
            }catch(PDOException $e){
                echo "<p class=\"error\">Adatbázis hiba: {$e->getMessage()}</p>\n";
            }
            
        }
        
        
    }
    //if ($_FILES["import"]["error"] == UPLOAD_ERR_OK) {   
    if (isset($_POST["upload"])) {
        $jsonContent = file_get_contents($_FILES["import"]["tmp_name"]);
        $jsonData = json_decode($jsonContent);
        foreach($jsonData as $item) {
            $kerdes = $item->kerdes;
            $helyes = (int)$item->helyes;
            $valasz1 = $item->valasz1;
            $valasz2 = $item->valasz2;    
            $valasz3 = $item->valasz3;
            $valasz4 = $item->valasz4;
            $pont = (int)$item->pont;

        }
        try {
            $sql = "INSERT INTO questions (question, correct, answer1, answer2, answer3, answer4, point)
                VALUES ('$kerdes', '$helyes', '$valasz1', '$valasz2', '$valasz3', '$valasz4', '$pont')";         
            $connDB->exec($sql);
            echo "<p id='success'>Kérdés felvéve</p>"; 
        } catch(PDOException $e) {
            echo "<p class=\"error\">Adatbázis hiba: {$e->getMessage()}</p>\n";
        }
        
    }
    

    ?>

</body>
</html>