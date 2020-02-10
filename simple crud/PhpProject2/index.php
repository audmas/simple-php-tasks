<?php  include('php_code.php');
$results_per_page = 10;
echo "Esate šalių puslapyje<br>";
?>

<?php // mygtuku paspaudimai
	if (isset($_GET['edit'])) {
		$id = $_GET['edit'];
		$update = true;
		$record = mysqli_query($db, "SELECT * FROM šalys WHERE id=$id");

		if (count($record) == 1 ) {
			$n = mysqli_fetch_array($record);
			$Pavadinimas = $n['Pavadinimas'];
                        $_SESSION['pav'] = $n['Pavadinimas'];
			$Užimamas_plotas = $n['Užimamas plotas'];
                        $Gyventoju_skaičius = $n['Gyventoju skaičius'];
                        $Telefono_kodas = $n['Telefono kodas'];
                        
		}
	}
if(isset ($_POST['search']))
{
    $Paieška = $_POST['Paieška'];
    $query = "SELECT * FROM šalys WHERE Pavadinimas LIKE '%$Paieška%'";
    $result = mysqli_query($db ,$query);
    $PaieškosKiekis = mysqli_num_rows($result);
    $VykstaPaprastaPaieška = true;
}
elseif(isset ($_POST['filter']))
{
    $Nuo = $_POST['Nuo'];
    $Iki = $_POST['Iki'];
    $query = "SELECT * FROM šalys WHERE Data > '$Nuo' AND Data <'$Iki'";
   
    $result = mysqli_query($db ,$query);
    $PaieškosKiekis = mysqli_num_rows($result);
    $VykstaDatosPaieška = true;
}
        
?>


<!DOCTYPE html>
<html>
<head>
	<title>CRUD: CReate, Update, Delete PHP MySQL</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
    
		<a href="index.php" class="edit_btn" >Pradžia</a>
			
        <?php if (isset($_SESSION['message'])): ?>
	<div class="msg">
		<?php // zinuciu disponavimas
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
        <input type="hidden" name="id" value="<?php  echo $id; //formos kurimas?>">

        
		<div class="input-group">
              
			<label>Pavadinimas</label>
                        <?php if ($update == true): ?>
                        <input type="text" name="Pavadinimas" disabled="" value="<?php echo $Pavadinimas; ?>">
                        <?php else: ?>
                        <input type="text" name="Pavadinimas" value="<?php echo $Pavadinimas; ?>">
                        <?php endif ?>
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
              
			<label>Telefono kodas</label>
			<input type="text" name="Telefono_kodas" value="<?php echo $Telefono_kodas; ?>">
		</div>
        
		<div class="input-group">
                    
                    
		<?php if ($update == true): ?>
	<button class="btn" type="submit" name="update" style="background: #556B2F;" >Atnaujinkite šalį</button>
        <?php else: ?>
	<button class="btn" type="submit" name="save" >Pridekite šalį</button>
        <?php endif ?>	
        
		</div>
	</form>
    
        
     
    <?php if($VykstaPaprastaPaieška == false && $VykstaDatosPaieška == false){ ?> 
    <form method="post" action="" >  
             
            <input type="submit" name="ASC" value="Rikiuoti šalis pagal pavadininimą didejančiai"><br><br>
            <input type="submit" name="DESC" value="Rikiuoti šalis pagal pavadininimą mažejančiai"><br><br> 
             <?php } ?>	
            </form>    
       	
    
      <?php




if($VykstaPaprastaPaieška == false && $VykstaDatosPaieška == false)
{
// puslapiavimas
if (!isset($_GET['page'])) {
  $page = 1;
} else {
  $page = $_GET['page'];
}
$this_page_first_result = ($page-1)*$results_per_page;
// Ascending Order rikiavimas

if(isset($_POST['ASC']))
{
    $asc_query = "SELECT * FROM šalys ORDER BY Pavadinimas ASC "
            . "LIMIT $this_page_first_result ,  $results_per_page";
    $result = mysqli_query($db ,$asc_query);
}


// Descending Order rikiavimas
elseif (isset ($_POST['DESC'])) 
    {
          $desc_query = "SELECT * FROM šalys ORDER BY Pavadinimas DESC "
                  . "LIMIT  $this_page_first_result ,  $results_per_page";
          $result = mysqli_query($db, $desc_query);
    }
    
    else{
    // Default Order
        $default_query = "SELECT * FROM šalys "
                . "LIMIT   $this_page_first_result  ,  $results_per_page";
        $result = mysqli_query($db, $default_query);
        
    }
}
$kiekis = mysqli_query($db, "SELECT * FROM šalys");
$number_of_results = mysqli_num_rows($kiekis);
$number_of_pages = ceil($number_of_results/$results_per_page);
?>
<table>
	<thead>
		<tr>
                     <?php   if($PaieškosKiekis > 0) { // lenteles kurimas?>
			<th>Pavadinimas</th>
			<th>Užimamas plotas</th>
                        <th>Gyventoju skaičius</th>
                        <th>Telefono kodas</th>
                        
			<th colspan="2">Veiksmai</th> 
		</tr>
	</thead>
	
                     <?php 
        
        
            
        while ($row = mysqli_fetch_array($result)) { ?>
		<tr>
			<td>
                            <a href="php_code.php?more=<?php echo $row['Pavadinimas'];?>
                               " class="none"><?php echo $row['Pavadinimas'];?> </a>
                            
                        </td>
			<td><?php echo $row['Užimamas plotas']; ?></td>
                        <td><?php echo $row['Gyventoju skaičius']; ?></td>
			<td><?php echo $row['Telefono kodas']; ?></td>
                        
                        
			<td>
				<a href="index.php?edit=<?php echo $row['id']; ?>" class="edit_btn" >Atnaujinti</a>
			</td>
                        
			<td>
				<a href="php_code.php?del=<?php echo $row['Pavadinimas']; ?>" class="del_btn">Ištrinti</a>
			</td>
		</tr>
               
        <?php } }
        else {
          echo "Įrašų pagal jūsų paieška nėra";
        }
?>
</table> 
<?php if($VykstaPaprastaPaieška == false && $VykstaDatosPaieška == false) {?> 
 <form method="post" action="index.php" > 
     <?php
for ($page=1;$page<=$number_of_pages;$page++) { 
    

$puslapiunr = '<a href="index.php?page=' . $page . '">' . $page . '</a>'; ?>
  
     <td align=center><?php
     echo $puslapiunr; ?></td>
 <?php } } ?>

 </form>
<?php 

 if($VykstaDatosPaieška == false || $VykstaPaprastaPaieška == true){?>
<form method="post" action="index.php" >  
<div class="input-group">
              
			
			<input type="text" name="Paieška" value="<?php echo $Paieška; ?>">
		</div>

	<button class="btn" type="submit" name="search" >Šalių paieška</button>
 <?php }  ?>      	      
</form>
    <?php if($VykstaDatosPaieška == true || $VykstaPaprastaPaieška == false)  {?>	
    <form method="post" action="index.php" >  
<div class="input-group">
              

    <input type="datetime" name="Nuo" value="<?php echo $Nuo; ?>">
    <input type="datetime" name="Iki" value="<?php echo $Iki; ?>">
		</div>

	<button class="btn" type="submit" name="filter" >Filtruojame šalis pagal pridėjimo data</button>
      <?php }  ?>    	      
</form>
</body>
</html>