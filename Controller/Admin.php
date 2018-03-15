<?php
/**
 * BoxBilling
 *
 * @copyright BoxBilling, Inc (http://www.boxbilling.com)
 * @license   Apache-2.0
 *
 * Copyright BoxBilling, Inc
 * This source file is subject to the Apache-2.0 License that is bundled
 * with this source code in the file LICENSE
 */

/**
 * This file connects BoxBilling admin area interface and API
 * Class does not extend any other class
 */

namespace Box\Mod\Pterodactyl\Controller;

class Admin implements \Box\InjectionAwareInterface {
    protected $di;

    /**
     * @param mixed $di
     */
    public function setDi($di) {
        $this->di = $di;
    }

    /**
     * @return mixed
     */
    public function getDi() {
        return $this->di;
    }

    /**
     * This method registers menu items in admin area navigation block
     * This navigation is cached in bb-data/cache/{hash}. To see changes please
     * remove the file
     *
     * @return array
     */
    public function fetchNavigation()
    {
        return array(
            'group'  =>  array(
                'index'     => 1600,                // menu sort order
                'location'  =>  'pterodactyl',          // menu group identificator for subitems
                'label'     => 'Pterodactyl Module',    // menu group title
                'class'     => 'pterodactyl',           // used for css styling menu item
            ),
            'subpages'=> array(
                array(
                    'location'  => 'pterodactyl', // place this module in extensions group
                    'label'     => 'Pterodactyl Configuration',
                    'index'     => 1500,
                    'uri'       => $this->di['url']->adminLink('pterodactyl'),
                    'class'     => '',
                ),
            ),
        );
    }

    /**
     * Methods maps admin areas urls to corresponding methods
     * Always use your module prefix to avoid conflicts with other modules
     * in future
     *
     *
     * @example $app->get('/example/test',      'get_test', null, get_class($this)); // calls get_test method on this class
     * @example $app->get('/example/:id',        'get_index', array('id'=>'[0-9]+'), get_class($this));
     * @param \Box_App $app
     */
    public function register(\Box_App &$app) {
        $app->get('/pterodactyl',             'get_index', array(), get_class($this));
    }

    public function get_index(\Box_App $app) {
        $this->di['is_admin_logged'];
        return $app->render('mod_pterodactyl_index');
    }
}
