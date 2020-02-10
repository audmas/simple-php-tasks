<p style="color:red;">
    Uždavinys.
    <br>
    Išskaidyti masyvo elementus į grupes, kurių kiekvienos suma būtų kuo lygesne tarpusavyje.
    <br>
    <br>
    Sprendimas.
    <br>
    Laikome, kad uždavynis yra toks.
     <br>
    1. Masyvą su N elementų reikia išskaidyti į grupes(subsetus) kurių skaičius K, taip, kad jų sumos butu lygios arba aproximaliai lygios.
    <br>
    Čia K nuo 2 iki N-1(masyvų elementų skaičius-1). Jeigu K bus 1, visi elementai bus vienoje grupeje. Jei K = N, kiekvienas elementas bus atskiroje grupeje.
    <br> 
    2. Patikriname ar įmanomą masyvą, išdalinti lygiai į K grupes. Per K yra sukamas masyvas, kad pažiūrėti į kiek subsetų galima išdalinti.
    <br>
    Jei taip randame, tuos subsetus.
    <br>
    Jei ne bandome, į masyvo galą pridėti skaičių 1. 
    <br>
    Jei nepavyksta išsprestį uždavinio po 3 bandymų, laikome, kad įvestas pradinis masyvas yra netikslingas.
    
    
    
    
</p>
<?php
echo "Pradiniai duomenys";
?>

<br>

<?php

// Main(), pagrindinis langas
// klasė, mažųjų grupelių skaičiavimui
include('./partition.php');

$duomenys = array (2,4,6,8,5,1);
//$duomenys = array ( 6,1,2,3,7,4 );
//$duomenys = array ( 6,5,4,5 );
//$duomenys = array ( 4,7,3,2,5,6,7 );


// pradiniu duomenu atspausdinimas
foreach ($duomenys as $skaičius) {
    print_r($skaičius);
    print_r(" ");
}

// skaiciu kiekis
$N = count($duomenys);
// zymesime, kuriame is k subsetu naudojamas skaičius
$SubSetai = array_fill(0, $N, -1);

// perziuresime visus imanomus variantus subsetu nuo 2 iki N-1
// cia K - i kiek grupiu dalinamas masyvas
for($K = 2; $K < $N; $K++){
    
  // patikriname ar imanoma lygiai isdalinti skaicius
    if(imanoma($duomenys, $N, $K, $SubSetai))
    {
       // - jei taip
        ?> <br> 
            <?php
            printf("Masyvo padalinimas į mažesnių grupiu, kurių skaičius ");
            print_r($K);
            printf(" į lygias sumas yra įmanomas");
            // kvieciama funkcija nupaisyti gautus subsetus
            PrintSubset($SubSetai, $K, $N, $duomenys);
    }
    else
    { //jei ne
        ?> <br> 
            <?php
            printf("Masyvo padalinimas į mažesnių grupiu, kurių skaičius ");
            print_r($K);
            printf(" į lygias sumas yra neįmanomas");
            // metodas rasti subsetams, kai jie nera lygus
            RandameSuPaklaidomis($N, $K, $duomenys);
    }
    
    
}
?>







<?php
// funkcijos

    function RandameSuPaklaidomis($N, $K, $arr)
    {
       // counter - paklaidos dydis
        $counter = 0;
        
        while($counter != 3)
        {
            $counter++;
            $arr2 = $arr;
            // papildome masyva tiek kiek reikia vienetu
            for ($i = $N; $i < $N+$counter; $i++)
            {
                $arr2[$i] = 1;
            }
            $SubSetai = array_fill(0, $N+$counter, -1);
            
            // patikriname ar imanoma lygiai isdalinti skaiciu
    if(imanoma($arr2, $N+$counter, $K,  $SubSetai))
    {
       
        ?> <br> 
            <?php
            printf("Masyvo padalinimas į mažesnių grupiu, kurių skaičius ");
            print_r($K);
            printf(" į lygias sumas yra įmanomas pridėjus ");
            print_r($counter);
            print_r(" elementus(ą) po 1 į pradinį masyvą");
            PrintSubset($SubSetai, $K, $N, $arr2);
            break;
    }
    else
    {
        ?> <br> 
            <?php
            printf("Masyvo padalinimas į mažesnių grupiu, kurių skaičius ");
            print_r($K);
            printf(" į lygias sumas yra neimanomas net pridėjus ");
            print_r($counter);
            print_r(" elementus(ą) po 1 į pradinį masyvą");
    }
            
        }
    }
    //put your code here
    // metoda sugrazina true reiksme, jeigu masyvas gali buti padalintas į k subsetų
   
   function imanoma ($arr, $N, $K, &$subsetas)
    {
        // jeigu suma padalinus is subsetu skaiciaus turi liekana,
        // tada masyvo negalima padalinti į k dalių
        $sum = 0;
        for($j = 0; $j < $N; $j++)
            $sum += $arr[$j];
        if ($sum % $K != 0)
        {
            return false;
        }
        
        
        
        // randame kokia turi buti kiekvieno subseto suma
        $subsetasSUMA = $sum / $K;
        
        $subsetuSUMOS= array_fill(0, $K, 0);
        
        // ar paiimtas kintamasis
        $paiimta = array_fill(0, $N, false);
        
        // incinizuojame pirma elementa
        
        
        
        $subsetuSUMOS[0] = end($arr);
        $paiimta[$N-1]=true;
        $subsetas[$N-1]=0;
        
       
        
       
        
        // paleidzia rekursyvu metoda, kuris patikrina ar yra tvarka, kuria sudejus masyvo elementus
        // gaunamos lygios sumos, ir grazina masyva su N skaiciu,
        //  kuris zymi, kuriam subsetui tie skaiciai priklauso
        return SubSetuRadimas($arr, $subsetuSUMOS, $paiimta, $subsetasSUMA, $K, $N , 0, $N-1, $subsetas);
        

    }
    
        // Rekursyvus metodas atrasti ar yra budas sujungti K grupiu,
    // kad ju sumos butu vienodos, ir rasti kuriems jie subsetams priklauso
    // zymeklis zymi kuriame, subsete dirbame, indeksas is kurios vietos imame elementa
    function SubSetuRadimas($arr, $subsetuSUMOS, $paiimta, $subsetasSUMA, $K, $N, $zymeklis,
            $indeksas,  &$subsetas)
    {
       
       // tikriname ar subseto suma lygi tiksliniai sumai
        if($subsetuSUMOS[$zymeklis] == $subsetasSUMA)
        {
             /* current index (K - 2) represents (K - 1) subsets of equal 
            sum last partition will already remain with sum 'subset'*/
            
            if($zymeklis == $K - 2)
            {
                // isaugom paskutinio subseto reiksmes
                for ($i = 0; $i < $N; $i++) {
                    
                    if($paiimta[$i] == false)
                    {
                        echo $paiimta[$i];
                        $subsetas[$i] = $K - 1;
                    }
                } 
                return true;
            }
            return SubSetuRadimas($arr, $subsetuSUMOS, $paiimta, $subsetasSUMA, $K, $N, $zymeklis + 1,
                    $N-1, $subsetas);
        }
        
        for ($i = $indeksas; $i>=0; $i--){
            
            // jeigu paiimtas kintamasis, jo nelieciame
            if($paiimta[$i])
                continue;
            // sudedam laikinajajai sumai
            $LaikinaSuma = $subsetuSUMOS[$zymeklis] + $arr[$i];
           
            // patikriname ar laikina suma nera didesne uz tiksline suma
            if($LaikinaSuma <= $subsetasSUMA)
            {
                // atzymim paiemima
                $paiimta[$i] = true;
                // pridedam suma subsetui
                $subsetuSUMOS[$zymeklis] += $arr[$i];
                
                // keliaujam toliau
                $KitasElementas = SubSetuRadimas($arr, $subsetuSUMOS, $paiimta, $subsetasSUMA,
                    $K, $N, $zymeklis, $i-1, $subsetas);
            
                // griztam ir atsizymim grizima, is kur grizom
                $paiimta[$i] = false;
                $subsetas[$i] = $zymeklis;
                $subsetuSUMOS[$zymeklis] -= $arr[$i];
                // jeigu is piramides virsunes true, grazinam true reiksme
                if($KitasElementas)
                {
                    return true;
                }
            }
          
        }
        return false;
       
    }
    
    function PrintSubset($subset, $K, $N, $arr)
    {
      
// spaudinamas sumos ir lygybes
    
        for($i = 0; $i < $K; $i++)
        {
             ?> <br> 
            <?php
            $sum = 0;
            for($j = 0; $j < $N; $j++)
            {
                if($subset[$j] == $i)
                {
                    
                    if($sum == 0)
                    {
                        print_r($arr[$j]);
                        
                    }
                    else 
                    {
                        printf("+");
                        print_r($arr[$j]);
                    }
                    $sum += $arr[$j];
                }
            }
            printf("=");
            print_r($sum);
        }
        
    }

?>