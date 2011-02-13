<?php
use lithium\data\Connections;
use lithium\analysis\Logger;
use li3_dump\util\Dump;

Logger::config(array(
    'default' => array('adapter' => 'File')
));

// Filter mongo queries to console
if (isset($_SERVER['HTTP_USER_AGENT'])) {
    $db = Connections::get('default');
    $db->applyFilter('read', function($self, $params, $chain) use (&$db) {
        $result = $chain->next($self, $params, $chain);

        if (method_exists($result, 'data')) {
            Dump::console(array_filter($params['query']->export($db))
                         + array_filter(array('result' => $result->data())));
        }

        return $result;
    });
}

?>