<?php 

if (!function_exists('get_words')) {
    function get_words($string = ""){
        $words = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $char = $string[$i];
            if (ctype_alpha($char)) {
                $words .= $char;
            }
        }
        return $words;
    }
}
//NORMALIZAR FECHA
if (!function_exists('get_date')) {
    function get_date($stringDate = ""){
        $stringDate = str_replace("/", ".", $stringDate);
        $stringDate = str_replace("-", ".", $stringDate);
        $valFormat = substr($stringDate, 0, 4);
        if ($valFormat > 2000) {
            $stringDate = explode(".", $stringDate);
            $stringDate = $stringDate[2].".".$stringDate[1].".".$stringDate[0]; // day . month . year
        }
        $stringDate = date("Y-m-d", strtotime($stringDate));
        $valFormat = substr($stringDate, 0, 4);
        // if ($valFormat < 2000) {
        //     return null;
        // }
        return $stringDate;
    }
}
//NORMALIZAR PO
if (!function_exists('get_phrase')) {
    function get_phrase($phrase = "",$notEmpty = false){
        $phrase = strtoupper($phrase);
        $phrase = trim($phrase," \t\n\r\0\x0B\xa0");
        if ($notEmpty) {
            $phrase=preg_replace('/\s\s+/','',$phrase);
        }
        $phrase= str_replace(",",".",$phrase);
        $phrase= str_replace("/","",$phrase);
        $phrase= str_replace("-","",$phrase);
        $phrase=str_replace("'","",$phrase);
        return $phrase;
    }
}

// Funcines Numericas
if (!function_exists('amountToText')) {
    function amountToText($amount)
    {
        $intPart = floor($amount);
        $decimalPart = round(($amount - $intPart) * 100);

        $integerFormatter = new \NumberFormatter(config('app.locale'), \NumberFormatter::SPELLOUT);
        $decimalFormatter = new \NumberFormatter(config('app.locale'), \NumberFormatter::SPELLOUT);

        $intPartText = ucfirst($integerFormatter->format($intPart));
        $intPartText = strtoupper($intPartText);

        if ($decimalPart > 0) {
            $decimalPartText = $decimalFormatter->format($decimalPart);
            $decimalPartText = str_pad($decimalPartText, 2, '0', STR_PAD_LEFT); // Add leading zero if necessary
            $decimalPartText = strtoupper($decimalPartText);
            $amountText = $intPartText . ' DOLLARS ' . $decimalPartText . '/100 USD';
        } else {
            $amountText = $intPartText . ' DOLLARS ' . '00/100 USD';
        }

        return $amountText;
    }
}

if (!function_exists('convertAndRound')) {
    function convertAndRound($numberString) {
        $floatNumber = floatval(str_replace(array("$", ","), "", $numberString));
        $nearestInteger = round($floatNumber);
        
        return $nearestInteger;
    }
}