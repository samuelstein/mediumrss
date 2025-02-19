# Medium RSS Plugin

A plugin for [Grav CMS](https://getgrav.org/) that fetches the RSS profile page feed from [Medium](https://medium.com/) and displays the titles and teasers of your articles in a list.

## Installation

1. Upload the plugin files to the `user/plugins/mediumrss` directory of your Grav installation.
2. Make sure the plugin directory is named `mediumrss`.
3. Enable the plugin in the `mediumrss.yaml` file or via the Admin Panel.
4. Use as page template `medium`.

## Configuration

The plugin configuration is done through the `blueprints.yaml` file. Here are the available settings:

```yaml
enabled: true
rss_feed_url: 'https://medium.com/feed/@your-username'
target: '_blank'
```
## Usage
The plugin automatically inserts the latest Medium posts into your page. The posts are displayed using the _medium.html.twig_ template.

This plugin is licensed under the MIT License