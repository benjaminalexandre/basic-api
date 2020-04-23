<?php declare(strict_types=1);

namespace App\Http\Controller\File\Image;

use App\Application\Provider\Files\Image;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * Class FileController
 * @package App\Http\Controller\File\Image
 */
class ImageController extends AbstractController
{
    /**
     * @var Image
     */
    private $image;

    /**
     * ImageController constructor.
     * @param Image $image
     */
    public function __construct(Image $image)
    {
        $this->image = $image;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Exception
     *
     * @Route("/files/images", name="get_image", methods={"GET"})
     *
     * @SWG\Get(
     *      path="/files/images",
     *      summary="Get an image",
     *      operationId="getImage",
     *      produces={"application/json"},
     *      tags={"File"},
     *      @SWG\Parameter(name="id", in="query", type="string", required=true),
     *      @SWG\Response(response=200, description="Returns the image as a base64", @SWG\Schema(type="string"))
     * )
     */
    public function getImage(Request $request): Response
    {
        $param = $request->query->all();
        $file = new File($this->image->getImage('../files/images/' . $param["id"], $param));

        return $this->file($file);
    }
}