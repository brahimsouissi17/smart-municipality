<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller
{
    public function index(): void
    {
        if (isset($_GET['role']) && in_array($_GET['role'], ['citoyen', 'admin'], true)) {
            $_SESSION['user']['role'] = $_GET['role'];
        }

        $this->render('home', [
            'title' => 'Accueil - Carte Intelligente',
        ]);
    }
}
