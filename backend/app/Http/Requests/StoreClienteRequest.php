<?php

namespace App\Http\Requests;

use Core\Domain\ValueObject\StatusCliente;
use Core\Domain\ValueObject\TipoPessoa;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Respect\Validation\Validator as v;

class StoreClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:100'],
            'data_nascimento' => ['required', 'date_format:Y-m-d'],
            'tipo_pessoa' => ['required', 'string', Rule::in(TipoPessoa::FISICA, TipoPessoa::JURIDICA)],
            'cpf_cnpj' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $tipoPessoaInput = $this->input('tipo_pessoa');

                    if (empty($tipoPessoaInput) || !in_array($tipoPessoaInput, [TipoPessoa::FISICA, TipoPessoa::JURIDICA])) {
                        $fail('Tipo Pessoa should not be empty or invalid.');
                        return;
                    }

                    $cpfCnpjUnmasked = preg_replace('/[^0-9]/', '', $value);

                    if ($tipoPessoaInput == TipoPessoa::FISICA) {
                        if (!preg_match('/^\d{3}\.\d{3}\.\d{3}-\d{2}$/', $value)) {
                            $fail('Invalid CPF mask. Expected format: XXX.XXX.XXX-XX.');
                            return;
                        }
                    } else {
                        if (!preg_match('/^\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}$/', $value)) {
                            $fail('Invalid CNPJ mask. Expected format: XX.XXX.XXX/XXXX-XX.');
                            return;
                        }
                    }
                },
            ],
            'email' => ['required', 'email', 'max:255', 'unique:clientes,email'],
            'telefone' => ['required', 'string', 'max:20'],
            'id_endereco' => ['required', 'integer', Rule::exists('enderecos', 'id')],
            'id_profissao' => [
                'required',
                'integer',
                Rule::exists('profissoes', 'id')
            ],
            'status' => ['required', 'string', Rule::in(StatusCliente::ATIVO, StatusCliente::INATIVO)]
        ];
    }
}
