<?php
/**
 * @link      https://craftcms.com/
 * @copyright Copyright (c) importantcoding, Inc.
 * @license   https://craftcms.com/license
 */

namespace importantcoding\commerce\nmi\migrations;

use Craft;
use importantcoding\commerce\nmi\gateways\Direct;
use craft\db\Migration;
use craft\db\Query;

/**
 * Installation Migration
 *
 * @author importantcoding, Inc. <support@importantcoding.com>
 * @since  1.0
 */
class Install extends Migration
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        // Convert any built-in Paypal gateways to ours
        $this->_convertGateways();

        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        return true;
    }

    // Private Methods
    // =========================================================================

    /**
     * Converts NMI gateways to this one
     *
     * @return void
     */
    private function _convertGateways()
    {
        $gateways = (new Query())
            ->select(['id'])
            ->where(['type' => 'importantcoding\\commerce\\nmi'])
            ->from(['{{%commerce_gateways}}'])
            ->all();

        $dbConnection = Craft::$app->getDb();

        foreach ($gateways as $gateway) {

            $values = [
                'type' => Direct::class,
            ];

            $dbConnection->createCommand()
                ->update('{{%commerce_gateways}}', $values, ['id' => $gateway['id']])
                ->execute();
        }

    }
}
