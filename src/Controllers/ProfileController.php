<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Controller\AbstractController;
use DI\Attribute\Inject;
use Framework\Database\CupRepositoryInterface;
use Framework\Database\MatcheRepositoryInterface;
use Psr\Http\Message\ResponseInterface;

class ProfileController extends AbstractController
{
    #[Inject]
    private CupRepositoryInterface $cupRepository;

    #[Inject]
    private MatcheRepositoryInterface $matcheRepository;

    // Affiche le profil du joueur connecté : ses cups et ses matchs récents.
    public function show(): ResponseInterface
    {
        $userId  = (int) ($_SESSION['user_id'] ?? 0);
        $matches = $this->matcheRepository->findByUser($userId);

        return $this->render('profile/show', [
            'matches' => $matches,
            'userId'  => $userId,
        ]);
    }
}
