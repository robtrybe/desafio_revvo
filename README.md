# Desafio Revvo


## Informações do Desenvolvedor

`Nome:`  Robson de Jesus Narcizo
`Email:` rob.narcizo.27@gmail.com
`Celular` (16) 99145-9236

## Sobre o desafio proposto

A aplicação foi construida utilizando `Docker`. Por esse motivo é necessário ter o `Docker` junto com 
`Docker Compose`. A mesma é acessada através da url `http://localhost:8000`.Antes de acessar é necessário
executar o seguinte comando no terminal:

```bash
    docker-compose up -d
```

Caso não consiga acessar a aplicação será necessario executar o  comando `composer install` dentro do container no diretório `raiz`.

`CRUD`

`OBS:` O `CRUD` é feito atrvés da técnica de `Form Spoofing` utilizando o método `POST` para 
acesso aos outros verbos.

A primeira `/admin` ou `Dashboard` via método `GET` onde é possivel ver todos os cursos nos seus respectivos cards. Através da dash é possivel `acessar` ou `editar` os cursos.

A sugunda `/admin/course/id_do_curso/edit` para edição de um curso via método `POST`. Na aplicação a edição
de um curso é feita utilizando a mesma rota porém via método `GET`.

A terceira `/admin/course/id_do_curso` para remoção de um curso via método `POST`. Na aplicação, a exclusão
de um curso pode ser feito através da rota de edição.

A rota `/course/id_curso` via método `GET` é utilizada para visualização de um curso específico tanto.A imagem contida em cada curso é responsiva se adaptando a diferentes resoluções poupando recursos do servidor.

## Web

A parte `Web` da aplicação possui duas rotas

A primeira `/` para renderização da `Página Home`

A segunda `/course/{id}` para visualização de um `Curso específico`.

`OBS:` A parte `Web` da aplicação encontra-se estática no momento, porém responsiva. O preenchimento dos
cursos foram feito utilizando `estrutura de repetição`, porém a página se adapta a dispositivos moveis, ou 
seja , utilizando `Mobile First`. Infelizmente devido ao tempo não foi possível finalizar a alimentação por completo.



