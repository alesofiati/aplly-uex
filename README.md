
# Apply UEX

Api de lista de contatos.


## Documentação da API

#### Retorna todos os itens

```http
  POST /api/register
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `email` | `string` | **Obrigatório**. email do usuario |
| `name`      | `string` | **Obrigatório**. nome do usuario |
| `password`      | `string` | **Obrigatório**. senha |
| `password_confirmation`      | `string` | **Obrigatório**. Comfirmação de senha |

#### Rota para autenticação

```http
  POST /api/login
```

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `email`      | `string` | **Obrigatório**. E-mail para login |
| `password`      | `string` | **Obrigatório**. senha para login |


### Rotas Autenticadas

#### Rota logout na aplicação

```http
  POST /api/logout
```

#### Rota para consultar o cep no via cep

```http
  GET /api/endereco/{cep}/cep
```
