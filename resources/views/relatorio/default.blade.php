<!doctype html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <title>Relatório</title>
        <meta name="description" content="">
        <style media="all" rel="stylesheet">

            @page{
                size: landscape;
            }

            table{
                width: 29.7cm;
                text-align: left;
                border-collapse: collapse;
                font-size: 12px;
            }
            th{
                border: 1px solid #000;
                text-align: left;
            }
            tr td, tr th{
                border: 1px solid #000;
                padding: 3px;
            }
        </style>

    </head>
    <body>
    @if(count($itens) > 0)

        <h3>Relatório de Equipamentos</h3>
        <p><b>Tipo:</b> {{$itens['configuracao']['tipoRelatorio']}}</p>

    <table style="width: 100%">
        <thead>
        <tr>
            <th style="width: 2%">
                #
            </th>
            <th>
                Nº Série
            </th>
            <th>
                Proprietário
            </th>
            @if(Input::get('tipoEquipamento') != 3 && Input::get('tipoEquipamento') != 4 && Input::get('tipoEquipamento') != 6 )
            <th>
                Patrimônio
            </th>
            @endif
            @if(Input::get('tipoEquipamento') == 1 || Input::get('tipoEquipamento') == 8)
            <th>
                Nome do computador
            </th>
            <th>
                Sistema Operacional
            </th>
            @endif
            <th>Setor</th>
            <th>
                Status
            </th>
        </tr>
        </thead>
        @foreach($itens['registros'] as $key => $i)
        @if(isset($i['agrupador']))
        <tr>
            <td style="padding-top: 15px;border-left:0px; border-right: 0px;" colspan="{{$itens['configuracao']['colspan']}}"><b>{{$i['agrupador']}}:</b> {{$i['nome']}}</td>
        </tr>
        @else
        <tr>
            <td>
                {{$i['sequencia']}}
            </td>
            <td>
                {{$i['numeroSerie']}}
            </td>
            <td>
                {{$i['proprietarioNome']}}
            </td>
            @if(Input::get('tipoEquipamento') != 3 && Input::get('tipoEquipamento') != 4 && Input::get('tipoEquipamento') != 6 )
            <td>
                {{($i['patrimonio']) ? $i['patrimonio'] : '---'}}
            </td>
            @endif
            @if(Input::get('tipoEquipamento') == 1 || Input::get('tipoEquipamento') == 8)
                <td>
                    {{$i['nomeComputador']}}
                </td>
                <td>
                    {{$i['sistemaOperacional']}}
                </td>
            @endif
            <td>{{($i['setor'])}}</td>
            <td>
                {{$i['statusNome']}}
            </td>
        </tr>
            @endif
        @endforeach
    </table>
    <hr/>
    Total de registros encontrados: {{$itens['configuracao']['totalRegistro']}}
    <p>Data: {{date('d/m/Y')}}</p>
    @else
        <p>Nenhum registro encontrato</p>
    @endif
    </body>
</html>