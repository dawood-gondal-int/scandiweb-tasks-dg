# Task #2 - BE + FE

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

 - Run the command in terminal `php bin/magento scandiweb:color-change <color> <store_id>`
 - `color` will be in HEX format as requirement says. Additionally, I have provided possibility to provide
   color in 3-digit format as well.
 - Multiple store ids can be given comma separately like <store_id1>, <store_id2>, <store_id3>
 - Command will respond as failure in wrongly formatted color or wrong store ID is given.
 - After running command changes will reflect on storefront.
