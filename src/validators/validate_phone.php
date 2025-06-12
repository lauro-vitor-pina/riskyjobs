<?php

function validate_phone(string $phone)
{
    $regex = '/^\(?[2-9]\d{2}\)?-\d{3}-\d{4}$/';
    
    return preg_match($regex, $phone);
}
