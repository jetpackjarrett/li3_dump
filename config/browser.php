<?php
use lithium\data\Connections;
use lithium\analysis\Logger;
use li3_debug\util\Debug;

Logger::config(array(
    'default' => array('adapter' => 'File')
));

// Filter mongo queries to console
if (isset($_SERVER['HTTP_USER_AGENT'])) {
    $Mongo = Connections::get('default');
    $Mongo->applyFilter('read', function($self, $params, $chain) use (&$Mongo) {
        $result = $chain->next($self, $params, $chain);

        if (method_exists($result, 'data')) {
            Debug::console(array_filter($params['query']->export($Mongo))
                         + array_filter(array('result' => $result->data())));
        }

        return $result;
    });
}

?>