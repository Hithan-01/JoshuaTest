<?php
declare(strict_types=1);

namespace App\Controller;

class DashboardController extends AppController
{
    public function index()
    {
        $identity = $this->Authentication->getIdentity();

        // Si no está logueado → login
        if (!$identity) {
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }

        // Si no es admin → lo mando a otra página (por ejemplo examenes)
        if ($identity->get('role') !== 'admin') {
            return $this->redirect(['controller' => 'Examenes', 'action' => 'index']);
        }

        // Renderiza templates/Dashboard/index.php
    }
}
