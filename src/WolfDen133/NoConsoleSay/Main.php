<?php

/**
 * @author WolfDen133 & Erosion
 * @version 2.0.0
 */

namespace WolfDen133\NoConsoleSay;

use pocketmine\command\Command;
use pocketmine\console\ConsoleCommandSender;
use pocketmine\event\Listener;
use pocketmine\event\server\CommandEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class Main extends PluginBase implements Listener {

    public function onEnable() :void
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onCommandEvent (CommandEvent $event)
    {
        if ($event->getSender() instanceof ConsoleCommandSender) {
            $cm = [];

            foreach ($this->getServer()->getCommandMap()->getCommands() as $command) {
                array_push($cm, $command->getName());
            }

            if (!array_search(explode(" ", $event->getCommand())[0], $cm)) {

                $event->cancel();

                if ($this->getServer()->getCommandMap()->getCommand("say") instanceof Command) {
                    $this->getServer()->dispatchCommand(new ConsoleCommandSender($this->getServer(), $this->getServer()->getLanguage()), "say " . $event->getCommand());
                    return;
                }

                $this->getServer()->broadcastMessage(TextFormat::LIGHT_PURPLE . "[Server] " . $event->getCommand());
            }

        }
    }
}
