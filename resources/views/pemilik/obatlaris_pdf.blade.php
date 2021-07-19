<!DOCTYPE html>
<html>
<head>
	<title>Laporan Obat Terlaris</title>
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
		<h4>Data Obat Terlaris</h4>
		<h6><a target="_blank" href="https://www.malasngoding.com/membuat-laporan-…n-dompdf-laravel/">Apotek Persada</a></h5>
	    <h6><a target="_blank" href="https://www.malasngoding.com/membuat-laporan-…n-dompdf-laravel/">{{Session::get('tgl1')}} Sampai {{Session::get('tgl2')}} </a></h5>
    </center>
 
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>#</th>
				<th>Obat</th>
				<th>Jumlah Terjual</th>
			</tr>
		</thead>
		<tbody>
			@php $i=1 @endphp
			@foreach($data as $p)
			<tr>
				<td>{{ $i++ }}</td>
				<td>{{$p->nama_obat}}</td>
				<td>{{$p->c}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</body>
</html>