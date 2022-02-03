<?php 

    /**
     * 
     *Creates an array for sql insert like ['sis', string, int, string]
     * @param array  
     * @return array 
     */
function createParams($assoc){
    $strParams = "";
    $vals = [];
    foreach($assoc as $key => $val){
        if(gettype($val) === 'integer'){
            $strParams .= "i";
        }
        else if(gettype($val) === 'string'){
            $strParams .= "s";
        }

        array_push($vals, $val);
    }
    return [$strParams, ...$vals];
}

    /**
     * 
     * Creates a string of ? to easily dynamically query db
     * @param array  
     * @return string 
     */
function createPlaceholders($arr){
    $placeholders = [];
    foreach($arr as $val){
        array_push($placeholders, "?");
    }
    return join(", ", $placeholders);
}


?>