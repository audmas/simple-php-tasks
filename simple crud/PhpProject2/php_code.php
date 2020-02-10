<?php 
	session_start();
        // prisijungimas prie duomenu bazes
	$db = mysqli_connect('localhost', 'root', '', 'teltonika');
        if(!$db)
        {
          die('Something went wrong while connecting to MSSQL (Nepavyko prisijungti prie duomenų bazės)');
        }
        $db->set_charset('utf8');
	// initialize variables
	$Pavadinimas = "";
	$Užimamas_plotas = "";
        $Gyventoju_skaičius = "";
        $Telefono_kodas = "";
        $Miesto_kodas = "";
        $fk_Pavadinimas = "";
        $Paieška = "";
        $PaieškosKiekis = 1;
	$id = 0;
        $ArYraTokiaŠalis = 0;
        $VykstaPaprastaPaieška = false;
        $VykstaDatosPaieška = false;
        $Nuo = '0000-00-00 00:00:00';
        $Iki = '0000-00-00 00:00:00';
        
	$update = false;
        // mygtuko save paspaudimas
	if (isset($_POST['save'])) {
		
                $Pavadinimas = $_POST['Pavadinimas'];
		$Užimamas_plotas = $_POST['Užimamas_plotas'];
                $Gyventoju_skaičius = $_POST['Gyventoju_skaičius'];
                $Telefono_kodas = $_POST['Telefono_kodas'];  

                $date = date('Y/m/d H:i:s');
                $query = "INSERT INTO šalys (`Pavadinimas`, `Užimamas plotas`, `Gyventoju skaičius`"
                        . ", `Telefono kodas` , `Data`) VALUES ('$Pavadinimas', '$Užimamas_plotas',"
                        . " '$Gyventoju_skaičius', '$Telefono_kodas', '$date' )"; 
                
                echo $query; // testavimui
		mysqli_query($db, $query); 
		$_SESSION['message'] = "Nauja šalis išsaugota"; 
		header('location: index.php'); // užtildyt peržiūrėti užklausai;
                
	}
        
        // mygtuko atnaujinti paspaudimas
        if (isset($_POST['update'])) {
	$id = $_POST['id'];
	$Pavadinimas =  $_SESSION['pav'];
	$Užimamas_plotas = $_POST['Užimamas_plotas'];
        $Gyventoju_skaičius = $_POST['Gyventoju_skaičius'];
        $Telefono_kodas = $_POST['Telefono_kodas'];
               
        $query = "UPDATE šalys SET `Pavadinimas`='$Pavadinimas', `Užimamas plotas`='$Užimamas_plotas',"
                . " `Gyventoju skaičius`='$Gyventoju_skaičius', `Telefono kodas` ='$Telefono_kodas' WHERE id=$id";
        
        echo $query; // testavimui
	mysqli_query($db, $query);
	$_SESSION['message'] = "Šalis atnaujinta"; 
	header('location: index.php'); // užtildyt peržiūrėti užklausai;
        }
        // mygtuko istrinti paspaudimas
        if (isset($_GET['del'])) {
        
        $id = $_GET['del'];
	mysqli_query($db, "DELETE FROM šalys WHERE Pavadinimas='$id'");
        mysqli_query($db, "DELETE FROM miestai WHERE fk_Pavadinimas='$id'");
	$_SESSION['message'] = "Šalis ištrinta ir visi miestai ištrinti"; 
	header('location: index.php');
        
        }
        // mygtuko istrinti paspaudimas kitame puslapyje
        if (isset($_GET['del1'])) {
        
        $id = $_GET['del1'];
	//mysqli_query($db, "DELETE FROM šalys WHERE Pavadinimas='$id'");
        mysqli_query($db, "DELETE FROM miestai WHERE Pavadinimas='$id'");
	$_SESSION['message'] = "Miestas ištrintas"; 
	header('location: index2.php');
        
        }
        // nukreipimas i miestu puslapi
        if(isset($_GET['more'])){
            
            $idpav = $_GET['more'];
            $_SESSION['superhero'] = $idpav;
            echo $idpav;
            header('location: index2.php');
        }
        
        
        // miesto isaugojimas
        if (isset($_POST['save1'])) {
		
            
                $Pavadinimas = $_POST['Pavadinimas'];
		$Užimamas_plotas = $_POST['Užimamas_plotas'];
                $Gyventoju_skaičius = $_POST['Gyventoju_skaičius'];
                $Miesto_kodas = $_POST['Miesto_kodas'];  
                $fk_Pavadinimas = $_POST['fk_Pavadinimas'];
                $ŠaliesEgzistacija = "SELECT * FROM šalys WHERE Pavadinimas ='$fk_Pavadinimas'";
                $rez = mysqli_query($db, $ŠaliesEgzistacija);
                $ArYraTokiaŠalis = mysqli_num_rows($rez);
                $date = date('Y/m/d H:i:s');
                 
                if($ArYraTokiaŠalis > 0)
                { 
                $query = "INSERT INTO miestai (`Pavadinimas`, `Užimamas plotas`, `Gyventoju skaičius`"
                        . ", `Miesto pašto kodas`, `fk_Pavadinimas`, `Data`) "
                        . "VALUES ('$Pavadinimas', '$Užimamas_plotas',"
                        . " '$Gyventoju_skaičius', '$Miesto_kodas', '$fk_Pavadinimas', '$date' )"; 
                
                echo $query; // testavimui
		mysqli_query($db, $query); 
		$_SESSION['message'] = "Naujas miestas išsaugotas"; 
		header('location: index2.php'); // užtildyt peržiūrėti užklausai;
                
               }
               else
               {
                    $_SESSION['negerai'] = "Nėra tokios šalies, todėl miesto negalime pridėti";
                    header('location: index2.php');
               }
	}
        // miesto atnaujinimas
        if (isset($_POST['update1'])) {
	
        $id = $_POST['Pavadinimas'];
	$Pavadinimas = $_POST['Pavadinimas'];
	$Užimamas_plotas = $_POST['Užimamas_plotas'];
        $Gyventoju_skaičius = $_POST['Gyventoju_skaičius'];
        $Miesto_kodas = $_POST['Miesto_kodas'];
        $fk_Pavadinimas = $_POST['fk_Pavadinimas'];
                  
        $query = "UPDATE miestai SET `Pavadinimas`='$Pavadinimas', `Užimamas plotas`='$Užimamas_plotas',"
                . " `Gyventoju skaičius`='$Gyventoju_skaičius', `Miesto pašto kodas` ='$Miesto_kodas', `fk_Pavadinimas` ='$fk_Pavadinimas' WHERE Pavadinimas='$id'";
        
        echo $query; // testavimui
	mysqli_query($db, $query);
	$_SESSION['message'] = "Miestas atnaujintas"; 
	header('location: index2.php'); // užtildyt peržiūrėti užklausai;
        }
        
       
        



 
  

        


      
        
       
        
