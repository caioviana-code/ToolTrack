@extends('templates.middleware', [
'titulo' => "Ferramentas",
'rota' => "ferramentas.create"
])

@section('titulo') Ferramentas @endsection

@section('conteudo')

<head>
    <meta charset="utf-8">
    <script src="{{ asset('js/app.js') }}" defer></script>

    <style>
        .div-filtro {
            display: flex;
            align-items: center;
        }

        /* Estilos para o campo de texto */
        #filtro {
            flex-grow: 1;
            /* Ocupa o espaço restante */
            margin-right: 10px;
            /* Margem à direita para separar do seletor */
        }

        /* Estilos para o seletor */
        #coluna {
            width: 180px;
            /* Ajuste o tamanho conforme necessário */
        }  

        .css-button {
            padding: 5px 10px;
            font-size: 10px;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            background-color: #247BA0;
            color: #fff;
        }

        .css-button:hover {
            background-color: #2980b9;
        }
    </style>

</head>

<div>

    <div class="mb-3 div-filtro">

        <select id="coluna" class="form-select">
            <option value="nome">Nome</option>
            <option value="tipo">Tipo</option>
            <option value="marca">Marca</option>
        </select>

        <input type="text" class="form-control" id="filtro" placeholder="Filtro" />

        <!-- Adiciona um botão para escolher a coluna -->
    </div>

    <table class="table align-middle caption-top table-striped">

        <thead>
            <tr>
                <th scope="col">Nome</th>
                <th scope="col" class="d-none d-md-table-cell">Tipo</th>
                <th scope="col">Marca</th>
                <th scope="col" class="d-none d-md-table-cell">Disponível</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
            <tr class="row-filtro">
                <td data-coluna="nome">{{ $item->nome }}</td>
                <td data-coluna="tipo">{{ $item->tipo }}</td>
                <td data-coluna="marca">{{ $item->marca }}</td>
                <td>{{ $item->quantidadeDisponivel }}</td>
                <td>
                    <a href="{{ route('ferramentas.edit', $item->id) }}" class="btn">
                        <button class="ml-3 css-button">
                            Editar
                        </button>
                    </a>

                    <a nohref style="cursor:pointer" onclick="showInfoModal
                    ('NOME: {{ $item->nome }}', 
                    'TIPO: {{ $item->tipo }}',
                    'MARCA: {{ $item->marca }}',
                    'QUANTIDADE DISPONIVEL: {{ $item->quantidadeDisponivel }}',
                    'QUANTIDADE EMPRESTADA: {{ $item->quantidadeEmprestada }}',
                    'QUANTIDADE RESERVADA: {{ $item->quantidadeReservada }}'
                    )",           
                    class="btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#247BA0" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                        </svg>
                    </a>

                    <a nohref style="cursor:pointer" onclick="showRemoveModal('{{ $item['id'] }}', '{{ $item['nome'] }}')" class="btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#247BA0" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                        </svg>
                    </a>

                </td>
                <form action="{{ route('ferramentas.destroy', $item['id']) }}" method="POST" id="form_{{$item['id']}}">
                    @csrf
                    @method('DELETE')
                </form>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

<script>
    // Captura o campo de entrada
    const filtroNomeInput = document.getElementById('filtro');

    // Captura a lista suspensa
    const colunaSelect = document.getElementById('coluna');

    // Adiciona um ouvinte de eventos de entrada para o campo de entrada
    filtroNomeInput.addEventListener('input', () => {
        const filtro = filtroNomeInput.value.toLowerCase();
        const colunaSelecionada = colunaSelect.value; // Obtém a coluna selecionada
        const linhas = document.querySelectorAll('.row-filtro');

        // Itera pelas linhas e oculta/mostra com base na coluna selecionada
        linhas.forEach((linha) => {
            const valorColuna = linha.querySelector(`td[data-coluna="${colunaSelecionada}"]`).textContent.toLowerCase();
            if (valorColuna.includes(filtro)) {
                linha.style.display = 'table-row';
            } else {
                linha.style.display = 'none';
            }
        });
    });
</script>

@endsection