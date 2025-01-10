<?php
/**
 * Copyright (C) 2025-2025 thirty bees
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@thirtybees.com so we can send you a copy immediately.
 *
 * @author    E-Com <e-com@presta.eu.org>
 * @author    thirty bees <modules@thirtybees.com>
 * @copyright 2025-2025 thirty bees
 * @license   Academic Free License (AFL 3.0)
 */

if (!defined('_TB_VERSION_')) {
    exit;
}

class TbDetectMobile extends Module
{
    /**
     *
     */
    const MIN_PHP_VERSION = '8.0';

    /**
     * @throws PrestaShopException
     */
    public function __construct()
    {
        $this->name = 'tbdetectmobile';
        $this->tab = 'administration';
        $this->version = '1.1.0';
        $this->author = 'thirty bees';
        $this->controllers = [];
        $this->bootstrap = true;
        parent::__construct();
        $this->displayName = $this->l('Detect mobile device');
        $this->description = $this->l('This module implements mobile detection functionality.');
        $this->need_instance = 0;
        $this->tb_versions_compliancy = '>= 1.6.0';
        $this->tb_min_version = '1.6.0';
        if (! $this->checkPhpVersion()) {
            $this->warning = $this->getPhpVersionErrorMessage();
        }
    }

    /**
     * @return bool
     *
     * @throws PrestaShopException
     */
    public function install()
    {
        return (
            parent::install() &&
            $this->registerHook('actionDetectMobile')
        );
    }

    /**
     * @return array|null
     */
    public function hookActionDetectMobile()
    {
        if ($this->checkPhpVersion()) {
            require_once(__DIR__ . '/vendor/autoload.php');
            try {
                $mobileDetect = new \Detection\MobileDetect();
                return [
                    'isMobile' => $mobileDetect->isMobile(),
                    'isTablet' => $mobileDetect->isTablet(),
                ];
            } catch (Throwable $e) {}
        }
        return null;
    }

    /**
     * @return bool
     */
    protected function checkPhpVersion()
    {
        return (bool)version_compare(phpversion(), static::MIN_PHP_VERSION, '>=');
    }

    /**
     * @return string
     *
     * @throws PrestaShopException
     * @throws SmartyException
     */
    public function getContent()
    {
        $this->context->smarty->assign([
            'phpSupported' => $this->checkPhpVersion(),
            'phpVersionError' => $this->getPhpVersionErrorMessage(),
        ]);
        return $this->display(__FILE__, 'views/templates/admin/configuration.tpl');
    }

    /**
     * @return string
     */
    public function getPhpVersionErrorMessage(): string
    {
        return sprintf(Tools::displayError('This module requires PHP version %s or newer'), static::MIN_PHP_VERSION);
    }
}
