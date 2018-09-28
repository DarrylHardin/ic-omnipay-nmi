NMI payment gateway plugin for Craft Commerce 2
=======================

This plugin provides [NMI](https://www.networkmerchants.com/) integrations for [Craft Commerce](https://craftcommerce.com/).

## Requirements

This plugin requires Craft Commerce 2.0.0-beta.9 or later.


## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require importantcoding/ic-omnipay-nmi

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for NMI.

## Setup

To add a NMI payment gateway, go to Commerce → Settings → Gateways, create a new gateway, and set the gateway type to NMI Direct””.

### Disabling CSRF for webhooks.

You must disable CSRF protection for the incoming requests, assuming it is enabled for the site (default for Craft since 3.0).

A clean example for how to go about this can be found [here](https://craftcms.stackexchange.com/a/20301/258).

