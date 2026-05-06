<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Controller\AbstractController;
use DI\Attribute\Inject;
use Framework\Database\UserRepositoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

// Handles login, registration, and logout.
// No auth middleware applied to these routes — they must stay public.
class AuthController extends AbstractController
{
    // Injected by PHP-DI — resolves to UserRepository via definitions.php.
    #[Inject]
    private UserRepositoryInterface $userRepository;

    // Shows the login form.
    public function showLogin(): ResponseInterface
    {
        return $this->render('auth/login', []);
    }

    // Handles login form submission.
    // Verifies credentials, sets the session, and redirects on success.
    public function login(ServerRequestInterface $request): ResponseInterface
    {
        $body     = $request->getParsedBody();
        $email    = trim((string) ($body['email'] ?? ''));
        $password = (string) ($body['password'] ?? '');

        $user = $this->userRepository->findByEmail($email);

        // Verify the submitted password against the stored bcrypt hash.
        if ($user === null || !password_verify($password, $user->getPassword())) {
            return $this->render('auth/login', [
                'error' => 'Invalid email or password.',
            ]);
        }

        $_SESSION['user_id']   = $user->getId();
        $_SESSION['user_role'] = $user->getRole();

        return $this->redirect('/cups');
    }

    // Shows the registration form.
    public function showRegister(): ResponseInterface
    {
        return $this->render('auth/register', []);
    }

    // Handles registration form submission.
    // Hashes the password and creates the user, then redirects to login.
    public function register(ServerRequestInterface $request): ResponseInterface
    {
        $body     = $request->getParsedBody();
        $email    = trim((string) ($body['email']    ?? ''));
        $username = trim((string) ($body['username'] ?? ''));
        $password = (string) ($body['password']      ?? '');
        $confirm  = (string) ($body['confirm']       ?? '');

        if (empty($email) || empty($username) || empty($password)) {
            return $this->render('auth/register', [
                'error' => 'Tous les champs sont obligatoires.',
            ]);
        }

        if ($password !== $confirm) {
            return $this->render('auth/register', [
                'error' => 'Les mots de passe ne correspondent pas.',
            ]);
        }

        if ($this->userRepository->findByEmail($email) !== null) {
            return $this->render('auth/register', [
                'error' => 'Un compte existe déjà avec cet email.',
            ]);
        }

        $hash = password_hash($password, PASSWORD_BCRYPT);
        $this->userRepository->create($email, $username, $hash);

        return $this->redirect('/login');
    }

    // Destroys the session and redirects to the login page.
    public function logout(): ResponseInterface
    {
        $_SESSION = [];
        session_destroy();

        return $this->redirect('/login');
    }
}
