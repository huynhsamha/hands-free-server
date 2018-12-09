# Hands-free Server
Assignment web (HCMUT) - PHP Server for Hands-free App

Website: http://hands-free.epizy.com

Admin Website: http://admin.hands-free.epizy.com

Client Repository: https://github.com/huynhsamha/hands-free-client

Admin Page Repository: https://github.com/DarrenNguyen159/hands-free-admin

## Database

## File structure

## Quickstart

## Config upload avatar

+ View file location:
```php
<?php
echo phpinfo();
?>
```
Search `php.ini` to get location -> open file and search file upload, set ON and set max size of uploaded file

+ Set permission
```bash
# Change owner to nobody
## Temp directory
sudo chown nobody /opt/lampp/temp
## Real directory
sudo chown nobody ./hands-free/uploads

# Add permission for writing to dir
sudo chmod 777 ./hands-free/uploads
```