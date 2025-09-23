BNI Widgets - Quick Guide
-------------------------

Installation:
1. Upload the ZIP via WordPress Dashboard -> Plugins -> Add New -> Upload Plugin.
2. Activate the plugin.
3. Make sure Elementor is installed and active.

How to add new widget:
- Create a new PHP file in the /widgets folder. Filename should be like: my-custom-widget.php
- Class name will be auto-detected using the filename and must follow pattern: BNI_My_Custom_Widget
  (underscores and dashes in filename will be converted to StudlyCase)

Example filename -> class:
hero-widget.php    -> BNI_Hero_Widget
special_service.php -> BNI_Special_Service

Inside your widget file extend \Elementor\Widget_Base and register controls & render output.

This plugin auto-scans the widgets folder and registers all PHP files as Elementor widgets.
