# PHP Restful Api
Essa é uma api restful desenvolvida em php.

## Requisitos
- PHP 7.4

## Melhorias
- Adicionar conexão com banco de dados
- Criar documentação sobre rotas

## Modo de usar
- Clone este repositório em sua máquina local.
- Abra o postman/insomnia e faça as requisições

## Explicação da api
### Configuração Rota
- Para configurar uma rota, acesse o arquivo App/route.php
-- O arquivo Router.php, é o responsavel por identificar a rota, e redirecionar para a classe correta. Ele também é o responsavel por ver se o method existe para a rota especificada, ou se a rota mesmo existe.

### Validação de dados
- Foi criado uma validação inicial de dados

  <a href="https://github.com/jeancarlo-schmitz/api-restful-php-sem-framework">
    <img align="center" heigh="180em" src="https://github.com/jeancarlo-schmitz/api-restful-php-sem-framework/assets/11407906/95a0b7cb-5957-46b5-b336-d3bd92ab5bdc"/>
  </a>
  
 - para utilizar é simples, para chamar a validação na hora de solicitar os parametros da requisição
 
   <a href="https://github.com/jeancarlo-schmitz/api-restful-php-sem-framework">
      <img align="center" heigh="180em" src="https://github.com/jeancarlo-schmitz/api-restful-php-sem-framework/assets/11407906/13cf8ba0-b621-4fee-9ad5-ef689f6fbab3"/>
    </a>

### Request e respose
- A classe Request, é quem fica responsavel por tratar e receber os dados da requisição, é nela que é feito uma sanatização dos dados inicialmente, antes de entregar para a rota utilizar os parametros.
- A classe de Response, é quem cuida da parte de retorno dos dados da requisição. É ela quem seta os headers, e quem converte a resposta para json.

### Controlador de Exceções (handler Exceptions)
- As exception são tratas por um HandlerException, nele fica todo o tratamento das exceptions. Caso a constante IS_DEV esteja true, alguns erros serão mostrados em tela, para facilitar o desenvolvimento.

## Endpoints
TODO
