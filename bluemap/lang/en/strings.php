<?php

return [
    'navigation' => 'Map',
    'title' => 'BlueMap',
    'no_allocation_title' => 'No allocation for the BlueMap port',
    'no_allocation' => 'This server has no allocation with port :port (read from the BlueMap webserver.conf, default 8100). Create an allocation with this port, or change the port in plugins/BlueMap/webserver.conf (config/bluemap/webserver.conf on Fabric/Forge) to one of the allocations of this server, and restart the server. The first render of a large world can take hours.',
    'unreachable' => 'The panel could not reach the BlueMap webserver. Check that BlueMap is running and that the panel can connect to the BlueMap port.',
    'use_alias' => 'Use alias',
    'use_alias_hint' => 'Connect to the alias of the allocation instead of its IP address. If an allocation has no alias, its IP address is used.',
    'notifications' => [
        'settings_saved' => 'Settings saved',
    ],
];
