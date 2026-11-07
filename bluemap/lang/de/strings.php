<?php

return [
    'navigation' => 'Karte',
    'title' => 'BlueMap',
    'no_allocation_title' => 'Keine Allocation für den BlueMap-Port',
    'no_allocation' => 'Dieser Server hat keine Allocation mit dem Port :port (gelesen aus der BlueMap-webserver.conf, Standard 8100). Lege eine Allocation mit diesem Port an oder ändere den Port in plugins/BlueMap/webserver.conf (bei Fabric/Forge config/bluemap/webserver.conf) auf eine Allocation dieses Servers und starte den Server neu. Das erste Rendern einer großen Welt kann Stunden dauern.',
    'unreachable' => 'Das Panel konnte den BlueMap-Webserver nicht erreichen. Prüfe, ob BlueMap läuft und ob das Panel den BlueMap-Port erreichen kann.',
    'use_alias' => 'Alias verwenden',
    'use_alias_hint' => 'Verbindet sich mit dem Alias der Allocation statt mit der IP-Adresse. Hat eine Allocation keinen Alias, wird ihre IP-Adresse genutzt.',
    'notifications' => [
        'settings_saved' => 'Einstellungen gespeichert',
    ],
];
