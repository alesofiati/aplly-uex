<?php

/**
 * Remove qualquer caracter da string deixando apenas números
 *
 * @param string $value
 * @return string
 */
function onlyNumbers(string $value): string
{
    return preg_replace('/[^0-9]/i', '', $value);
}

function maskInput($type, $value): string
{
    switch($type){
        case "cpf":
            return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{3})([0-9]{2})/i", "$1.$2.$3-$4", $value);
        break;

        case "phone_number":
            return preg_replace('/([0-9]{2})([0-9]{4,5})([0-9]{4})/i', '($1) $2-$3', $value);
        break;

        default:
            return $value;
        break;
    }
}