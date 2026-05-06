<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Controller\AbstractController;
use DI\Attribute\Inject;
use Framework\Database\CupRepositoryInterface;
use Framework\Database\GroupRepositoryInterface;
use Framework\Database\MatcheRepositoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CupController extends AbstractController
{
    #[Inject]
    private CupRepositoryInterface $cupRepository;

    #[Inject]
    private GroupRepositoryInterface $groupRepository;

    #[Inject]
    private MatcheRepositoryInterface $matcheRepository;

    public function index(): ResponseInterface
    {
        $cups = $this->cupRepository->findOpenCups();

        return $this->render('cups/index', ['cups' => $cups]);
    }

    public function show(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $id     = (int) $args['id'];
        $userId = (int) ($_SESSION['user_id'] ?? 0);
        $cup    = $this->cupRepository->findById($id);

        if ($cup === null) {
            return $this->redirect('/cups');
        }

        $groups = $this->groupRepository->findByCup($id);

        $standings = [];
        foreach ($groups as $group) {
            $standings[$group->getId()] = $this->groupRepository->getStandings($group->getId());
        }

        $isParticipant  = $this->cupRepository->isParticipant($id, $userId);
        $knockoutRounds = $this->matcheRepository->findKnockoutByCup($id);
        $participants   = $this->cupRepository->getParticipants($id);

        return $this->render('cups/show', [
            'cup'            => $cup,
            'groups'         => $groups,
            'standings'      => $standings,
            'isParticipant'  => $isParticipant,
            'knockoutRounds' => $knockoutRounds,
            'participants'   => $participants,
        ]);
    }

    public function join(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $id     = (int) $args['id'];
        $userId = (int) ($_SESSION['user_id'] ?? 0);
        $cup    = $this->cupRepository->findById($id);

        if ($cup === null || $cup->getStatut() !== 'open') {
            return $this->redirect('/cups');
        }

        $this->cupRepository->join($id, $userId);

        return $this->redirect('/cups/' . $id);
    }
}
