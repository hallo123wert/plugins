# BlueMap – Pelican Plugin

Shows the [BlueMap](https://github.com/BlueMap-Minecraft/BlueMap) web map of a Minecraft server directly inside the server panel.

## Requirements

- BlueMap installed on the Minecraft server and started once, so `webserver.conf` exists.
- An allocation on the server for the port from `webserver.conf`. Do not use the game port.
- The panel must be able to connect to that port on the node.

## Settings

- **Use alias** – by default the panel connects to the IP of the allocation. When enabled, it uses the alias of the allocation instead; allocations without an alias still use their IP.

## Port

There is no global port setting. For every server the plugin reads the `port:` line from BlueMap's `webserver.conf` (`plugins/BlueMap/` on Paper/Spigot/Sponge, `config/bluemap/` on Fabric/Forge) and uses the allocation of that server with the same port. If the line is commented out, BlueMap's default `8100` is used.
