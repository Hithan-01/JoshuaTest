<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\EventInterface;

class AppController extends Controller
{
    public function initialize(): void
    {
        parent::initialize();

        // ✅ Cargar Flash
        $this->loadComponent('Flash');

        // ✅ Cargar Authentication
        $this->loadComponent('Authentication.Authentication');
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        // ✅ Ahora sí funciona porque $this->Authentication existe
        $this->Authentication->allowUnauthenticated([
            'login',
            'add',
            'home',
            'display'
        ]);
    }
}
