# Custom Taxonomies for Blocks
Contributors: taupecat, taupecatstudios
Tags: custom-taxonomies, gutenberg, block-editor
Requires at least: 4.7
Tested up to: 5.3
Stable tag: 1.0.0
Requires PHP: 5.6
License: MIT
License URI: https://opensource.org/licenses/MIT

WordPress plugin to convert older custom taxonomies so they can be used in the WordPress blocks interface (a.k.a. Gutenberg).

## Description

Custom taxonomies that were developed prior to the release of WordPress 5.0 (the Gutenberg release) may not be compatible with the WordPress block editor.

Custom taxonomies require that the "show_in_rest" property be set to "true" in order to work with the block editor. "show_in_rest" was added with WordPress 4.7 and the integration of the WordPress JSON REST API. Sites using custom taxonomies that were created prior to this likely do not have this property set. Additionally, the default value for "show_in_rest" is _"false"_ (this is poorly documented), ergo older custom taxonomies will not appear in the WordPress block editor interface.

This plugin will take any custom taxonomy where the "show_in_rest" feature is set to "false" and change it to "true". It will _not_ add any additional REST properties, such as "rest_base" or "rest_controller_class". If you need those properties set for any reason, you will need to update your custom taxonomy where it is being registered.

## Installation

1. Upload the plugin to the `/wp-content/plugins` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress

## Frequently Asked Questions

### What does this plugin _do_, exactly?

This plugin will go through _every_ registered custom taxonomy (any taxonomy that isn't registered in `wp-includes/taxonomy.php`) and change the "show_in_rest" property from false to true. Doing so will enable older custom taxonomies to be accessed in the WordPress block editor.

### Are there any settings for this plugin?

Not at present, but a later version of this plugin will allow site administrators to choose which custom taxonomies they want to enable for the block editor interface.

### Does this plugin work with the Classic Editor plugin?

Since the [Classic Editor](https://wordpress.org/plugins/classic-editor/) plugin disables the WordPress block editor completely, there is no need for this plugin if Classic Editor is installed and activated.

If Classic Editor is installed and activated, this plugin will not run.

## Changelog

### 1.0
* Initial submission to the WordPress plugin repository. Sets _all_ custom taxonomies where "show_in_rest" is false to true so that they are compatible with the WordPress 5.* block editor interface.
