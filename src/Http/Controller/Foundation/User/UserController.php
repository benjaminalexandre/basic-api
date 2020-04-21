<?php declare(strict_types=1);

namespace App\Http\Controller\Foundation\User;

use App\Application\Common\Command\IdentifierCommandResponse;
use App\Application\Modules\Foundation\User\Command\CreateUser\CreateUserCommand;
use App\Application\Modules\Foundation\User\Command\DeleteUser\DeleteUserCommand;
use App\Application\Modules\Foundation\User\Command\UpdateUser\UpdateUserCommand;
use App\Application\Modules\Foundation\User\Query\GetUser\GetUserQuery;
use App\Application\Modules\Foundation\User\Query\GetUser\GetUserQueryResponse;
use App\Application\Modules\Foundation\User\Query\GetUsers\GetUsersQuery;
use App\Application\Modules\Foundation\User\Query\GetUsers\GetUsersQueryResponse;
use App\Http\Controller\ApiController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Class UserController
 * @package App\Http\Controller\User
 */
class UserController extends ApiController
{
    /**
     * @param GetUsersQuery $query
     * @return Response
     *
     * @ParamConverter(name="query", class=GetUsersQuery::class, converter="http.route")
     *
     * @Route("/users", name="get_users", methods={"GET"})
     *
     * @SWG\Get(
     *     path="/users",
     *     summary="Get users list",
     *     operationId="getUsers",
     *     produces={"application/json"},
     *     tags={"Users"},
     *     @SWG\Parameter(name="total", in="query", type="boolean", required=false),
     *     @SWG\Parameter(name="limit", in="query", type="integer", required=false),
     *     @SWG\Parameter(name="offset", in="query", type="integer", required=false),
     *     @SWG\Parameter(name="orderBy", in="query", type="string", required=false),
     *     @SWG\Parameter(name="order", in="query", type="string", enum={"ASC", "DESC"}, required=false),
     *     @SWG\Parameter(name="search", in="query", type="string", required=false),
     *     @SWG\Response(response=200, description="", @Model(type=GetUsersQueryResponse::class))
     * )
     */
    public function getUsers(GetUsersQuery $query): Response
    {
        /** @var GetUsersQueryResponse $response */
        $response = $this->bus->dispatch($query);

        if(empty($response->getUsers())) return $this->noContent();
        return $this->ok($response);
    }

    /**
     * @param GetUserQuery $query
     * @return Response
     *
     * @ParamConverter(name="query", class=GetUserQuery::class, converter="http.route")
     *
     * @Route("/users/{id<^[1-9]\d*$>}", name="get_user", methods={"GET"})
     *
     * @SWG\Get(
     *     path="/users/{id}",
     *     summary="Get a user",
     *     operationId="getUser",
     *     produces={"application/json"},
     *     tags={"Users"},
     *     @SWG\Parameter(name="id", in="path", type="integer", required=true),
     *     @SWG\Response(response=200, description="", @Model(type=GetUserQueryResponse::class))
     * )
     */
    public function getUser(GetUserQuery $query): Response
    {
        /** @var GetUserQueryResponse $response */
        $response = $this->bus->dispatch($query);

        return $this->ok($response);
    }

    /**
     * @param CreateUserCommand $command
     * @return Response
     *
     * @ParamConverter(name="command", class=CreateUserCommand::class, converter="http.body")
     *
     * @Route("/users", name="create_user", methods={"POST"})
     *
     * @SWG\Post(
     *     path="/users",
     *     summary="Create a user",
     *     operationId="createUser",
     *     produces={"application/json"},
     *     tags={"Users"},
     *     @SWG\Parameter(name="command", in="body", @Model(type=CreateUserCommand::class), required=true),
     *     @SWG\Response(response=201, description="", @Model(type=IdentifierCommandResponse::class))
     * )
     */
    public function createUser(CreateUserCommand $command): Response
    {
        /** @var IdentifierCommandResponse $response */
        $response = $this->bus->dispatch($command);

        return $this->created($response);
    }

    /**
     * @param UpdateUserCommand $command
     * @return Response
     *
     * @ParamConverter(name="command", class=UpdateUserCommand::class, converter="http.body")
     *
     * @Route("/users/{id<^[1-9]\d*$>}", name="update_user", methods={"PUT"})
     *
     * @SWG\Put(
     *     path="/users/{id}",
     *     summary="Update a user",
     *     operationId="updateUser",
     *     produces={"application/json"},
     *     tags={"Users"},
     *     @SWG\Parameter(name="id", in="path", required=true, type="integer"),
     *     @SWG\Parameter(name="command", in="body", @Model(type=UpdateUserCommand::class), required=true),
     *     @SWG\Response(response=200, description="", @Model(type=IdentifierCommandResponse::class))
     * )
     */
    public function updateUser(UpdateUserCommand $command): Response
    {
        /** @var IdentifierCommandResponse $response */
        $response = $this->bus->dispatch($command);

        return $this->ok($response);
    }

    /**
     * @param DeleteUserCommand $command
     * @return Response
     *
     * @ParamConverter(name="command", class=DeleteUserCommand::class, converter="http.route")
     *
     * @Route("/users/{id<^[1-9]\d*$>}", name="delete_user", methods={"DELETE"})
     *
     * @SWG\Delete(
     *     path="/users/{id}",
     *     summary="Delete a user",
     *     operationId="deleteUser",
     *     produces={"application/json"},
     *     tags={"Users"},
     *     @SWG\Parameter(name="id", in="path", required=true, type="integer"),
     *     @SWG\Response(response=204, description="")
     * )
     */
    public function deleteUser(DeleteUserCommand $command): Response
    {
        $this->bus->dispatch($command);

        return $this->noContent();
    }
}