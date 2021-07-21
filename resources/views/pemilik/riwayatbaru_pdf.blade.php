<!DOCTYPE html>
<html>
<head>
	<title>Laporan Invoice Penjualan</title>
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
		<h4>Data Invoice Penjualan</h4>
		<h6><a>Apotek Persada</a></h5>
	    <h6><a">{{Session::get('tgl1')}} Sampai {{Session::get('tgl2')}} </a></h5>
    </center>
    <table class='table'>
		<thead>
			<tr>
				<th>#</th>
				<th>Inv</th>
				<th>Jenis Obat</th>
				<th>Grand Total</th>
			</tr>
		</thead>
		<tbody>
			@php 
			$no=1 ;
			@endphp
			
		

    @php
    $jmlobat = 0;
    $jmltrx = 0;
    $pendapatan = 0;
    $laba = 0;
    @endphp
 	@foreach ($data as $r)
 			<tr>
				<td>{{ $no++ }}</td>
				<td>{{$r->inv}}</td>
				<td>{{$r->jenis}}</td>
				<td>Rp. {{ number_format($r->grand_total,0, ',' , '.')}},-</td>
			</tr>
	
<!-- 
 	<p>______________________________________________________________________</p>
 	<h5>{{$r->inv}}</h5>
 	<p>Tanggal : {{$r->tanggal}}</p>
 	<p>Kasir   : {{$r->nama}} || Obat {{$r->jenis}}</p> -->
 	@php
 	$pendapatan = $pendapatan + $r->grand_total;
 	$jmltrx = $jmltrx +1;

 	$detail = DB::select("select a.id_detail, b.nama_obat, a.harga_jual, a.harga_beli, a.qty, (a.harga_jual*a.qty) as total from detail_transaksi a, obat b where a.id_obat=b.id_obat and inv='$r->inv' ");
 	@endphp
	<!-- <table class='table'>
		<thead>
			<tr>
				<th>#</th>
				<th>Obat</th>
				<th>Qty</th>
				<th>H. Jual</th>
				<th>Sub Total</th>
			</tr>
		</thead>
		<tbody> -->
			@php 
			$i=1 ;
			$grandtotal = 0;
			@endphp
			@foreach($detail as $p)
			@php
			$grandtotal = $grandtotal + $p->total;
			$jmlobat = $jmlobat + $p->qty;
			$laba = $laba + (($p->harga_jual - $p->harga_beli)*$p->qty);
			@endphp
			<!-- <tr>
				<td>{{ $i++ }}</td>
				<td>{{$p->nama_obat}}</td>
				<td>{{$p->qty}}</td>
				<td>{{$p->harga_jual}}</td>
				<td>{{$p->total}}</td>
			</tr> -->
			@endforeach
		<!-- </tbody>
	</table>
	<h5>Total Pembelian : Rp. {{ number_format($grandtotal,0, ',' , '.')}},-<</h5> -->
	@endforeach
		</tbody>
	</table>
	<br><br><br>
	<center><h4>Ringkasan</h4></center>
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>Pendapatan</th><th>:</th><th>Rp. {{ number_format($pendapatan,0, ',' , '.')}},-</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Jumlah Transaksi</td>
				<td>:</td>
				<td>{{$jmltrx}}</td>
			</tr>
			<tr>
				<td>Laba Bersih</td>
				<td>:</td>
				<td>{{$laba}}</td>
			</tr>
			<!-- <tr>
				<td>Jumlah Obat Terjual</td>
				<td>:</td>
				<td>{{$jmlobat}}</td>
			</tr> -->
		</tbody>
	</table>	
</body>
</html>