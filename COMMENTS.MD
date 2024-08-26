# COMMENTS.md

## Decisão da Arquitetura Utilizada

A arquitetura do projeto foi estruturada seguindo os princípios de design em camadas, utilizando repositories, interfaces, e services para desacoplar a lógica de negócios, persistência de dados, e manipulação de requisições HTTP. Essa abordagem promove um código mais modular, testável, e fácil de manter.

- Repositories: Foram utilizados para encapsular a lógica de acesso aos dados, facilitando a troca ou extensão das fontes de dados sem impactar outras partes do sistema.
- Interfaces: Serviram como contratos para as implementações das camadas de repositories e services, facilitando a injeção de dependências e promovendo a flexibilidade do código.
- Services: Centralizaram a lógica de negócios, permitindo que os controladores se focassem apenas na manipulação das requisições HTTP e delegassem operações mais complexas aos services.

## Lista de Bibliotecas de Terceiros Utilizadas

- **laravel/framework**: Framework principal para o desenvolvimento do backend, fornecendo uma estrutura robusta e ferramentas essenciais para a construção de APIs.
- **ramsey/uuid**: Biblioteca para geração de UUIDs, garantindo identificadores únicos para usuários e outros recursos dentro da aplicação.

## O Que Você Melhoraria Se Tivesse Mais Tempo

- **Implementação de Roles e Permissions**: Adicionaria um sistema de gerenciamento de papéis e permissões para controle de acesso.
- **Cobertura de Testes Mais Abrangente**: Ampliaria a cobertura dos testes, para garantir a estabilidade e confiabilidade da aplicação.
- **Melhoria na Documentação**: Adicionaria documentacão da API utilizando por exemplo Swagger.
- **Monitoramento e Logging Avançado**: Integraria ferramentas de monitoramento e logging mais avançadas para melhor rastreamento de erros e performance da aplicação.
- **Servico de Authentication**: Poderia ter sido feito o servico de autenticacao, citado no exemplo.

## Quais Requisitos Obrigatórios Que Não Foram Entregues

- Creio que todos os items do minimo foram atendidos.
