<?php

namespace many1337;
 
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\Server;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerExhaustEvent;
use pocketmine\event\player\PlayerItemConsumeEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\entity\ProjectileHitEvent;
use pocketmine\event\entity\ProjectileLaunchEvent;
use pocketmine\network\mcpe\protocol\ChangeDimensionPacket;
use pocketmine\network\mcpe\protocol\types\DimensionIds;
use pocketmine\event\Listeners;
use pocketmine\utils\TextFormat;
use pocketmine\scheduler\Task;
use pocketmine\level\Level;
use many1337\task\GuardianTask;


class Main extends PluginBase implements Listener
{

    public function onEnable() {
        @mkdir($this->getDataFolder());
        $this->saveResource("config.yml");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $pri = $this->getServer()->getPluginManager()->getPlugin("ProfileUI");
        if($api === null){
            $this->getServer()->getLogger()->notice("[LobbyCore] Please use a FormAPI plugin!");
        }
    }

    public function onDisable()
    {
        foreach ($this->getServer()->getOnlinePlayers() as $p) {
            $p->transfer("80.99.208.62", "1941");
        }
    }

    public function onJoin(PlayerJoinEvent $event){

        $player = $event->getPlayer();
        $name = $player->getName();
        $this->Main($player);
        $this->getScheduler()->scheduleDelayedTask(new GuardianTask($this, $player), 45);

    }

    public function onQuit(PlayerQuitEvent $event)
    {

        $player = $event->getPlayer();
        $name = $player->getName();

    }

    public function Main(Player $player)
    {
        $player->getInventory()->setItem(8, Item::get(399)->setCustomName(TextFormat::BLUE . "TutorialUI"));
	    $player->getInventory()->setItem(7, Item::get(372)->setCustomName(TextFormat::GOLD . "MinesUI"));
        $player->getInventory()->setItem(6, Item::get(280)->setCustomName(TextFormat::GREEN . "SellInv"));

    }
    public function onInteract(PlayerInteractEvent $event)
    {
        $player = $event->getPlayer();
        $item = $player->getInventory()->getItemInHand();
        $cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        $game1 = $cfg->get("Game-1-Name");
        $game2 = $cfg->get("Game-2-Name");
        $game3 = $cfg->get("Game-3-Name");
        $game4 = $cfg->get("Game-4-Name");
        $game5 = $cfg->get("Game-5-Name");

        if ($item->getCustomName() == TextFormat::BLUE . "TutorialUI") {
            $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
            $form = $api->createSimpleForm(function (Player $sender, $data){
                $result = $data;
                if($result != null) {
                }
                switch ($result) {
                    case 0;
            		$player->addTitle("§aOpening Menu");
            		$this->getServer()->dispatchCommand($player, "tutorial");
                        break;
                    case 1;
                        $sender->sendMessage("§cMenu has been closed.");
                }
            });
            $form->setTitle("§6Tutorial Menu");
            $form->setContent("§bOpen TutorialUI§r");
            $form->addbutton("§aOpen", 0);
            $form->addButton("§cEXIT", 1);
            $form->sendToPlayer($player);
        }

        if ($item->getCustomName() == TextFormat::BLUE . "MinesUI") {
            $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
            $form = $api->createSimpleForm(function (Player $sender, $data){
                $result = $data;
                if($result != null) {
                }
                switch ($result) {
                    case 0;
            		$player->addTitle("§aOpening Menu");
            		$this->getServer()->dispatchCommand($player, "mines");
                        break;
                    case 1;
                        $sender->sendMessage("§cMenu has been closed.");
                }
            });
            $form->setTitle("§6Mines Menu");
            $form->setContent("§bOpen MinesUI§r");
            $form->addbutton("§aOpen", 0);
            $form->addButton("§cEXIT", 1);
            $form->sendToPlayer($player);
        }

        if ($item->getCustomName() == TextFormat::BLUE . "SellInv") {
            $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
            $form = $api->createSimpleForm(function (Player $sender, $data){
                $result = $data;
                if($result != null) {
                }
                switch ($result) {
                    case 0;
            		$player->addTitle("§aOpening Menu");
            		$this->getServer()->dispatchCommand($player, "sellinv");
                        break;
                    case 1;
                        $sender->sendMessage("§cMenu has been closed.");
                }
            });
            $form->setTitle("§6SellAll Menu");
            $form->setContent("§bSell Your Inventory§r");
            $form->addbutton("§aSellInv", 0);
            $form->addButton("§cEXIT", 1);
            $form->sendToPlayer($player);
        }
    }
