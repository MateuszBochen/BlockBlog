<?php

namespace System\Http\Session;

class Notifications
{
    private $session;
    private $notificationsToShow = [];
    private $notificationsToSave = [];
    private $notificationsSessionName = 'notifications';


    public function __construct(Session $session)
    {
        $this->session = $session;
        $this->notificationsToShow = $this->session->get($this->notificationsSessionName);

        echo "Notifications START\n";
    }

    public function __destruct()
    {
        $this->session->set($this->notificationsSessionName, $this->notificationsToSave);
        //print_r($this->notificationsToSave);

        echo "Notifications END\n";

    }

    public function add($message, $type)
    {
        $this->notificationsToSave[$type][] = $message;
        return $this;
    }

    public function getByType($type)
    {   
        if (isset($this->notificationsToShow[$type])) {
            return $this->notificationsToShow[$type];
        }

        return [];
    }
}
