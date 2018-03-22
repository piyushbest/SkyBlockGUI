<?php

namespace SkyBlock;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\{command\ConsoleCommandSender, Server, Player, utils\TextFormat};
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener{

    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info("SkyBlockUI Enabled!\n\nThis plugin made by CrazyTeamVN");
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
        $player = $sender->getPlayer();
        switch($command->getName()){
            case "skyblockui":
            case "sbui":
                $this->menuForm($player);
        }
        return true;
    }

    public function menuForm(Player $player){
        if($player instanceof Player){
            $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
            $form = $api->createSimpleForm(function (Player $sender, array $data){
                if(isset($data[0])){
                    switch($data[0]){
                        case 0:
                            //Back to Home 1
                        $this->getServer()->getCommandMap()->dispatch($sender, "sb home 1");
                            break;
                        case 1:
                            //Back to Home 2
                        $this->getServer()->getCommandMap()->dispatch($sender, "sb home 2");
                            break;
                        case 2:
                            //Claim Island
                        $this->getServer()->getCommandMap()->dispatch($sender, "sb claim");
                            break;
                        case 3:
                            //Addhelper
                            $this->addhelperForm($sender);
                            break;
                        case 4:
                            $this->removehelperForm($sender);
                            break;
                        case 5:
                            //Give Island to a Player
                            $this->giveForm($sender);
                        case 6:
                            //Warp to an island
                            $this->warpForm($sender);
                        case 7:
                            //Info of island player standing on
                            $this->getServer()->getCommandMap()->dispatch($sender, "sb info");
                        case 8:
                            //Exit
                            break;
                    }
                }
            });
            $form->setTitle("§d§l-==§r§o§eElite§bKnight•§cSkyBlock§r§d§l==-§r");
            $form->setContent("§aPlease choose an action to use!");
            $form->addButton("§a§oHome 1");
            $form->addButton("§a§oHome 2");
            $form->addButton("§a§oClaim");
            $form->addButton("§a§oAdd Helper");
            $form->addButton("§a§oRemove Helper");
            $form->addbutton("§a§oGive");
            $form->addbutton("§a§oWarp");
            $form->addbutton("§a§oInfo");
            $form->addButton(TextFormat::RED . "§cExit");
            $form->sendToPlayer($player);
        }
    }
    

   

    public function addhelperForm(Player $player){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createCustomForm(function (Player $event, array $data){
            $player = $event->getPlayer();
            $result = $data[0];
            if($result != null){
                $this->playerName = $result;
                $this->getServer()->getCommandMap()->dispatch($player, "sb addhelper " . $this->playerName);
            }
        });
        $form->setTitle(TextFormat::GREEN . "Add Helper");
        $form->addInput("§bEnter Player Name");
        $form->sendToPlayer($player);
    }

    public function removehelperForm(Player $player){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createCustomForm(function (Player $event, array $data){
            $player = $event->getPlayer();
            $result = $data[0];
            if($result != null){
                $this->playerName = $result;
                $this->getServer()->getCommandMap()->dispatch($player, "sb remove " . $this->playerName);
            }
        });
        $form->setTitle(TextFormat::GREEN . "Remove Helper");
        $form->addInput("§bEnter Player Name");
        $form->sendToPlayer($player);
    }

    public function giveForm(Player $player){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createCustomForm(function (Player $event, array $data){
            $player = $event->getPlayer();
            $result = $data[0];
            if($result != null){
                $this->playerName = $result;
                $this->getServer()->getCommandMap()->dispatch($player, "sb give " . $this->playerName);
            }
        });
        $form->setTitle(TextFormat::GREEN . "Give");
        $form->addInput("§bEnter Player Name");
        $form->sendToPlayer($player);
    }

    public function warpForm(Player $player){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createCustomForm(function (Player $event, array $data){
            $player = $event->getPlayer();
            $result = $data[0];
            if($result != null){
                $this->island = $result;
                $this->getServer()->getCommandMap()->dispatch($player, "sb warp " . $this->island);
            }
        });
        $form->setTitle(TextFormat::GREEN . "Warp");
        $form->addInput("§bEnter Island Id");
        $form->sendToPlayer($player);
    }
}
