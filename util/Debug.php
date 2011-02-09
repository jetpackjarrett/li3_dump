<?php
/**
 * Debug.php
 *
 */
namespace li3_debug\util;

use lithium\core\Environment;
use lithium\template\View;

class Debug {

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
                    'element' => '<script type="text/javascript">console.info({:json});</script>'),
                    array('json' => json_encode($data)
                ));
                Debug::$console[] = $script;
            }

            return;
        }

        return implode('', Debug::$console);
    }
}

?>