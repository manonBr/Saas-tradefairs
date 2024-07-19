<table with="100" class="table-minimalist">
    <thead>
        <tr>
            @foreach($content['table-label'] as $labelTable)
                <th>{{$labelTable}}</th>
            @endforeach
            <th width="70" colspan="{{ (isset($editable) && $editable) ? '2' : ''}}"></th>
        </tr>
        <tr>
            <form action="{{ route($content['page'] . '-add') }}" method="post" id='form'>
                @csrf
                @if($content['table-label'][0] == 'ID')
                    <td></td>
                @endif
                @isset($content['form'])
                    @foreach($content['form'] as $form)
                    <td>
                        @if($form['format'] === 'input')
                            @include('components.form.input', $form)
                        @else
                            @include('components.form.' . $form['format'], $form)
                        @endif
                    </td>
                    @endforeach
                    <td class="center" colspan="{{ (isset($editable) && $editable) ? '2' : ''}}">
                        <button class="btn btn--secondary">Ajouter</button>
                    </td>
                @endisset
            </form>
        </tr>
    </thead>
    <tbody>
        @if($datas)
            @foreach($datas as $data)
                <tr>
                    @foreach($content['columns'] as $column)
                        <td>
                            @if($column === 'active')
                                <form action="{{ route($content['page'] . '-updateStatus', [$data->id, $data->active]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn {{$data->$column === 1 ? 'btn--success' : 'btn--alert'}} btn--light">
                                        {!!$data->$column === 1 ? '<span class="icon-checkmark"></span>' : '<span class="icon-cross"></span>'!!}
                                    </button>
                                </form>
                            @else
                                {{$data->$column}}
                            @endif    
                        </td>
                    @endforeach
                    @if(isset($editable) && $editable)
                        <td class="center">
                            <form action="{{ route($content['page'] . '-ajaxrequest', $data->id) }}" method="POST" data-formname="form-{{$content['page']}}" onSubmit="return ajaxRequest(event, this)">
                                @csrf
                                <button type="submit" class="btn btn--primary btn--light"><span class="icon-pencil"></span></button>
                            </form>
                        </td>
                    @endif
                    <td class="center">
                        <form action="{{ route($content['page'] . '-delete', $data->id) }}" method="POST"  onSubmit="return displayConfirmModal()">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn--alert btn--light"><span class="icon-bin"></span></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>

@isset($content['form'])
    <div class="ajaxRequest hidden ajaxRequest-{{$content['page']}}">
        <span class="icon-cross close" onclick="closeModal(this)"></span>
        <h2>MODIFICATION : {{$content['title']}}</h2>
        <form action="{{ route($content['page'] . '-update') }}" method="post" id='form-{{$content["page"]}}'> <!-- UPDATE ROUTE -->
            @csrf
            <input type="hidden" name="id" required />
            @foreach($content['form'] as $form)
                <div>
                    @if($form['format'] === 'input')
                        @include('components.form.input', $form)
                    @else
                        @include('components.form.' . $form['format'], $form)
                    @endif  
                </div>
            @endforeach
                <button class="btn btn--secondary">Mettre à jour</button>
        </form>
    </div>
@endisset