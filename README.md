# StatusColors

[![Build Status](https://travis-ci.org/TheExtensionLab/StatusColors.svg?branch=master)](https://travis-ci.org/TheExtensionLab/StatusColors)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/TheExtensionLab/StatusColors/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/TheExtensionLab/StatusColors/?branch=master)
[![Join the chat at https://gitter.im/TheExtensionLab/StatusColors](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/TheExtensionLab/StatusColors?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

Adds colours to Magento Order Statuses, so that merchants can see at a glace what status an order is on. (Avaliable for Magento versions 1.6 upwards)

Installation & Configuration
------------------
For up to date installation & configuration instructions please check out the documentation at 
[http://docs.theextensionlab.com/status-colors/installation.html](http://docs.theextensionlab.com/status-colors/installation.html)

Compatibility
-------------
- Magento >= 1.6

Extension Overview
------------------
Modman: Yes

Composer: Yes

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
