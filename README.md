# Simple Staff for Genesis

WordPress plugin that adds a custom post type for staff.

## Description

This plugin registers a simple custom post type for staff. I wrote it for WordCamp Nashville 2014.

If your site is running a Genesis Framework child theme, this plugin includes a template for the archive page. If you're not running the Genesis Framework, you can create your own templates for these in your theme. If you don't like my templates, comment out lines 52 and 73 in simple-staff.php file. This will remove the style, script, and template loaded by the plugin.

Demo: http://milne.robincornettcreative.com/staff/

## Requirements
* WordPress 3.6, tested up to 3.9
* Genesis Framework (templates will not work with other themes)
* an HTML5 theme because I was too lazy to add XHTML support back in.

## Installation

### Upload

1. Download the latest tagged archive (choose the "zip" option).
2. Go to the __Plugins -> Add New__ screen and click the __Upload__ tab.
3. Upload the zipped archive directly.
4. Go to the Plugins screen and click __Activate__.

### Manual

1. Download the latest tagged archive (choose the "zip" option).
2. Unzip the archive.
3. Copy the folder to your `/wp-content/plugins/` directory.
4. Go to the Plugins screen and click __Activate__.

Check out the Codex for more information about [installing plugins manually](http://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation).

### Git

Using git, browse to your `/wp-content/plugins/` directory and clone this repository:

`git clone git@github.com:robincornett/simple-staff-genesis.git`

Then go to your Plugins screen and click __Activate__.

## Frequently Asked Questions

### Why did you make this?

I've used variations of this code in several iterations--doing it wrong (by hand), as part of a theme, and in plugins for clients. Since I'm using it as an example for WordCamp Nashville 2014, I'm writing it up as its own plugin.

## Credits

Built by [Robin Cornett](http://www.robincornett.com/)
and with help from [David Gale](http://davidsgale.com/)