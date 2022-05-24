<?php
spl_autoload_extensions(".php");
function classLoader($class) {
$nomeArq = $class . ".php";
$pastas = array(
    "shared/controller",
    "shared/model",
    "restrict/controller",
    "restrict/model"
);
foreach ($pastas as $pastas){
    $arquivo
}
}