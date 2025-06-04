<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Http\Resources\ClienteResource;
use Core\Domain\ValueObject\StatusCliente;
use Core\UseCase\Cliente\CreateClienteUseCase;
use Core\UseCase\Cliente\DeleteClienteUseCase;
use Core\UseCase\Cliente\ListClientesUseCase;
use Core\UseCase\Cliente\ListClienteUseCase;
use Core\UseCase\Cliente\UpdateClienteUseCase;
use Core\UseCase\DTO\Cliente\ClienteInputDto;
use Core\UseCase\DTO\Cliente\CreateCliente\ClienteCreateInputDto;
use Core\UseCase\DTO\Cliente\ListClientes\ListClientesInputDto;
use Core\UseCase\DTO\Cliente\UpdateCliente\ClienteUpdateInputDto;
use Core\Domain\ValueObject\TipoPessoa;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ClienteController extends Controller
{
    public function index(Request $request, ListClientesUseCase $useCase)
    {
        $response = $useCase->execute(
            input: new ListClientesInputDto(
                filter: $request->get('filter') ?? '',
                order: $request->get('order') ?? 'DESC',
            )
        );

        return ClienteResource::collection(collect($response->items));
    }

    public function store(StoreClienteRequest $request, CreateClienteUseCase $useCase)
    {
        $response = $useCase->execute(
            input: new ClienteCreateInputDto(
                nome: $request->get('nome'),
                dataNascimento: new DateTime($request->get('data_nascimento')),
                tipoPessoa: TipoPessoa::fromString($request->get('tipo_pessoa')),
                cpfCnpj: $request->get('cpf_cnpj'),
                email: $request->get('email'),
                telefone: $request->get('telefone'),
                idEndereco: $request->get('id_endereco'),
                idProfissao: $request->get('id_profissao'),
                status: StatusCliente::fromString($request->get('status')),
            )
        );

        return (new ClienteResource($response))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ListClienteUseCase $useCase, $id)
    {
        $client = $useCase->execute(new ClienteInputDto(id: $id));

        return (new ClienteResource($client))->response();
    }

    public function update(UpdateClienteRequest $request, UpdateClienteUseCase $useCase, $id)
    {
        $response = $useCase->execute(
            input: new ClienteUpdateInputDto(
                id: $id,
                nome: $request->get('nome'),
                dataNascimento: new DateTime($request->get('data_nascimento')),
                tipoPessoa: TipoPessoa::fromString($request->get('tipo_pessoa')),
                cpfCnpj: $request->get('cpf_cnpj'),
                email: $request->get('email'),
                telefone: $request->get('telefone'),
                idEndereco: $request->get('id_endereco'),
                idProfissao: $request->get('id_profissao'),
                status: StatusCliente::fromString($request->get('status')),
            )
        );

        return (new ClienteResource($response))->response();
    }

    public function destroy(DeleteClienteUseCase $useCase, $id)
    {
        $useCase->execute(new ClienteInputDto(id: $id));

        return response()->noContent();
    }
}
