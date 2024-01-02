
<table style="border: 1px solid #000; border-collapse: collapse">
    <thead>
    <tr style="">
        <th colspan="9" style="
        font-size: 16px;
        color: #4795bf;
        padding: 10px;
        text-align: center; ">Resident</th>
    </tr>
    <tr>
        <th style="border: lightslategray" rowspan="2">No</th>
        <th style="border: lightslategray" rowspan="2">Tanggal</th>
        <th style="border: lightslategray" rowspan="2">No.Transaksi</th>
        <th style="border: lightslategray" rowspan="2">Nama</th>
        <th style="border: lightslategray" colspan="2">informasi</th>
        <th style="border: lightslategray" colspan="2">Jumlah</th>
        <th style="border: lightslategray" class="multiline" rowspan="2">Deskripsi</th>
        <th style="border: lightslategray" rowspan="2">Status</th>
    </tr>
    <tr>
        <th style="border: lightslategray">No.Rumah</th>
        <th style="border: lightslategray">No.KK</th>
        <th style="border: lightslategray">Uang (Rp)</th>
        <th style="border: lightslategray">Beras (kg)</th>
    </tr>
    </thead>
    <tbody>
    @php
        $counter = 1;
        $totalUang = 0;
        $totalBeras = 0;
    @endphp
    @foreach($residentTransactions as $transaction)
        <tr style="border: lightslategray">
            <td>{{$counter}}</td>
            <td>{{$transaction->created_at->format('Y-m-d')}}</td>
            <td>{{$transaction->id}}</td>
            <td>{{$transaction->donor->name}}</td>
            <td>{{$transaction->donor->donorable->house_number}}</td>
            <td>{{$transaction->donor->donorable->no_kk}}</td>
            <td>{{$transaction->goodType->name === 'UANG' ? $transaction->amount : null}}</td>
            <td>{{$transaction->goodType->name === 'BERAS' ? $transaction->amount : null}}</td>
            <td>{{$transaction->description}}</td>
            <td>{{$transaction->completed ? 'Selesai' : 'Belum Selesai'}}</td>
        </tr>
        @php
            $counter++;
            $transaction->goodType->name === 'UANG' ? $totalUang += $transaction->amount : $totalBeras += $transaction->amount
        @endphp
    @endforeach
    <tr>
        <td colspan="6">Total</td>
        <td>{{$totalUang}}</td>
        <td>{{$totalBeras}}</td>
        <td colspan="2"></td>
    </tr>
    </tbody>
</table>

