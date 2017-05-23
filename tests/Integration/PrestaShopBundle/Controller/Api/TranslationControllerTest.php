<?php
/**
 * 2007-2017 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2017 PrestaShop SA
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */

namespace PrestaShop\PrestaShop\Tests\Integration\PrestaShopBundle\Controller\Api;

/**
 * @group api
 * @group translation
 */
class TranslationControllerTest extends ApiTestCase
{
    /**
     * @dataProvider getBadDomains
     * @test
     *
     * @param $params
     */
    public function it_should_return_bad_response_when_requesting_domain($params)
    {
        $this->assertBadRequest('api_translation_domain_catalog', $params);
    }

    /**
     * @dataProvider getGoodDomains
     * @test
     *
     * @param $params
     */
    public function it_should_return_ok_response_when_requesting_domain($params)
    {
        $this->assetOkRequest('api_translation_domain_catalog', $params);
    }

    /**
     * @return array
     */
    public function getBadDomains()
    {
        return array(
            array(
                array('locale' => 'default', 'domain' => 'AdminGloabl'), // syntax error wanted
            ),
            array(
                array('locale' => 'defaultt', 'domain' => 'AdminGlobal'),
            ),
        );
    }

    /**
     * @return array
     */
    public function getGoodDomains()
    {
        return array(
            array(
                array('locale' => 'default', 'domain' => 'AdminGlobal'),
            ),
            array(
                array('locale' => 'default', 'domain' => 'AdminNavigationMenu'),
            ),
        );
    }

    /**
     * @dataProvider getBadDomainsCatalog
     * @test
     *
     * @param $params
     */
    public function it_should_return_bad_response_when_requesting_domain_catalog($params)
    {
        $this->assertBadRequest('api_translation_domains_tree', $params);
    }

    /**
     * @dataProvider getGoodDomainsCatalog
     * @test
     *
     * @param $params
     */
    public function it_should_return_ok_response_when_requesting_domain_catalog($params)
    {
        $this->assetOkRequest('api_translation_domains_tree', $params);
    }

    /**
     * @return array
     */
    public function getBadDomainsCatalog()
    {
        return array(
            array(
                array(
                    'lang' => 'en',
                    'type' => 'modules',
                    'selected' => 'ps_baanner' // syntax error wanted
                ),
            ),
            array(
                array(
                    'lang' => 'en',
                    'type' => 'frront', // syntax error wanted
                    'selected' => 'classic'
                ),
            ),
        );
    }

    /**
     * @return array
     */
    public function getGoodDomainsCatalog()
    {
        return array(
            array(
                array(
                    'lang' => 'en',
                    'type' => 'modules',
                    'selected' => 'ps_banner'
                ),
            ),
            array(
                array(
                    'lang' => 'en',
                    'type' => 'front',
                    'selected' => 'classic'
                ),
            ),
        );
    }
}
