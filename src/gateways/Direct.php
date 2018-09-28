<?php

namespace importantcoding\commerce\nmi\gateways;

use Craft;
use craft\commerce\base\RequestResponseInterface;
use craft\commerce\models\Transaction;
use craft\commerce\records\Transaction as TransactionRecord;
use craft\commerce\omnipay\base\CreditCardGateway;
use Omnipay\Common\AbstractGateway;
use Omnipay\Omnipay;
use Omnipay\NMI\DirectPostGateway as Gateway;
use yii\base\NotSupportedException;

/**
 * Direct represents NMI Direct gateway
 *
 * @author    importantcoding, Inc. <support@importantcoding.com>
 * @since     1.0
 */
class Direct extends CreditCardGateway
{
    // Properties
    // =========================================================================

    /**
     * @var string
     */
    public $username;

        /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $vendor;

    /**
     * @var bool
     */
    public $testMode = false;

    /**
     * @var string
     */
    public $referrerId;


    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('commerce', 'NMI Direct');
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml()
    {
        return Craft::$app->getView()->renderTemplate('ic-omnipay-nmi/gatewaySettings', ['gateway' => $this]);
    }

    /**
     * @inheritdoc
     */
    public function refund(Transaction $transaction): RequestResponseInterface
    {

        $request = $this->createRequest($transaction);
        $parent= $transaction->getParent();

        if ($parent->type == TransactionRecord::TYPE_CAPTURE) {
            $reference = $parent->getParent()->reference;
        } else {
            $reference = $transaction->reference;
        }

        $refundRequest = $this->prepareRefundRequest($request, $reference);

        return $this->performRequest($refundRequest, $transaction);
    }

    /**
     * @inheritdoc
     */
    public function supportsPaymentSources(): bool
    {
        return false;
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function createGateway(): AbstractGateway
    {
        /** @var Gateway $gateway */
        $gateway = Omnipay::create($this->getGatewayClassName());

        $gateway->setUsername($this->username);
        $gateway->setPassword($this->password);

        return $gateway;
    }

    /**
     * @inheritdoc
     */
    protected function getGatewayClassName()
    {
        return '\\'.Gateway::class;
    }
}
