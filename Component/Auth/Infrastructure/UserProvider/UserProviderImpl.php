<?php

declare(strict_types=1);

namespace Component\Auth\Infrastructure\UserProvider;

use App\Models\User;
use Common\ValueObject\Uuid;
use Component\Auth\Sdk\Exception\UnauthorizedException;
use Component\Auth\Sdk\Model\Authenticate;
use Illuminate\Contracts\Auth\Factory as AuthFactory;
use Illuminate\Http\Request;

final class UserProviderImpl implements UserProvider
{
    private AuthFactory $authFactory;

    private string $guard;

    public function __construct(AuthFactory $authFactory)
    {
        $this->authFactory = $authFactory;
        $this->guard = Request::capture()->expectsJson() ? 'api' : 'web';
    }

    public function current(): Authenticate
    {
        /** @var User $user */
        $user = $this->authFactory->guard($this->guard)->user();

        if ($user === null) {
            throw new UnauthorizedException();
        }

        return new Authenticate(
            new Uuid($user->id),
            $user->name,
            $user->email
        );
    }
}
