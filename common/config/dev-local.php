<?php
if($_SERVER['REMOTE_ADDR']=='31.42.52.10' || $_SERVER['REMOTE_ADDR']=='91.209.51.157')
{
    $config['modules']['rights']['debug'] = false;
    $config['components']['db']['enableProfiling'] = true;
    $config['components']['db']['enableParamLogging'] = true;
    $config['components']['authManager']['showErrors'] = true;
    $config['components']['log'] = array(
        'class' => 'CLogRouter',
        'routes' => array(
            'web' => array(
                'class' => 'CWebLogRoute',
                'showInFireBug' => true,
                'enabled' => true,
            ),
            'profile' => array(
                'class' => 'CProfileLogRoute',
                'enabled' => true,
            ),
        )
    );
}