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

use Phalcon\Cache\Backend;
use Phalcon\Cache\Frontend;

/**
 * \Phanbook\Common\Library\Providers\UrlResolverServiceProvider
 *
 * @package Phanbook\Common\Library\Providers
 */
class ViewCacheServiceProvider extends AbstractServiceProvider
{
    const DEFAULT_CACHE_TTL = 86400;

    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'viewCache';

    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function register()
    {
        $this->di->set(
            $this->serviceName,
            function () {
                /** @var \Phalcon\DiInterface $this */
                $config = $this->getShared('config');

                if ($config->application->debug) {
                    if (!isset($config->application->viewCache->force) || !$config->application->viewCache->force) {
                        return new Backend\Memory(new Frontend\None());
                    }
                }

                $lifetime = ViewCacheServiceProvider::DEFAULT_CACHE_TTL;
                if (isset($config->application->viewCache->lifetime)) {
                    $lifetime = (int) $config->application->viewCache->lifetime;
                }

                return new Backend\File(
                    new Frontend\Output(['lifetime' => (int) $lifetime]),
                    [
                        'cacheDir' => $config->application->viewCache->cacheDir,
                        'prefix'   => $config->application->viewCache->prefix
                    ]
                );
            }
        );
    }
}
