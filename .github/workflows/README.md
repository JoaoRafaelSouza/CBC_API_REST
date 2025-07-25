# CBC_API_REST

API REST em PHP com Docker, MySQL e CI/CD via GitHub Actions.

## CI/CD com GitHub Actions

Este projeto possui uma pipeline automatizada de **Integração Contínua (CI)** usando **GitHub Actions**, que realiza os seguintes passos:

### Quando a pipeline é executada?

- A cada `push` no branch `main`
- A cada `pull request` enviado para `main`

## Etapas do CI

checkout -> Clona o repositório para o runner GitHub 
php -l -> Verifica se o index.php possui erros de sintaxe
docker compose up -> Constrói os containers e inicia a aplicação com Dockerfile e docker-compose.yml
curl localhost:8080 -> Verifica se a API responde corretamente
docker compose down -> Finaliza e remove os containers após o teste                            |

## Estrutura CI/CD

O workflow está localizado em:
.github/workflows/ci-cd.yml