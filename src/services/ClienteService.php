<?php


namespace App\services;


use App\Entity\Cliente;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ClienteService extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * clienteController constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $dados
     * @param bool $verificar
     * @return Cliente
     * @throws \Exception
     */
    public function montarCliente(string $dados, bool $verificar)
    {
        $dados = json_decode($dados);
        $cliente = new Cliente();
        $dataNascimento = new \DateTime($dados->dataNascimento);

        if ($verificar) {
            $protocolo = $this->gerarProtocolo();
            $cliente->setProtocolo($protocolo);
        }

        if (!$verificar) {
           $cliente->setId($dados->id);
        }

        $cliente->setNome($dados->nome);
        $cliente->setDataNascimento($dataNascimento);
        $cliente->setCpf($dados->cpf);
        $cliente->setEmail($dados->email);
        $cliente->setCep($dados->cep);
        $cliente->setEndereco($dados->endereco);
        $cliente->setBairro($dados->bairro);

        return $cliente;
    }

    /**
     * @param $dados
     * @return Cliente
     * @throws \Exception
     */
    public function createCliente($dados)
    {
        $cliente = $this->montarCliente($dados,true);

        $this->entityManager->persist($cliente);
        $this->entityManager->flush();

        return $cliente;
    }

    /**
     * @return array
     */
    public function buscarTodos(): array
    {
        $repository = $this
            ->getDoctrine()
            ->getRepository(Cliente::class);

        $clientes = $repository->findAll();

        return $clientes;
    }

    /**
     * @param int $id
     * @return array
     */
    public function buscarById(int $id)
    {
        $repository = $this
            ->getDoctrine()
            ->getRepository(Cliente::class);

        $cliente = $repository->find($id);

        return $cliente;
    }

    /**
     * @param string $dados
     * @return Response
     * @throws \Exception
     */
    public function update(string $dados)
    {
        $clienteEnviado = $this->montarCliente($dados, false);
        $clienteExistente = $this->buscarById($clienteEnviado->getId());

        if (is_null($clienteExistente)) {
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        $clienteExistente->setNome($clienteEnviado->getNome());
        $clienteExistente->setEmail($clienteEnviado->getEmail());
        $clienteExistente->setCpf($clienteEnviado->getCpf());
        $clienteExistente->setDataNascimento($clienteEnviado->getDataNascimento());
        $clienteExistente->setEndereco($clienteEnviado->getEndereco());
        $clienteExistente->setCep($clienteEnviado->getCep());
        $clienteExistente->setBairro($clienteEnviado->getBairro());

        $this->entityManager->flush();
    }

    /**
     * @param string $id
     */
    public function delete(string $id)
    {
        $repositorioClientes = $this
            ->getDoctrine()
            ->getRepository(Cliente::class);

        $cliente = $repositorioClientes->find($id);

        $this->entityManager->remove($cliente);
        $this->entityManager->flush();
    }

    /**
     * @return string
     */
   private function gerarProtocolo(){

        $basic = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $string = "";

        for($count = 0; 3 > $count; $count++){
            $string.= $basic[rand(0, strlen($basic) - 1)];
        }

        $basic = '123456789';
        $number= "";

        for($count = 0; 4 > $count; $count++){
            $number.= $basic[rand(0, strlen($basic) - 1)];
        }

        $protocolo = $string . $number;

        return $protocolo;
    }
}
