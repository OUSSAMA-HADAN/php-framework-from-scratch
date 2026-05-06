<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Controller\AbstractController;
use DI\Attribute\Inject;
use Framework\Database\MatcheRepositoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class MatcheController extends AbstractController
{
    #[Inject]
    private MatcheRepositoryInterface $matcheRepository;

    // Liste tous les matchs du joueur connecté.
    public function index(): ResponseInterface
    {
        $userId  = (int) ($_SESSION['user_id'] ?? 0);
        $matches = $this->matcheRepository->findByUser($userId);

        return $this->render('matches/index', ['matches' => $matches]);
    }

    // Affiche le détail d'un match + formulaire de soumission de score.
    public function show(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $userId  = (int) ($_SESSION['user_id'] ?? 0);
        $id      = (int) $args['id'];

        // On cherche dans les matchs du joueur pour vérifier qu'il en fait partie.
        $matches = $this->matcheRepository->findByUser($userId);
        $matche  = null;

        foreach ($matches as $m) {
            if ($m->getId() === $id) {
                $matche = $m;
                break;
            }
        }

        if ($matche === null) {
            return $this->redirect('/matches');
        }

        return $this->render('matches/show', [
            'matche' => $matche,
            'userId' => $userId,
        ]);
    }

    // Traite la soumission d'un score par un joueur.
    public function submitScore(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $userId    = (int) ($_SESSION['user_id'] ?? 0);
        $id        = (int) $args['id'];
        $body      = $request->getParsedBody();
        $homeScore = (int) ($body['home_score'] ?? 0);
        $awayScore = (int) ($body['away_score'] ?? 0);

        $result = $this->matcheRepository->submitScore($id, $userId, $homeScore, $awayScore);

        // $result est 'waiting', 'confirmed' ou 'disputed'
        return $this->redirect('/matches/' . $id . '?status=' . $result);
    }
}
