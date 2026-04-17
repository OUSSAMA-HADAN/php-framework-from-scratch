<?php

declare(strict_types=1);

namespace Framework\Database;

// Base marker interface for all repositories.
// Every repository in the app must implement this, allowing type-safe
// collection and injection of repositories through the DI container.
interface RepositoryInterface
{
}
