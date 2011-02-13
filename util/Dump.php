<?php
/**
 * Dump.php
 *
 */
namespace li3_dump\util;

use lithium\core\Environment;
use lithium\template\View;

class Dump {

    static public $console = array();

    static public function dump($data = null, $label = false) {
        if (Environment::get() === 'development') {
            echo '<pre class="debug">';
            echo ($label) ? '<h3>' . $label . '</h3>' : '';
            echo var_dump($data);// Intentional var_dump
            echo '</pre>';
        }
    }

    static public function console($data = false) {
        if ($data) {
            if (Environment::get() === 'development') {
                $view   = new View(array('loader' => 'Simple', 'renderer' => 'Simple'));
                $script = $view->render(array(
                    'element' => '<script type="text/javascript">console.info({:data});</script>'),
                    array('data' => json_encode($data))
                ));
                Dump::$console[] = $script;
            }

            return;
        }

        return implode('', Dump::$console);
    }
}

?>