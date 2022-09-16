<?php

namespace App\Http\Controllers\API;

use App\Abstracts\Http\ApiController;
use App\Http\Requests\API\Request;
use App\Http\Requests\API\UserLoginRequest;
use App\Http\Requests\API\UserStoreRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\TokenManager;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Hashing\HashManager;
use Illuminate\Http\Response;

class AuthController extends ApiController
{
    use ThrottlesLogins;
    
    private UserRepository $userRepository;
    private HashManager $hash;
    private TokenManager $tokenManager;

    /** @var User */
    private ?Authenticatable $currentUser;

    public function __construct(
        UserRepository $userRepository,
        HashManager $hash,
        TokenManager $tokenManager,
        ?Authenticatable $currentUser
    ) {
        $this->userRepository = $userRepository;
        $this->hash = $hash;
        $this->tokenManager = $tokenManager;
        $this->currentUser = $currentUser;
    }

    public function login(UserLoginRequest $request)
    {
        $user = $this->userRepository->getFirstWhere('email', $request->email);

        if (!$user || !$this->hash->check($request->password, $user->password)) {
            abort(Response::HTTP_UNAUTHORIZED, 'Invalid credentials');
        }

        return response()->json([
            'token' => $this->tokenManager->createToken($user)->plainTextToken,
            'user' => $user,
        ]);
    }
    
    public function register(UserStoreRequest $request)
    {
        $request->merge([
            'password' => bcrypt($request->password),
        ]);

        $user = User::create($request->all());

        return response()->json($user);
    }

    public function logout()
    {
        $this->tokenManager->destroyTokens($this->currentUser);

        return response()->noContent();
    }
}
