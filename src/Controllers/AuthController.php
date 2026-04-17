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

        // Store user ID in session — this is what AuthMiddleware checks.
        $_SESSION['user_id'] = $user->getId();

        return $this->redirect('/products');
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
        $email    = trim((string) ($body['email'] ?? ''));
        $password = (string) ($body['password'] ?? '');
        $confirm  = (string) ($body['confirm'] ?? '');

        // Basic validation before touching the database.
        if (empty($email) || empty($password)) {
            return $this->render('auth/register', [
                'error' => 'Email and password are required.',
            ]);
        }

        if ($password !== $confirm) {
            return $this->render('auth/register', [
                'error' => 'Passwords do not match.',
            ]);
        }

        // Check if the email is already registered.
        if ($this->userRepository->findByEmail($email) !== null) {
            return $this->render('auth/register', [
                'error' => 'An account with this email already exists.',
            ]);
        }

        // Hash the password before storing — never store plain text.
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $this->userRepository->create($email, $hash);

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
