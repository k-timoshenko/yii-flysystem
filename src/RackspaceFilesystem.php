<?php
/**
 * @link https://github.com/creocoder/yii2-flysystem
 * @copyright Copyright (c) 2015 Alexander Kochetov
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace tkanstantsin\yii\flysystem;

use League\Flysystem\Rackspace\RackspaceAdapter;
use OpenCloud\Rackspace;

/**
 * RackspaceFilesystem
 *
 * @author Alexander Kochetov <creocoder@gmail.com>
 */
class RackspaceFilesystem extends Filesystem
{
    /**
     * @var string
     */
    public $endpoint;
    /**
     * @var string
     */
    public $username;
    /**
     * @var string
     */
    public $apiKey;
    /**
     * @var string
     */
    public $region;
    /**
     * @var string
     */
    public $container;
    /**
     * @var string|null
     */
    public $prefix;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->endpoint === null) {
            throw new \CException('The "endpoint" property must be set.');
        }

        if ($this->username === null) {
            throw new \CException('The "username" property must be set.');
        }

        if ($this->apiKey === null) {
            throw new \CException('The "apiKey" property must be set.');
        }

        if ($this->region === null) {
            throw new \CException('The "region" property must be set.');
        }

        if ($this->container === null) {
            throw new \CException('The "container" property must be set.');
        }

        parent::init();
    }

    /**
     * @return RackspaceAdapter
     */
    protected function prepareAdapter()
    {
        return new RackspaceAdapter(
            (new Rackspace($this->endpoint, [
                'username' => $this->username,
                'apiKey' => $this->apiKey]
            ))->objectStoreService('cloudFiles', $this->region)->getContainer($this->container),
            $this->prefix
        );
    }
}
