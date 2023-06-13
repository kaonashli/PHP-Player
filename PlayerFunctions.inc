<?php
function isFieldEmpty($field){
    $field = trim($field);
    return (strlen($field) === 0);
}
function validateFields($field, $regex){
    return (preg_match($regex, $field) >0);
}
function confirmPassword($password1, $password2){
    return (strcmp($password1, $password2) === 0);
}
function savePlayerInfo($info){
    $textFile = fopen("players", "a+") or die("Unable to create file");
    fwrite($textFile, $info);
    fclose($textFile);
}
?>