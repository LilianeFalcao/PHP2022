<?php
spl_autoload_extensions(".php");
function classLoader($class)
{
    $nomeArq = $class . ".php";
    $pastas = array(
        "shared/controller",
        "shared/model",
        "restrict/controller",
        "restrict/model"
    );
    foreach ($pastas as $pastas) {
            $arquivo = "{$pastas}/{$nomeArq}";
        if (file_exists($arquivo)) {
            require_once $arquivo;
        }
    }
}
spl_autoload_register("classLoader");
Session::startSession();
if (!Session::getValue("id")) {
    header("Location:" . Aplicacao::$path . "/");
}

class Aplicacao
{
    static public $path = "/lilianeF";
    static private $uri = "/lilianeF/restrita.php";
    public static function run()
    {
        $layout = new Template("restrict/view/layout.html");
        $layout->set("uri", self::$uri);
        $layout->set('path', self::$path);
        if (isset($_GET["class"])) {
            $class = $_GET["class"];
        } else {
            $class = "Inicio";
        }
        if (isset($_GET["method"])) {
            $method = $_GET["method"];
        } else {
            $method = "";
        }
        if (class_exists($class)) {
            $pagina = new $class;
            if (method_exists($pagina, $method)) {
                $pagina->$method();
            } else {
                $pagina->controller();
            }
            $layout->set("conteudo", $pagina->getMessage());
        }
        $layout->set("nome", Session::getValue("nome"));
        echo $layout->saida();
    }
}
Aplicacao::run();
