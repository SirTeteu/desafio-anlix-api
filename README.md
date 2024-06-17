# Setup do ambiente

*Executar no gitbash ou em um terminal com suporte a execução de scripts bash*
````
git clone https://github.com/SirTeteu/desafio-anlix-api.git
cd desafio-anlix-api/
cp .env-example .env
````

Iniciar aplicação  
``sudo docker compose up --build`` ou ``sudo docker compose up -d --build``

# Rotas de API

A aplicação tem os seguintes endpoints:
````
http://localhost:8000/api/paciente/index
Lista todos os pacientes. É possível adicionar os seguintes parâmetros:
- nome (filtra os pacientes pelo nome)
- latest-cardiaco-indice = 1 (acrescenta o indice cardiaco mais recente registrado)
- latest-pulmonar-indice = 1 (acrescenta o indice cardiaco mais recente registrado)
````

````
http://localhost:8000/api/paciente/{pacienteId}/detail
Detalha os dados de um paciente com os indices cardiaco e pulmonar mais recentes
````

````
http://localhost:8000/api/paciente/index-by-date
Lista todos os pacientes que possuem indices registrados em um dia. Para utilizá-la é necessário passar o parâmetro *data* no formato yyyy-mm-dd
````


````
http://localhost:8000/api/paciente/{pacienteId}detail-date-range
Detalha os indices registrados dentro de um range de datas para um paciente. Para utilizá-la é necessário passar os seguintes parâmetros:
- data_inicio (no formato yyyy-mm-dd)
- data_fim (no formato yyyy-mm-dd)
- cardiaco-indice = 1 (para listar o indice cardiaco mais recente)
- pulmonar-indice = 1 (para listar o indice pulmonar mais recente)
PS: nunca adicione os dois indices, mas sempre pelo menos um
````

````
http://localhost:8000/api/paciente/{pacienteId}detail-latest-in-date-range
Detalha os indices registrados mais recentes dentro de um range de datas para um paciente. Para utilizá-la é necessário passar os seguintes parâmetros:
- data_inicio (no formato yyyy-mm-dd)
- data_fim (no formato yyyy-mm-dd)
- cardiaco-indice = 1 (para listar o indice cardiaco mais recente)
- pulmonar-indice = 1 (para listar o indice pulmonar mais recente)
PS: nunca adicione os dois indices, mas sempre pelo menos um 
````
