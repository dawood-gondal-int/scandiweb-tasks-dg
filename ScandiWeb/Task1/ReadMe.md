# Task #1 - Only BE

 - Development OS: Linux
 - Installed Magento version: 2.4.6 Community Edition with sample data
 - PHP version: 8.1
 - Composer version: 2.2


### Process of Installation

Download the code from GitHub place it under app/code directory of magento. 
After this run the commands to install the module. Vendor folder will be SandiWeb

```sh
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy -f
php bin/magento cache:flush
```

### See Results

 - Open any of the cms page. 
 - Open inspect which `Ctrl + Shift + I` or right click and select inspect from the menu.
 - Search for alternate or open head tag there will be tag with store language and base url of store.
