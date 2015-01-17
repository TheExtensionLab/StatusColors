# StatusColors
Adds colours to Magento Statuses.

Compatibility
-------------
- Magento >= 1.6

Uninstallation
--------------
To uninstall this extension you need to run the following SQL after removing the extension files a list of which can be found in the modman file:
```sql
  ALTER TABLE `sales_order_status` DROP `color`;
```
Developer
--------------
James Anelay - TheExtensionLab
http://www.theextensionlab.com
@JamesAnelay - @TheExtensionLab
