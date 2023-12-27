
<table>
    <thead>
    <tr>
        <th>Resident</th>
    </tr>
    <tr>
        <th>tanggal</th>
        <th>No.Transaksi</th>
        <th>Nama</th>
        <th>No.KK</th>
        <th>No.Rumah</th>
        <th>Jumlah (Rp/kg)</th>
        <th>Tipe Barang</th>
        <th>Deskripsi</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    @foreach($residentTransactions as $transaction)
        <tr>
            <td>{{$transaction->created_at->format('Y-m-d')}}</td>
            <td>{{$transaction->id}}</td>
            <td>{{$transaction->donor->name}}</td>
            <td>{{$transaction->donor->donorable->no_kk}}</td>
            <td>{{$transaction->donor->donorable->house_number}}</td>
            <td>{{$transaction->amount}}</td>
            <td>{{$transaction->donationType->name}}</td>
            <td>{{$transaction->description}}</td>
            <td>{{$transaction->completed}}</td>
        </tr>
    @endforeach
    </tbody>

    <thead>
    <tr>
        <th>Resident</th>
    </tr>
    <tr>
        <th>tanggal</th>
        <th>No.Transaksi</th>
        <th>Nama</th>
        <th>Jumlah (Rp/kg)</th>
        <th>Tipe Barang</th>
        <th>Deskripsi</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    @foreach($guestsTransactions as $transaction)
        <tr>
            <td>{{$transaction->created_at->format('Y-m-d')}}</td>
            <td>{{$transaction->id}}</td>
            <td>{{$transaction->donor->name}}</td>
            <td>{{$transaction->amount}}</td>
            <td>{{$transaction->donationType->name}}</td>
            <td>{{$transaction->description}}</td>
            <td>{{$transaction->completed}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
