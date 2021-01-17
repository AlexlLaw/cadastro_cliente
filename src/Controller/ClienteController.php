<?php


namespace App\Controller;


use App\services\ClienteService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClienteController extends AbstractController
{

    /**
     * @var ClienteService
     */
    private $clienteService;

    /**
     * clienteController constructor.
     * @param ClienteService $clienteService
     */
    public function __construct(ClienteService $clienteService)
    {
        $this->clienteService = $clienteService;
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/clientes", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        $request->getContent();
        $this->clienteService->createCliente($request->getContent());

        return new JsonResponse('Cadastrado com sucesso, Protocolo gerado');
    }

    /**
     * @return Response
     * @Route("/clientes", methods={"GET"})
     */
    public function findAll(): Response
    {
        $clientes = $this->clienteService->buscarTodos();
        $codigoRetorno = is_null($clientes) ? Response::HTTP_NO_CONTENT : 200;

        return new JsonResponse($clientes, $codigoRetorno);
    }

    /**
     * @param int $id
     * @return Response
     * @Route("/clientes/{id}", methods={"GET"})
     */
    public function findById(int $id): Response
    {
        $cliente = $this->clienteService->buscarById($id);
        $codigoRetorno = is_null($cliente) ? Response::HTTP_NO_CONTENT : 200;

        return  new JsonResponse($cliente, $codigoRetorno);
    }

    /**
     * @param Request $request
     * @return JsonResponse|Response
     * @Route("/clientes", methods={"PUT"})
     */
    public function Update(Request $request)
    {
        $this->clienteService->update($request->getContent());

        return  new JsonResponse('Editado com sucesso');
    }
    
    /**
     * @param int $id
     * @return Response
     * @Route("/clientes/{id}", methods={"DELETE"})
     */
    public function destroy(int $id): Response
    {
        $this->clienteService->delete($id);

        return new Response('', Response::HTTP_NO_CONTENT);
    }



}
