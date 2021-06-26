<!DOCTYPE html>
<html>
<head>
	<title>Laporan Pengadaan</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>
	<center>
		<h4>Data Pengadaan Obat</h4>
		<h6><a target="_blank" href="https://www.malasngoding.com/membuat-laporan-…n-dompdf-laravel/">Apotek Persada</a></h5>
	    <h6><a target="_blank" href="https://www.malasngoding.com/membuat-laporan-…n-dompdf-laravel/">{{Session::get('tgl1')}} Sampai {{Session::get('tgl2')}} </a></h5>
    </center>
 
	<table id="example1" class="table table-bordered">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Supplier</th>
                  <th>Obat</th>
                  <th>Jumlah</th>
                  <th>H. Beli</th>
                  <th>Total</th>
                  <th>Stok Awal</th>
                  <th>Stok Akhir</th>
                  <th>Kadaluarsa</th>
                  <th>Tgl Masuk</th>
                </tr>
                </thead>
                <tbody>
                @php
                $i = 1;
                @endphp
                @foreach ($data as $datas)                        
                <tr>
                  <td>{{$i++}}</td>
                  <td>{{$datas->nama_supplier}}</td>
                  <td>{{$datas->nama_obat}}</td>
                  <td>{{$datas->jumlah}}</td>
                  <td>{{$datas->harga_beli}}</td>
                  <td>{{$datas->total}}</td>
                  <td>{{$datas->stok_awal}}</td>
                  <td>{{$datas->stok_akhir}}</td>
                  <td>{{$datas->tgl_kadaluarsa}}</td>
                  <td>{{$datas->tgl_masuk}}</td>
                  </tr>
        
        <!-- /.modal-dialog -->
                @endforeach
                </tbody>
                
              </table>
</body>
</html>