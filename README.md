# Projeto Laravel com Docker e Laravel Sail

Este documento fornece instruções para clonar e executar este projeto Laravel utilizando Docker e Laravel Sail.

## Pré-requisitos

Certifique-se de ter os seguintes itens instalados em seu sistema:

- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/install/)

## Execução do Projeto

1. **Clone o repositório:**

  ```bash
  git clone https://github.com/LamimPaulo/challenge-full-stack-web-developer
  cd challenge-full-stack-web-developer
  ```

2. **Crie um alias para o comando sail:** (opcional)

  Para facilitar o uso, você pode criar um alias para o comando Sail. Adicione o seguinte comando ao seu arquivo ~/.bashrc, ~/.zshrc ou outro arquivo de configuração de shell:

  ```bash
  alias sail='./vendor/bin/sail'
  ```

3. **Ajuste o arquivo**:

  Antes de iniciar os containers, ajuste as configurações do arquivo .env conforme suas necessidades. Copie o arquivo de exemplo .env.example para .env se ainda não tiver um:

  ```bash
  cp .env.example .env
  ```
  Edite o arquivo .env com as configurações desejadas.

4. **Inicie os containers Docker**:

  Execute o comando abaixo para iniciar os containers e configurar o ambiente
  ```bash
    sail up -d
  ```
  isso ira contruir e iniciar os constainers definidos no arquivo `docker-compose.yml`.

5. **Execute as migrations e seeders do banco de dados**:

  Após iniciar os containers, execute o comando para executar as migrations e seeders do banco de dados:

  ```bash
    sail artisan migrate --seed
  ```

6. Acesse a aplicação:
  Por padrão, o Laravel sail expõe sua aplicação na porta 80. Você pode acessar a aplicação no seguinte endereço

  ```bash
  http://localhost
  ```

7. **Parar os containers**:
  Para parar os containers você pode usar o seguinte comando:
  ```bash
    sail down
  ```


# Comandos Adicionais

**Executar comandos Artisan:**
```bash
sail artisan <comando>
```


**Executar comandos Composer:**

```bash
sail composer <comando>
```


**Abrir um shell dentro do container:**

```bash
sail shell
```


# Resolução de Problemas
**Se você encontrar problemas, verifique o seguinte:**

- Certifique-se de que Docker e Docker Compose estão corretamente instalados e em execução.
- Verifique se nenhum outro serviço está usando a porta 80 ou qualquer outra porta definida no docker-compose.yml.
- Em caso de erro de permisão, certifique-se de estar usando o Docker Engine e não o Docker Desktop, onde o mesmo roda os comandos com um usuario destinto ao do sistema.