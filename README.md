# StatusColors
Adds colours to Magento Order Statuses, so that merchants can see at a glace what status an order is on. (Avaliable for Magento versions 1.6 upwards)

Compatibility
-------------
- Magento >= 1.6

Extension Overview
------------------
Modman: Yes

Composer: (Not Yes)

GitHub: Private

Core Hacks: 0

Class Rewrites: 0

Uninstallation
--------------
To uninstall this extension you need to run the following SQL after removing the extension files a list of which can be found in the modman file:
```sql
  ALTER TABLE `sales_order_status` DROP `color`;
```
Developer
--------------
James Anelay - TheExtensionLab

[http://www.theextensionlab.com](http://www.theextensionlab.com)

[@JamesAnelay](https://twitter.com/jamesanelay) - [@TheExtensionLab](https://twitter.com/TheExtensionLab)

Copyright
---------
(c) 2014 TheExtensionLab
