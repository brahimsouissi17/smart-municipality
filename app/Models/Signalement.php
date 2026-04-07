<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

class Signalement
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function create(array $data): bool
    {
        $sql = 'INSERT INTO signalements (titre, description, image, categorie, latitude, longitude, statut, date_signalement, user_id)
                VALUES (:titre, :description, :image, :categorie, :latitude, :longitude, :statut, NOW(), :user_id)';

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':titre' => $data['titre'],
            ':description' => $data['description'],
            ':image' => $data['image'],
            ':categorie' => $data['categorie'],
            ':latitude' => $data['latitude'],
            ':longitude' => $data['longitude'],
            ':statut' => 'en_attente',
            ':user_id' => $data['user_id'],
        ]);
    }

    public function allByUser(int $userId): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM signalements WHERE user_id = :user_id ORDER BY date_signalement DESC');
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM signalements WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function allWithFilters(?string $categorie, ?string $statut): array
    {
        $sql = 'SELECT * FROM signalements WHERE 1=1';
        $params = [];

        if ($categorie !== null && $categorie !== '') {
            $sql .= ' AND categorie = :categorie';
            $params[':categorie'] = $categorie;
        }

        if ($statut !== null && $statut !== '') {
            $sql .= ' AND statut = :statut';
            $params[':statut'] = $statut;
        }

        $sql .= ' ORDER BY date_signalement DESC';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function updateStatus(int $id, string $statut): bool
    {
        $stmt = $this->pdo->prepare('UPDATE signalements SET statut = :statut WHERE id = :id');
        return $stmt->execute([':statut' => $statut, ':id' => $id]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM signalements WHERE id = :id');
        return $stmt->execute([':id' => $id]);
    }

    public function mapData(?string $categorie, ?string $date, ?string $zone): array
    {
        $sql = 'SELECT id, titre, description, image, categorie, latitude, longitude, statut, date_signalement FROM signalements WHERE 1=1';
        $params = [];

        if ($categorie !== null && $categorie !== '') {
            $sql .= ' AND categorie = :categorie';
            $params[':categorie'] = $categorie;
        }

        if ($date !== null && $date !== '') {
            $sql .= ' AND DATE(date_signalement) = :d';
            $params[':d'] = $date;
        }

        if ($zone === 'centre') {
            $sql .= ' AND latitude BETWEEN 36.78 AND 36.84 AND longitude BETWEEN 10.14 AND 10.24';
        } elseif ($zone === 'nord') {
            $sql .= ' AND latitude > 36.84';
        } elseif ($zone === 'sud') {
            $sql .= ' AND latitude < 36.78';
        }

        $sql .= ' ORDER BY date_signalement DESC';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
