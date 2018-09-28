<?php

namespace importantcoding\commerce\nmi;

use importantcoding\commerce\nmi\gateways\Direct;
use craft\commerce\services\Gateways;
use craft\events\RegisterComponentTypesEvent;
use yii\base\Event;


/**
 * Plugin represents the Stripe integration plugin.
 *
 * @author importantcoding, Inc. <support@importantcoding.com>
 * @since  1.0
 */
class Plugin extends \craft\base\Plugin
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        Event::on(Gateways::class, Gateways::EVENT_REGISTER_GATEWAY_TYPES,  function(RegisterComponentTypesEvent $event) {
            $event->types[] = Direct::class;
        });
    }
}
