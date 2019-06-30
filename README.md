### Description

Whenever you change some config value in admin panel, you get notification about invalidated cache types, so you need to open Cache management page, check invalidated cache types and click on submit button.

This extension adds direct link to perform this action within notification bar. See it in action below:

![demo](https://user-images.githubusercontent.com/511845/60393340-09f1bf00-9b14-11e9-873b-f8bf138fa1e8.gif)

### Installation

Execute this commands in order to install this extension:

`composer require brightlights/admincachemessage`

`bin/magento module:enable BrightLights_AdminCacheMessage`

`bin/magento setup:upgrade`
