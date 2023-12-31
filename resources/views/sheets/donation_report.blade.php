
<table style="border: 1px solid #000; border-collapse: collapse">
    <thead>
    <tr style="">
        <th colspan="9" style="
        font-size: 16px;
        color: blue;
        padding: 10px;
        text-align: center; ">Resident</th>
    </tr>
    <tr>
        <th rowspan="2">tanggal</th>
        <th rowspan="2">No.Transaksi</th>
        <th rowspan="2">Nama</th>
        <th colspan="2">informasi</th>
        <th colspan="2">Jumlah</th>
        <th class="multiline" rowspan="2">Deskripsi</th>
        <th rowspan="2">Status</th>
    </tr>
    <tr>
        <th>No.Rumah</th>
        <th>No.KK</th>
        <th>Uang (Rp)</th>
        <th>Beras (kg</th>
    </tr>
    </thead>
    <tbody>
    @foreach($residentTransactions as $transaction)
        <tr>
            <td>{{$transaction->created_at->format('Y-m-d')}}</td>
            <td>{{$transaction->id}}</td>
            <td>{{$transaction->donor->name}}</td>
            <td>{{$transaction->donor->donorable->house_number}}</td>
            <td>{{$transaction->donor->donorable->no_kk}}</td>
            <td>{{$transaction->goodType->name === 'UANG' ? $transaction->amount : 0}}</td>
            <td>{{$transaction->goodType->name === 'BERAS' ? $transaction->amount : 0}}</td>
            <td>{{$transaction->description}}</td>
            <td>{{$transaction->completed}}</td>
        </tr>
    @endforeach
    </tbody>
</table>

