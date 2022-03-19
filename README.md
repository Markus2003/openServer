# openServer ![](https://img.shields.io/github/languages/code-size/Markus2003/openServer?style=for-the-badge) ![](https://img.shields.io/github/license/Markus2003/openserver?style=for-the-badge)
Do you want a Website for your Server to host your own Web Apps, Film, TV Series, Music and Personal File?<br>
Well, you are in the right place... but at the wrong time, in fact this is the `Pre-Release` version that you can test!
<br><br>

# Content
- [What is openServer](#what-is-openserver)
- [openServer development support](#openserver-development-support)
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
| OS | 64-bit | 32-bit | ARM |
|----|--------|--------|-----|
| Windows |  ✗  |  ✗  |  ✗  |
| Linux   |  ✓  |  ?   |  ✓  |
| macOS   |  ✗  |  ✗  |  ✗  |
##### Note that this is a `Pre-Release` version, so support is very limited!
<br><br>

## How do I install openServer on my machine?
##### For the moment I'm only supporting `Linux`, so if you have `Windows` you must wait (for `macOS` users: leave this Repo, I don't have enough money to buy Apple products)<br>
- First of all you must run this command to install `apache2`, `PHP` (with the relative dependencies) and `mariadb-server` (it will be necessary in future for user management):
```bash
sudo apt-get install apache2 php php-files php-zip mariadb-server -y
```
- (OPTIONAL) I strongly reccomend to install also `Cockpit` to manage remotely your server:
```bash
sudo apt-get install cockpit -Y
```
- Make your way to the Website folder and delete the `html` folder (it's useless):
```bash
cd /var/www/ && rm *
```
- Download `openServer` and extract it:
```bash
wget https://github.com/Markus2003/openServer/archive/refs/heads/main.zip && unzip main.zip && rm main.zip && mv openServer-main html
```
- Edit your `php.ini` to grant app upload (`php.ini` path may change depending on the system):
```bash
sudo nano /etc/php/7.4/apache2/php.ini
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
<br><br>

# Changelog
Here we are with the `Hello, GitHub!` version (formally `ALPHA-0.0.1`)<br>
## Features
- Sidebar to switch quicly through Server Sections
- `Applications` Section ready for use
- App Installation and Uninstallation from the `Applications` Section
## Some Bugs
- App extraction and download not ready yet
- Other Sections are not ready yet
- User management not implemented
- `Personal Vault` not implemented
- Some visual bugs
- Mobile version not implemented
<br><br>

# Upcoming Features
- App extraction and download from `Applications` Section
- Improvement to the `CSS`
- A Repo hosting some App for the Server
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