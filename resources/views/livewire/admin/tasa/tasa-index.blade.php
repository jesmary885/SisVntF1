<div>
    <div class="card-body">
        <table class="table table-striped table-responsive-md table-responsive-sm">
            <thead class="thead-dark">
                <tr>
                    <th class="text-center">Moneda</th>
                    <th class="text-center">Tasa registrada</th>  
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach ($tasas as $tasa)
                <tr>
                    <td class="text-center">{{$tasa->moneda->nombre}} {{$tasa->moneda->simbolo}}</td>
                    <td class="text-center">{{$tasa->tasa}}</td>
                    <td width="10px">
                        @livewire('admin.tasa.tasa-edit', ['tasa' => $tasa],key($tasa->id))
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>




    
