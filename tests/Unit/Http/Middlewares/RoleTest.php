<?php

namespace Tests\Unit\Http\Middlewares;

use App\Http\Middleware\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Role middleware test.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class RoleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Call the given middleware.
     *
     * @param  string|string[]  $middleware
     * @param  string  $method
     * @param  array  $data
     * @return $this
     */
    protected function callMiddleware($middleware, $method = 'GET', array $data = [])
    {
        return $this->call(
            $method, $this->makeMiddlewareRoute($method, $middleware), $data
        );
    }

    /**
     * Call the given middleware using a JSON request.
     *
     * @param  string|string[]  $middleware
     * @param  string  $method
     * @param  array  $data
     * @return $this
     */
    protected function callMiddlewareJson($middleware, $method = 'GET', array $data = [])
    {
        return $this->json(
            $method, $this->makeMiddlewareRoute($method, $middleware), $data
        );
    }

    /**
     * Make a dummy route with the given middleware applied.
     *
     * @param  string  $method
     * @param  string|string[]  $middleware
     * @return string
     */
    protected function makeMiddlewareRoute($method, $middleware)
    {
        $method = strtolower($method);

        return $this->app->make('router')->{$method}('/__middleware__', [
            'middleware' => $middleware,
            function () {
                return '__passed__';
            },
        ])->uri();
    }

    /** @test */
    public function it_passes_for_user_roles_on_parameters()
    {
        $user = $this->createUser('admin');

        $this->actingAs($user)->callMiddleware(Role::class.':admin|worker');
        $this->assertResponseStatus(200);
    }

    /** @test */
    public function it_redirects_non_accepted_roles_to_the_home()
    {
        $user = $this->createUser('worker');

        $this->actingAs($user)->callMiddleware(Role::class.':admin');

        $this->assertRedirectedTo(route('home'));
    }

    /** @test */
    public function it_redirects_guests_to_login()
    {
        $this->callMiddleware(Role::class.':admin');

        $this->assertRedirectedTo(route('auth.login'));
    }

    /** @test */
    public function it_returns_a_forbidden_json_response_for_non_accepted_roles()
    {
        $user = $this->createUser('worker');

        $this->actingAs($user)->callMiddlewareJson(Role::class.':admin');

        $this->assertResponseStatus(403);
    }

    /** @test */
    public function it_returns_a_forbidden_json_response_for_guests()
    {
        $this->callMiddlewareJson(Role::class.':admin');

        $this->assertResponseStatus(403);
    }
}
