<?php
/**
 * Phanbook : Delightfully simple forum software
 *
 * Licensed under The GNU License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @link    http://phanbook.com Phanbook Project
 * @since   1.0.0
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */
namespace Phanbook\Common\Library\Providers;

use Phalcon\Filter;
use Phanbook\Common\Library\Filters\YesNoFilter;

/**
 * \Phanbook\Common\Library\Providers\FilterServiceProvider
 *
 * @package Phanbook\Common\Library\Providers
 */
class FilterServiceProvider extends AbstractServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'filter';

    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function register()
    {
        $this->di->setShared($this->serviceName, function () {
            $filter = new Filter();
            $filter->add('yes_no', new YesNoFilter());

            return $filter;
        });
    }
}
