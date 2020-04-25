<?php declare(strict_types=1);

namespace App\Http\Controller\Authentication\Authentication;

use App\Application\Common\Command\TokenCommandResponse;
use App\Application\Modules\Authentication\Authentication\Command\SignIn\SignInCommand;
use App\Application\Modules\Authentication\Authentication\Command\SignOut\SignOutCommand;
use App\Http\Controller\ApiController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Class AuthenticationController
 * @package App\Http\Controller\Authentication\Authentication
 */
class AuthenticationController extends ApiController
{
    /**
     * @param SignInCommand $command
     * @return Response
     *
     * @ParamConverter(name="command", class=SignInCommand::class, converter="http.body")
     *
     * @Route("/auth/sign-in", name="sign_in", methods={"POST"})
     *
     * @SWG\Post(
     *     path="/auth/sign-in",
     *     summary="Sign-in then get token",
     *     operationId="signIn",
     *     produces={"application/json"},
     *     tags={"Authentication"},
     *     @SWG\Parameter(name="command", in="body", @Model(type=SignInCommand::class), required=true),
     *     @SWG\Response(response=201, description="", @Model(type=TokenCommandResponse::class))
     * )
     */
    public function signIn(SignInCommand $command): Response
    {
        /** @var TokenCommandResponse $response */
        $response = $this->bus->dispatch($command);

        return $this->created($response);
    }

    /**
     * @param SignOutCommand $command
     * @return Response
     *
     * @ParamConverter(name="command", class=SignOutCommand::class, converter="http.route")
     *
     * @Route("/auth/sign-out", name="sign_out", methods={"POST"})
     *
     * @Security(name="Bearer")
     *
     * @SWG\Post(
     *      path="/auth/sign-out",
     *      summary="Sign-out then delete token",
     *      operationId="signOut",
     *      produces={"application/json"},
     *      tags={"Authentication"},
     *      @SWG\Response(response=204, description="")
     * )
     */
    public function signOut(SignOutCommand $command): Response
    {
        $this->bus->dispatch($command);
        return $this->noContent();
    }
}