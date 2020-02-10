<?php

class Ascii_Lentele
{
    
    private $stulpeliu_plociai = array();

   
    private $stulpeliu_tipai = array();

    
    private $lenteles_plotis = 0;

    
    public $error = '';

    // funkcija lenteles padarymui
    public function Lentele($array, $pavadinimas = '', $return = false, $autolygiavimas_langeliai = false)
    {
        
        $lentele = '';
        $this->stulpeliu_plociai = array();
        $this->stulpeliu_tipai = array();
        $this->lenteles_plotis = 0;

        // modifikuoti lentele, kad ji palaikytu bet koki linijos luzi, kuris gali egzistuoti
        $modifikuotas_masyvas = array();
        
        foreach ($array as $eilute => $eilutes_data) {
            
            // ilgiausio elemnento radymas
           
            $eilutes_masyvas = array();
            $ilgiausias_langelis = 1;
            foreach ($eilutes_data as $langelis => $langelio_verte) {
                $langelio_verte = explode("\n", $langelio_verte);
                $eilutes_masyvas[$langelis] = $langelio_verte;
                $ilgiausias_langelis = max($ilgiausias_langelis, count($langelio_verte));
            }
            

            // datos arba " " irasymas
            for ($i = 0; $i < $ilgiausias_langelis; $i++) {
                $nauja_eilute_laikina = array();
                foreach ($eilutes_masyvas as $stulpelis => $stulpelio_data) {
                    
                    if (isset($stulpelio_data[$i])) {
                        $nauja_eilute_laikina[$stulpelis] = trim($stulpelio_data[$i]);
                    } else {
                        $nauja_eilute_laikina[$stulpelis] = '';
                    }
                }
                $modifikuotas_masyvas[] = $nauja_eilute_laikina;
               
            }
            for ($i = 0; $i < $ilgiausias_langelis; $i++) 
            {
                $nauja_eilute_laikina = array();
            }
            
            
        }

        // modifikuota masyva priskiriam pagrindiniui
        $array = $modifikuotas_masyvas;

        // susivedame kintamuosius
        $this->gauti_stulpelio_plocius($array);
        $this->gauti_stulpelio_tipus($array);

        // lenteles pavadinimas
        if ($pavadinimas != '') {
            $this->gauti_Lentele_plotis();
            $lentele .= $this->Title($pavadinimas);
        }

      // jeigu tuscias masvyas nieko nerasom
        if (isset($array[0])) {
         
            // -----
            $lentele .= $this->Dalintojas();

           // anttrastes
            $lentele .= $this->Antrastes($autolygiavimas_langeliai);

            // ----
            $lentele .= $this->Dalintojas();

            // eilutes
            $lentele .= $this->Eilutes($array, $autolygiavimas_langeliai);

           // ----
            $lentele .= $this->Dalintojas();
        }

        
        if (is_string($return)) {
            $save = @file_put_contents($return, $lentele);
            if ($save) {

                return true;
            } else {
              
                $this->error = 'Unable to save lentele to "' . $return . '".';

                return false;
            }
        } else {
            
            if ($return) {

                return $lentele;
            } else {
                echo $lentele;
            }
        }
    }

    

   
 // sugrazina string ilgi
    private static function len($stulpelis_value)
    {
        return extension_loaded('mbstring') ? mb_strlen($stulpelis_value) : strlen($stulpelis_value);
    }

  // nustato stulpelio plocius
    private function gauti_stulpelio_plocius($array)
    {
       
        if (isset($array[0])) {
            foreach (array_keys($array[0]) as $stulpelis) {
                
                $this->stulpeliu_plociai[$stulpelis] = max(max(array_map(array($this, 'len'), $this->masyvoStulp($array, $stulpelis))), $this->len($stulpelis));
            }
        }
    }

   // nustato stulpelio tipus
    private function gauti_stulpelio_tipus($array)
    {
       
        if (isset($array[0])) {
            
            foreach (array_keys($array[0]) as $stulpelis) {
                foreach ($array as $i => $eilute) {
                    if (trim($eilute[$stulpelis]) != '') {
                        if (!isset($this->stulpeliu_tipai[$stulpelis])) {
                            $this->stulpeliu_tipai[$stulpelis] = is_numeric($eilute[$stulpelis]) ? 'numeric' : 'string';
                        } else {
                            if ($this->stulpeliu_tipai[$stulpelis] == 'numeric') {
                                $this->stulpeliu_tipai[$stulpelis] = is_numeric($eilute[$stulpelis]) ? 'numeric' : 'string';
                            }
                        }
                    }
                }
            }
        }
    }

    private function masyvoStulp($array, $stulpelis)
    {
        if (is_callable('array_column')) {
            $return = array_column($array, $stulpelis);
        } else {
            $return = array();
            foreach ($array as $n => $dat) {
                if (isset($dat[$stulpelis])) {
                    $return[] = $dat[$stulpelis];
                }
            }
        }

        return $return;
    }

    // nustatyti lentels ploti
    private function gauti_Lentele_plotis()
    {
        
        $this->lenteles_plotis = array_sum($this->stulpeliu_plociai);

        
        $this->lenteles_plotis += count($this->stulpeliu_plociai) * 2;

        
        $this->lenteles_plotis += count($this->stulpeliu_plociai) + 1;
    }

  // sukuria pavadinima
    private function Title($pavadinimas)
    {
        
        $pavadinimas = trim($pavadinimas);

       
        $left_padding = floor(($this->lenteles_plotis - $this->len($pavadinimas)) / 2);

        
        return str_repeat(' ', max($left_padding, 0)) . $pavadinimas . PHP_EOL;
    }

   
    private function Dalintojas()
    {
        
        $divider = '+';

        
        foreach ($this->stulpeliu_plociai as $stulpelis => $length) {
            $divider .= str_repeat('-', $length + 2) . '+';
        }

       
        return $divider . PHP_EOL;
    }

    
    private function Antrastes($autolygiavimas_langeliai)
    {
        
        $eilute = '|';

       
        foreach ($this->stulpeliu_plociai as $stulpelis => $length) {
            
            $alignment = $autolygiavimas_langeliai && isset($this->stulpeliu_tipai[$stulpelis]) && $this->stulpeliu_tipai[$stulpelis] == 'numeric' ? STR_PAD_LEFT : STR_PAD_RIGHT;
            $eilute .= ' ' . str_pad($stulpelis, $this->stulpeliu_plociai[$stulpelis], ' ', $alignment) . ' ';

            
            $eilute .= '|';
        }

       
        return $eilute . PHP_EOL;
    }

   
    private function Eilutes($array, $autolygiavimas_langeliai)
    {
        
        $eilutes = '';

        
        foreach ($array as $n => $data) {
          
            $eilutes .= '|';

           
            foreach ($data as $stulpelis => $value) {
                
                $alignment = $autolygiavimas_langeliai && isset($this->stulpeliu_tipai[$stulpelis]) && $this->stulpeliu_tipai[$stulpelis] == 'numeric' ? STR_PAD_LEFT : STR_PAD_RIGHT;
                $eilutes .= ' ' . str_pad($value, $this->stulpeliu_plociai[$stulpelis], ' ', $alignment) . ' ';

                
                $eilutes .= '|';
            }

           
            $eilutes .= PHP_EOL;
        }

        
        return $eilutes;
    }
}
