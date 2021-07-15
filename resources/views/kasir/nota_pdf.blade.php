<!DOCTYPE html>
<html>
<head>
	<title>Nota Penjualan</title>
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
		<h4>Apotek Persada</h4>
		<h6>Jl. PK Bangsa 17, Pare, Kediri </h6>
	    <h6>Telp : 0857 3664 5542 || email : persadapare@gmail.com </h6>
  </center>
  <p>---------------------------------------------------------------------------------</p>
  
	<div class="box-body no-padding">
 <table>
 @foreach ($transaksi as $t)
                <tr>
                  <th>Tgl Transaksi</th>
                  <th>: {{$t->tanggal}}</th>
                </tr>
                <tr>
                  <td>No.Nota</td>
                  <td>: {{$t->inv}}</td>
                </tr>
                <tr>
                  <td>Jenis</td>
                  <td>: {{$t->jenis}}</td>
                </tr>
                <tr>
                  <td>Kasir</td>
                  <td>: {{$t->nama}}</td>
                </tr>
  @endforeach
              </table>
  <p>---------------------------------------------------------------------------------</p>
  
        
                    <table>
                <tr>
                  <th style="width: 200px">Obat</th>
                  <th style="width: 80px">Qty</th>
                  <th style="width: 80px">SubTotal</th>
                </tr>
          @foreach ($detail as $d)
                <tr>
                  <td>{{$d->nama_obat}}</td>
                  <td>{{$d->qty}} @ {{number_format($d->harga_jual,0)}}</td>
                  <td>{{number_format($d->total,0)}}</td>
                </tr>
          @endforeach
            </table>
            
  <p>---------------------------------------------------------------------------------</p>
          @foreach ($transaksi as $t)
              <table>
                <tr>
                  <th style="width: 280px">Total</th>
                  <th style="width: 80px">Rp. {{number_format($t->grand_total,0)}},-</th>
                </tr>
                <tr>
                  <td style="width: 280px">Bayar</td>
                  <td>Rp. {{number_format($t->bayar,0)}},-</td>
                </tr>
                <tr>
                  <td style="width: 280px">Kembali</td>
                  <td>Rp. {{number_format($t->kembali,0)}},-</td>
                </tr>
          @endforeach
              </table>
  <p>---------------------------------------------------------------------------------</p>
            <center><h6>~ Terimakasih atas kunjungan anda~</h6></center>
            </div>
</body>
</html>