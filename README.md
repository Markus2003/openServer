# openServer ![](https://img.shields.io/github/languages/code-size/Markus2003/openServer?style=for-the-badge) ![](https://img.shields.io/github/license/Markus2003/openserver?style=for-the-badge)
Do you want a Website for your Server to host your own Web Apps, Film, TV Series, Music and Personal File?<br>
Well, you are in the right place!
<br><br>

# Content
- [What is openServer](#what-is-openserver)
- [openServer development support](#openserver-development-support)
- [How do I update openServer?](#how-do-i-update-openserver)
    - [The Modern Way](#the-modern-way)
    - [The Deprecated Way](#the-deprecated-way)
- [How do I install openServer on my machine?](#how-do-i-install-openserver-on-my-machine)
- [Changelog](#changelog)
- [Upcoming Features](#upcoming-features)
- [Disclaimer](#disclaimer)
- [License](#license)
- [Credit](#credit)
<br><br>

## What is openServer?
`openServer` is a Website written in PHP where you can develop your own Web Apps or Websites, even upload your Film, TV Series, Music and Personal Files with the built-in `Personal Vault` and the special Server Web App to read directly from the Server your files (without downloading anything!).
<br><br>

## openServer development support
### Server Side:
| OS | 64-bit | 32-bit | ARM |
|----|--------|--------|-----|
| Windows |  ?  |  ?  |  ?  |
| Linux   |  ✓  |  ?   |  ✓  |
<br>

### Client Side:
| Browser | Any Platform |
|---------|--------------|
| Chrome  |    >=100     |
| Firefox |    >=100     |
| Edge    |    >=100     |
| Opera   |    >=90      |

<br><br>

## How do I update openServer?
### The modern Way:
From version `BETA-0.5.9` you can update by selecting your favourite `Release Channel` (`ALPHA`, `BETA`, `STABLE`), to do so:
- Log-In as Administrator on openServer
- Go to the `Account Manager` page and click the `Go To Administration Page` button
- Now click on `Server Updater` Section
- Change the `Release Channel` if the default option doesn't fit your needs
- Click `Check Update Availability` button and follow the instructions
- Done, you are now running the latest version of openServer!
<br><br>

### The Deprecated Way:
If you have installed version `BETA-0.5.6` or newer, you can easily update to the latest version by following the instructions below:
- Log-In as Administrator on openServer
- Go to the `Account Manager` page and click the `Go To Administration Page` button
- Now click on `Server Updater` Section
- Click `Check Update Availability` button and follow the instructions
- Done, you are now running the latest version of openServer!
<br><br>

## How do I install openServer on my machine?
##### For the moment I'm only supporting `Linux`, so if you have `Windows` you must wait<br>
- First of all you must run this command to install `apache2`, `PHP` and the relative modules:
```bash
sudo apt-get install apache2 php8.1 mariadb-server php8.1-mbstring php8.1-mysql php8.1-xml php8.1-zip -y
```
- (OPTIONAL) I strongly reccomend to install also `Cockpit` to manage remotely your server:
```bash
sudo apt-get install cockpit -Y
```
- Make your way to the Website folder and delete the `html` folder (it's useless):
```bash
cd /var/www/html/ && rm ./*
```
- Download `openServer` and extract it:
```bash
wget https://github.com/Markus2003/openServer/releases/download/1.0.1/1.0.1.zip && unzip 1.0.1.zip && rm 1.0.1.zip
```
- Edit your `php.ini` to grant app upload (`php.ini` path may change depending on the system):
```bash
sudo nano /etc/php/8.1/apache2/php.ini
```
- Make the necessary modifications, then save and exit:
```bash
#Change line with post_max_size to
post_max_size = 0

#Change line with file_uploads to
file_uploads = On

#Change line with upload_max_filesize to
upload_max_filesize = 0
```

- Now restart `apache2` service:
```bash
sudo systemctl restart apache2
```

- Standardize permissions to Website folder (change <username> with your real username on the machine):
```bash
sudo chmod 777 -R /var/www/html
sudo chown <username>:<username> -R /var/www/html
```

- DONE!
##### If you can't install app on the server try to execute again the last commands
##### If some command don't work try to carefully add `sudo`
<br><br>

# Changelog
Here we are with the `A little Patch...` version (formally `STABLE-1.0.1`)<br>
## Features

- Patch for Version `1.0.0`
- `Share` in Personal Vault is now working...
- Now to display the `Folder`/`File` Size you must click a button that replace the past label (this will speed-up things on less powerfull systems...)
- `Personal Vault Size` (in the `Account Page`) and `Space Used by openServer` (in `Server Updater`) is now calculated asynchronously


## Some Bugs
- Some visual bugs
<br><br>

# Upcoming Features
- App extraction and download from `Applications` Section
- A Repo hosting some App for the Server
- Enable all Sections in the Admin Application
- A pratical Installer written in `Bash` for Linux
- Many others...
<br><br>

# Disclaimer
I am **not** responsible for any damage or data steal caused to your machine by using this `openServer`.<br>
**You** choose to download and use `openServer` at your own risk.
<br><br>

# License
This project use the [GNU GPLv3](LICENSE) license.
<br><br>

# Credit
Made with :heart: by [Markus2003](https://github.com/Markus2003)
