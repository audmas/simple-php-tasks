<?php  include('php_code.php');
 $idpav1 = $_SESSION['superhero'];
 $results_per_page = 10;
 echo "Esate šalyje $idpav1 <br>";
 // analogiska struktura kaip ir index1
 ?>

<?php 
	if (isset($_GET['edit1'])) {
		$id = $_GET['edit1'];
		$update = true;
                "SELECT * FROM miestai WHERE Pavadinimas=$id";
		$record = mysqli_query($db, "SELECT * FROM miestai WHERE Pavadinimas='$id';");

		if (count($record) == 1 ) {
			$n = mysqli_fetch_array($record);
			$Pavadinimas = $n['Pavadinimas'];
			$Užimamas_plotas = $n['Užimamas plotas'];
                        $Gyventoju_skaičius = $n['Gyventoju skaičius'];
                        $Miesto_kodas = $n['Miesto pašto kodas'];
                        $fk_Pavadinimas = $n['fk_Pavadinimas'];
                        
		}
	}
          if(isset ($_POST['filter']))
        {
            $Nuo = $_POST['Nuo'];
            $Iki = $_POST['Iki'];
            $query = "SELECT * FROM miestai WHERE Data > '$Nuo' AND Data <'$Iki' AND fk_Pavadinimas ='$idpav1'";
           
            $result = mysqli_query($db ,$query);
            $PaieškosKiekis = mysqli_num_rows($result);
            $VykstaDatosPaieška = true;
           
        }
        elseif(isset ($_POST['search']))
        {
            $Paieška = $_POST['Paieška'];
            $query = "SELECT * FROM miestai WHERE `Pavadinimas` LIKE '%$Paieška%' "
                    . "AND `fk_Pavadinimas` ='$idpav1'";
            $result = mysqli_query($db ,$query);
            $PaieškosKiekis = mysqli_num_rows($result);
            $VykstaPaprastaPaieška = true;
           
        }
?>

<!DOCTYPE html>
<html>
<head>
	<title>CRUD: CReate, Update, Delete PHP MySQL</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
        <a href="index.php" class="edit_btn" >Pradžia (Šalių puslapis)</a>
        <br>
        <a href="index2.php" class="del_btn" >Grįžkite į šalies miestus</a>
        <?php if (isset($_SESSION['message'])): ?>
	<div class="msg">
		<?php  
                        
			echo $_SESSION['message']; 
			unset($_SESSION['message']);
		?>
	</div>
        <?php endif ?>
        <?php if (isset($_SESSION['negerai'])): ?>
        <div class="msgnegerai">
		<?php 
			echo $_SESSION['negerai']; 
			unset($_SESSION['negerai']);
		?>
	</div>
        <?php endif ?>
    
	<form method="post" action="php_code.php" >
        
        
		<div class="input-group">
              
			<label>Pavadinimas</label>
			<input type="text" name="Pavadinimas" value="<?php echo $Pavadinimas; ?>">
		</div>
        
		<div class="input-group">
			<label>Užimamas plotas</label>
			<input type="text" name="Užimamas_plotas" value="<?php echo $Užimamas_plotas; ?>">
		</div>
                
                <div class="input-group">
              
			<label>Gyventoju skaičius</label>
			<input type="text" name="Gyventoju_skaičius" value="<?php echo $Gyventoju_skaičius; ?>">
		</div>
                
                <div class="input-group">
              
			<label>Miesto pašto kodas</label>
			<input type="text" name="Miesto_kodas" value="<?php echo $Miesto_kodas; ?>">
		</div>
                
                <div class="input-group">
              
			<label>Šalis</label>
			<input type="text" name="fk_Pavadinimas" value="<?php echo $fk_Pavadinimas; ?>">
                        
                        
		</div>
        
		<div class="input-group">
                    
                    
		<?php if ($update == true): ?>
	<button class="btn" type="submit" name="update1" style="background: #556B2F;" >Atnaujinti miestą</button>
        <?php else: ?>
	<button class="btn" type="submit" name="save1" >Pridėkite miestą</button>
        <?php endif ?>	
		</div>
	</form>
    
     <?php 
     
     
  
     ?>
     <?php if($VykstaPaprastaPaieška == false && $VykstaDatosPaieška == false){ ?> 
    <form method="post" action="" >  
             
            <input type="submit" name="ASC" value="Rikiuoti šalis pagal pavadininimą didejančiai"><br><br>
            <input type="submit" name="DESC" value="Rikiuoti šalis pagal pavadininimą mažejančiai"><br><br> 
             <?php } ?>	
            </form>    
       	
    
      <?php  

if($VykstaPaprastaPaieška == false && $VykstaDatosPaieška == false)
{
        if (!isset($_GET['page'])) {
            $page = 1;
        } else {
         $page = $_GET['page'];
       }
        $this_page_first_result = ($page-1)*$results_per_page;
      
        // Ascending Order
        if(isset($_POST['ASC']))
        {
                 $asc_query = "SELECT * FROM miestai WHERE fk_Pavadinimas='$idpav1'"
                         . " ORDER BY Pavadinimas ASC "
                         . "LIMIT  $this_page_first_result ,  $results_per_page";
                 $result = mysqli_query($db, $asc_query);
               
        }
        

        // Descending Order
        elseif (isset ($_POST['DESC'])) 
        {
          $desc_query = "SELECT * FROM miestai WHERE fk_Pavadinimas ='$idpav1' "
                  . "ORDER BY Pavadinimas DESC "
                  . "LIMIT  $this_page_first_result ,  $results_per_page";
                  ;
                 
          $result = mysqli_query($db, $desc_query);
            
        }
    
        // Default Order
        else {
        $default_query = "SELECT * FROM miestai WHERE fk_Pavadinimas ='$idpav1' "
                . "LIMIT  $this_page_first_result ,  $results_per_page";
        $result = mysqli_query($db, $default_query);
       
                }
                
}
       
        $kiekis = mysqli_query($db,  "SELECT * FROM miestai WHERE fk_Pavadinimas ='$idpav1'");
        
        $number_of_results = mysqli_num_rows($kiekis);
        $number_of_pages = ceil($number_of_results/$results_per_page);
        ?>
        
<table>
	<thead>
		<tr> <?php   if($PaieškosKiekis > 0) {?>
			<th>Pavadinimas</th>
			<th>Užimamas plotas</th>
                        <th>Gyventoju skaičius</th>
                        <th>Miesto pašto kodas</th>
                        
			<th colspan="2">Veiksmai</th>
		</tr>
	</thead>
	
	<?php while ($row = mysqli_fetch_array($result)) { ?>
		<tr>
			
                        <td><?php echo $row['Pavadinimas']; ?></td>
			<td><?php echo $row['Užimamas plotas']; ?></td>
                        <td><?php echo $row['Gyventoju skaičius']; ?></td>
			<td><?php echo $row['Miesto pašto kodas']; ?></td>
                        
			<td>
				<a href="index2.php?edit1=<?php echo $row['Pavadinimas']; ?>" class="edit_btn" >Atnaujinti</a>
			</td>
                        
			<td>
				<a href="php_code.php?del1=<?php echo $row['Pavadinimas']; ?>" class="del_btn">Ištrinti</a>
			</td>
		</tr>
                <?php } }  else {
          echo "Įrašų pagal jūsų paieška nėra";
        } ?>
</table> 
<?php if($VykstaPaprastaPaieška == false && $VykstaDatosPaieška == false) {?> 
 <form method="post" action="index.php" > 
     <?php
for ($page=1;$page<=$number_of_pages;$page++) { 
    

$puslapiunr = '<a href="index2.php?page=' . $page . '">' . $page . '</a>'; ?>
  
     <td align=center><?php
     echo $puslapiunr; ?></td>
 <?php } } ?>

 </form>
<?php 
if($VykstaDatosPaieška == false || $VykstaPaprastaPaieška == true){?>
<form method="post" action="index2.php" >  
<div class="input-group">
              
			
			<input type="text" name="Paieška" value="<?php echo $Paieška; ?>">
		</div>

	<button class="btn" type="submit" name="search" >Miestų paieška šalyje <?php echo $idpav1; ?> </button>
 <?php }  ?>      	      
</form>
    <?php if($VykstaDatosPaieška == true || $VykstaPaprastaPaieška == false)  {?>	
    <form method="post" action="index2.php" >  
<div class="input-group">
              

    <input type="datetime" name="Nuo" value="<?php echo $Nuo; ?>">
    <input type="datetime" name="Iki" value="<?php echo $Iki; ?>">
		</div>

	<button class="btn" type="submit" name="filter" >Filtruojame miestus pagal pridėjimo data šalyje <?php echo $idpav1; ?></button>
      <?php }  ?>    	      
</form>
</body>

</html>