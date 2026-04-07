<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Signalement;

class AdminController extends Controller
{
    private Signalement $model;

    public function __construct()
    {
        $this->model = new Signalement();
    }

    public function index(): void
    {
        $categorie = (string)($_GET['categorie'] ?? '');
        $statut = (string)($_GET['statut'] ?? '');

        $items = $this->model->allWithFilters($categorie, $statut);

        $this->render('admin/list', [
            'title' => 'BackOffice - Signalements',
            'items' => $items,
            'categorie' => $categorie,
            'statut' => $statut,
        ]);
    }

    public function edit(): void
    {
        $id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newStatus = trim((string)($_POST['statut'] ?? ''));
            $allowed = ['en_attente', 'en_cours', 'resolu', 'rejete'];

            if (!in_array($newStatus, $allowed, true)) {
                set_flash('error', 'Statut invalide.');
                redirect('admin/edit&id=' . $id);
            }

            $ok = $this->model->updateStatus($id, $newStatus);
            set_flash($ok ? 'success' : 'error', $ok ? 'Statut mis à jour.' : 'Erreur de mise à jour.');
            redirect('admin/edit&id=' . $id);
        }

        $item = $this->model->find($id);
        if (!$item) {
            set_flash('error', 'Signalement introuvable.');
            redirect('admin/list');
        }

        $this->render('admin/edit', [
            'title' => 'Modifier statut',
            'item' => $item,
        ]);
    }

    public function delete(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $item = $this->model->find($id);
        if ($item && !empty($item['image'])) {
            $path = UPLOAD_PATH . $item['image'];
            if (is_file($path)) {
                unlink($path);
            }
        }

        $ok = $this->model->delete($id);
        set_flash($ok ? 'success' : 'error', $ok ? 'Signalement supprimé.' : 'Suppression impossible.');
        redirect('admin/list');
    }
}
