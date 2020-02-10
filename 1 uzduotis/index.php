<?php


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('./ascii_lentele.php');
$ascii_lentele = new ascii_Lentele();
$duomenys = array(
    array(
        'Name' => 'Trikse',
        'Color' => 'Green',
        'Element' => 'Earth',
        'Likes' => 'Flowers'
        ),
    array(
        'Name' => 'Vardenis',
        'Element' => 'Air',
        'Likes' => 'Singning',
        'Color' => 'Blue'
        ),  
    array(
        'Element' => 'Water',
        'Likes' => 'Dancing',
        'Name' => 'Jonas',
        'Color' => 'Pink'
        )
);
// sutvarkome duota masyva
$fixarr = TvarkytiMasyva($duomenys);

// susiradau ascii klasę githube, ją besitikrindamas perrašiau
$lentele = $ascii_lentele->Lentele($fixarr,'Rezultatai',true);
printf($lentele);

// funkcija sutvarkyti duotam masyvui
function TvarkytiMasyva($duomenys)
{
for ($i = 0; $i < sizeof($duomenys); $i++) {
    
    $fixarr[$i] = array (
    'Name' => $duomenys[$i]['Name'],
    'Color' => $duomenys[$i]['Color'],
    'Element' =>$duomenys[$i]['Element'],
    'Likes' => $duomenys[$i]['Likes']
    );
            
}
return $fixarr;
}