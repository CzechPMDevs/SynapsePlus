# SynapsePlus [under development]

## 🔧 How it works:

![schema](https://i.ibb.co/rZGX77B/synapse.png)

Player is still connected to the nemisys server, then the packets are transferred to other servers. You need Synapse plugin because Nemisys uses own protcol and depends to comunicate with PocketMine servers through it. 

## 📁  Installation:

### Installing screen command (linux):
1) Run command `apt install screen`

### Nemisys installation (linux):
1) [Install java](https://java.com/en/download/help/linux_x64_install.xml) into your server
2) Create directory for your Nemisys server
3) Go to Nemisys directory and download latest nemisys jar from [jenkins](https://ci.nukkitx.com/job/NukkitX/job/Nemisys/job/master/lastSuccessfulBuild/artifact/target/nemisys-1.0-SNAPSHOT.jar)
4) create `start.sh` file inside Nemisys directory with following command:

 `#!/bin/sh`
 
 `java -Xms1G -Xmx1G -jar nemisys-1.0-SNAPSHOT.jar`
 
 5) In nemisys directory run command `chmod 777 ./start.sh`
 6) Start nemisys proxy using command `screen -S Nemisys ./start.sh`
- For returning to the server use `screen -r Nemisys`

### Nemisys installation (windows):
1) [Install java](https://www.java.com/en/download/)
2) Create directory for your Nemisys server
3) Download nemisys jar from [jenkins](https://ci.nukkitx.com/job/NukkitX/job/Nemisys/job/master/lastSuccessfulBuild/artifact/target/nemisys-1.0-SNAPSHOT.jar) and movi it to Nemisys directory
4) Go to Nemisys directory and create `start.cmd` file inside with following text:

`@echo off`

`java -Xms1G -Xmx1G -jar nemisys-1.0-SNAPSHOT.jar`

5) Run `start.cmd` script 

### SynapsePlus Installation
- Put SynapsePlus.phar to /plugins/ directory on every PocketMine server
- Plugin automatically downloads last stable build of SynapsePM plugin (is required to running SynapsePlus)

## 💰 Credits  

- Icon made by [Freepik](http://www.freepik.com/ "Freepik") from [www.flaticon.com](https://www.flaticon.com/ "Flaticon") is licensed by [CC 3.0 BY](http://creativecommons.org/licenses/by/3.0/ "Creative Commons BY 3.0")  
- Spawn built by FlammyNetwork's builder team  

##  💡 License  

Full license [here](https://github.com/CzechPMDevs/SynapsePlus/blob/master/LICENSE).
