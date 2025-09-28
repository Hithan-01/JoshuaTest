<?php
declare(strict_types=1);

namespace App\View;

use Cake\View\View;

class AppView extends View
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadHelper('Form');
        $this->loadHelper('Html');
        $this->loadHelper('Flash');
        $this->loadHelper('Authentication.Identity'); 
    }
}
