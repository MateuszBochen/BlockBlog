<?php

namespace System;

use System\Configuration\Configuration;
use System\ServiceFactory\ServiceFactory;
use System\AppLauncher;

class Kernel
{

    public function init()
    {   
        $appLauncher = null;
        $classLoader = new \System\Autoloader\Autoloader;
        $classLoader->register();

        $configuration = new Configuration();

        $serviceFactory = new ServiceFactory($configuration);

        $request = $serviceFactory->getService('request');
        //$authentication = $serviceFactory->getService('authentication');

        if ($request->getUrlParam(0) == $configuration->getParam('adminDir')) {
            $appLauncher = new AppLauncher\AdminAppLauncher($serviceFactory, $configuration);
        }
        else {
            $appLauncher = new AppLauncher\UserAppLauncher($serviceFactory, $configuration);
        }
        
        //$newAtline = new \Atline\Compiler();

        //exit;

        //$db = $serviceFactory->getService('db');
        //$um = $serviceFactory->getService('user.manager');
        //$atline = $serviceFactory->getService('atline');
        
        //$um->createUser('backen', 'nblc08gx', 'meoun@o2.pl', 100);
        //var_dump($db->query("SELECT * FROM main_users") instanceof  \BlockBlog\Mysql);



        /* $db->insert('main_users', [['password' => 'nblc08gx', 'user_name' => 'backen', 'range' => 100]]);
        print_r($db->lastId());*/
        
        /*$user = new \System\User\UserEntity\MainUser();

        $orm = $serviceFactory->getService('orm');
        
        $repo = $orm->getRepository('System\User\UserEntity\MainUser');
        
        $repo->dd();
        $entity = $repo->findOneBy(['id' => 1, 'userName' => 'backen']);
        $entity->setEMail('maciek@o2.pl');
        print_r($entity);
        echo "\n\n";
        
        $orm->add($entity);
        $orm->save();*/
        //*/

        //print_r($repositoryManager);    

        #*/
    }
}
