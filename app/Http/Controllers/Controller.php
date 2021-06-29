<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Session;
use PDF;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


     public function login(){
        if (Session('login')==true) {
            return redirect("/dashboard");
        }else{
            return view("General/login");    
        }
        
    }


    public function logout(){
            Session::flush();
            return redirect('/auth');
               
    }
    
	public function actionLogin(Request $request){
        $dat['login']['login']=false;
        $username = $request->username;
        $password = $request->password;
        
        Session::flush();
       $data = DB::select("SELECT a.id_user, a.nama, a.username,a.password,b.level, a.id_level
                from user a, level b 
                where a.username='$username' and a.password ='$password' and a.id_level=b.id_level and aktif=1");

        foreach ($data as $key) {
                $level = $key->level;
                $nama = $key->nama;
                $username = $key->username;
                $password = $key->password;
                $id_user = $key->id_user;
                $id_level = $key->id_level;
        };
        if(count($data) > 0){
            Session::put('login',true);
            Session::put('level',$level);
            Session::put('id_user',$id_user);
            Session::put('username',$username);
            Session::put('id_level',$id_level);
            Session::put('login',true);
            Session::put('password',$password);
            Session::put('nama',$nama);
            Session::put('message',"Benar");
            return redirect("/dashboard");
            } else {
           // Session::put('message',"Username & Password tidak seusai");
            return redirect()->back()->with('alert', 'Password Salah!!!');   
            }
        }
    public function dashboard(){
            if(Session('login')==true && Session('level')=="pemilik"){
                return view("pemilik/dashboard");
            }else if(Session('login')==true && Session('level')=="adminobat"){
                return view("adminobat/dashboard");
            }else if(Session('login')==true && Session('level')=="pengadaan"){
                return view("pengadaan/dashboard");
            }else if(Session('login')==true && Session('level')=="kasir"){
                return view("kasir/dashboard");
            }else{
                return redirect('/auth');
            }   
    }



    //controller pemillik
    public function pemilikuser(){
        if(Session('login')==true && Session('level')=="pemilik"){
            $data = DB::select("SELECT a.id_user, a.nama, a.username,a.password,b.level, a.id_level
            from user a, level b 
            where a.id_level=b.id_level and aktif=1");
            
            return view("pemilik/user",['data'=>$data]);

        }else{
            return redirect('/auth');
        }   
    }
    public function pemilikrekomendasi(){
        if(Session('login')==true && Session('level')=="pemilik"){
            $datausia = DB::select("SELECT  *,TIMESTAMPDIFF(DAY,now(),tgl_kadaluarsa) as usia from obat a, kategori b where a.id_kategori=b.id_kategori and TIMESTAMPDIFF(DAY,now(),tgl_kadaluarsa) <= selisih and a.aktif=1");
            $datastok = DB::select("SELECT  * from obat a, kategori b where a.id_kategori=b.id_kategori and a.stok <= a.stokMinimal and a.aktif=1");
            return view("pemilik/rekomendasi",['datausia'=>$datausia,'datastok'=>$datastok]);
        }else{
            return redirect('/auth');
        }   
    }
    public function pemilikpengadaan(){
        if(Session('login')==true && Session('level')=="pemilik"){
            $query = "SELECT a.id_penyetokan, c.nama_supplier, b.nama_obat, a.jumlah, a.harga_beli, a.total,
            a.stok_awal,a.stok_akhir, a.tgl_masuk, a.tgl_kadaluarsa from penyetokan a, obat b, supplier c where a.id_supplier=c.id_supplier 
            and a.id_obat=b.id_obat AND DATE(tgl_masuk) = CURDATE()";
            $data = DB::select($query);
            Session::put('tgl1',date("Y-m-d"));
            Session::put('tgl2',date("Y-m-d"));
            Session::put('querypengadaan',$query);
            return view("pemilik/pengadaan",['data'=>$data]);
        }else{
            return redirect('/auth');
        }   
    }
    public function pemilikpenjualan(){
        if(Session('login')==true && Session('level')=="pemilik"){
            $query = "select * from detail_transaksi a, transaksi b, obat c where a.id_obat=c.id_obat AND a.inv=b.inv AND DATE(tanggal) = CURDATE()";
            $data = DB::select($query);
            Session::put('tgl1',date("Y-m-d"));
            Session::put('tgl2',date("Y-m-d"));
            Session::put('querypenjualan',$query);
            return view("pemilik/penjualan",['data'=>$data]);
        }else{
            return redirect('/auth');
        }   
    }
    public function searchpemilikuser(Request $request){
        if(Session('login')==true && Session('level')=="pemilik"){
            $query = "SELECT a.id_user, a.nama, a.username,a.password,b.level, a.id_level
            from user a, level b 
            where a.id_level=b.id_level and aktif=1 and a.nama LIKE '%$request->q%' and a.id_level LIKE '%$request->id_level%'";
            $data = DB::select($query);
            
            return view("pemilik/user",['data'=>$data]);

        }else{
            return redirect('/auth');
        }   
    }
    public function searchpemilikpenjualan(Request $request){
        $tgl1 = "";
        $tgl2 = "";
        if($request->tgl1 == "" || $request->tgl1 == null ){
            $tgl1 = date("Y-m-d");
            Session::put('tgl1', $tgl1);            
            $tgl1 = $tgl1." 00:00:00";
        }
        if($request->tgl1 != "" || $request->tgl1 != null ){
            $tgl1 = $request->tgl1;
            $tgl1 = str_replace("/","-",$tgl1);
            $tgl1 = date('Y-m-d',strtotime($tgl1));
            Session::put('tgl1', $tgl1);            
            $tgl1 = $tgl1." 00:00:00"; 
        }
        if($request->tgl2 == "" || $request->tgl2 == null){
            $tgl2 = date("Y-m-d");
            Session::put('tgl2', $tgl2);            
            $tgl2 = $tgl2." 23:59:59";
        }
        if($request->tgl2 != "" || $request->tgl2 != null){
            $tgl2 = $request->tgl2;
            $tgl2 = str_replace("/","-",$tgl2);
            $tgl2 = date('Y-m-d',strtotime($tgl2));
            Session::put('tgl2', $tgl2);            
            $tgl2 = $tgl2." 23:59:59";
        }
        if(Session('login')==true && Session('level')=="pemilik"){
            $query = "select * from detail_transaksi a, transaksi b, obat c where a.id_obat=c.id_obat AND a.inv=b.inv AND id_transaksi >= UNIX_TIMESTAMP('$tgl1') 
            AND id_transaksi <= UNIX_TIMESTAMP('$tgl2') AND nama_obat LIKE '%$request->q%' ";
            
            Session::put('querypenjualan', $query);            

            $data = DB::select($query);
            return view("pemilik/penjualan",['data'=>$data]);
        }else{
            return redirect('/auth');
        }

    }
    public function searchpemilikpengadaan(Request $request){
        $tgl1 = "";
        $tgl2 = "";
        if($request->tgl1 == "" || $request->tgl1 == null ){
            $tgl1 = date("Y-m-d");
            Session::put('tgl1', $tgl1);            
            $tgl1 = $tgl1." 00:00:00";
        }
        if($request->tgl1 != "" || $request->tgl1 != null ){
            $tgl1 = $request->tgl1;
            $tgl1 = str_replace("/","-",$tgl1);
            $tgl1 = date('Y-m-d',strtotime($tgl1));
            Session::put('tgl1', $tgl1);            
            $tgl1 = $tgl1." 00:00:00"; 
        }
        if($request->tgl2 == "" || $request->tgl2 == null){
            $tgl2 = date("Y-m-d");
            Session::put('tgl2', $tgl2);            
            $tgl2 = $tgl2." 23:59:59";
        }
        if($request->tgl2 != "" || $request->tgl2 != null){
            $tgl2 = $request->tgl2;
            $tgl2 = str_replace("/","-",$tgl2);
            $tgl2 = date('Y-m-d',strtotime($tgl2));
            Session::put('tgl2', $tgl2);            
            $tgl2 = $tgl2." 23:59:59";
        }
        if(Session('login')==true && Session('level')=="pemilik"){
            $query = "SELECT a.id_penyetokan, c.nama_supplier, b.nama_obat, a.jumlah, a.harga_beli, a.total,
            a.stok_awal,a.stok_akhir, a.tgl_masuk, a.tgl_kadaluarsa from penyetokan a, obat b, supplier c where a.id_supplier=c.id_supplier 
            and a.id_obat=b.id_obat AND b.nama_obat LIKE '%$request->q%' AND c.nama_supplier LIKE '%$request->supplier%'
            AND a.tgl_masuk BETWEEN CAST('$tgl1' as DATE) AND CAST('$tgl2' as DATE)";
            
            Session::put('querypengadaan', $query);            

            $data = DB::select($query);
            return view("pemilik/pengadaan",['data'=>$data]);
        }else{
            return redirect('/auth');
        }

    }
    public function cetakpemilikpenjualan(){
        if(Session('login')==true && Session('level')=="pemilik"){
            $pendapatan = 0;
            $jumlah = 0;
            $data = DB::select(Session('querypenjualan'));
            foreach ($data as $key){
                $pendapatan = $pendapatan + $key->total; 
                $jumlah = $jumlah + $key->qty; 
            }
            $pdf = PDF::loadView('pemilik/penjualan_pdf',['data'=>$data,'pendapatan'=>$pendapatan,'jumlah'=>$jumlah]);

            return  $pdf->download("penjualan_".Session('tgl1')."-".Session('tgl1').".pdf");
        }else{
            return redirect('/auth');
        }   
    }
    public function cetakpemilikpengadaan(){
        if(Session('login')==true && Session('level')=="pemilik"){
            $data = DB::select(Session('querypengadaan'));
            
            $pdf = PDF::loadView('pemilik/pengadaan_pdf',['data'=>$data]);

            return  $pdf->download("pengadaan_".Session('tgl1')."-".Session('tgl1').".pdf");
        }else{
            return redirect('/auth');
        }   
    }

    //controller adminobat
    public function obatkategori(){
        if(Session('login')==true && Session('level')=="adminobat"){
            $data = DB::select("SELECT * from kategori where aktif=1");
            return view("adminobat/kategori",['data'=>$data]);
        }else{
            return redirect('/auth');
        }   
    }
    public function obatobat(){
        if(Session('login')==true && Session('level')=="adminobat"){
            $data = DB::select("SELECT a.id_obat, a.id_kategori,b.kategori, a.nama_obat, a.satuan,a.harga_beli,a.harga_jualResep,a.harga_jualNon,a.labaResep,a.labaNon,a.stok,a.tgl_kadaluarsa,a.selisih,a.stokMinimal, a.aktif from obat a, kategori b where a.id_kategori=b.id_kategori and a.aktif=1");
            return view("adminobat/obat",['data'=>$data]);
        }else{
            return redirect('/auth');
        }   
    }
    public function obatpenjualan(){
        if(Session('login')==true && Session('level')=="adminobat"){
            $data = DB::select("SELECT * from detail_transaksi a, obat b where a.id_obat=b.id_obat ");
            return view("adminobat/penjualan",['data'=>$data]);
        }else{
            return redirect('/auth');
        }   
    }
    //controller pengadaan
    public function pengadaansupplier(){
        if(Session('login')==true && Session('level')=="pengadaan"){
            $data = DB::select("SELECT * from supplier where aktif=1");
            return view("pengadaan/supplier",['data'=>$data]);
        }else{
            return redirect('/auth');
        }   
    }   
    public function pengadaanpengadaan(){
        if(Session('login')==true && Session('level')=="pengadaan"){
            $data = DB::select("SELECT a.id_penyetokan, c.nama_supplier, b.nama_obat, a.jumlah, a.harga_beli, a.total,
            a.stok_awal,a.stok_akhir, a.tgl_masuk, a.tgl_kadaluarsa from penyetokan a, obat b, supplier c where a.id_supplier=c.id_supplier 
            and a.id_obat=b.id_obat");
            return view("pengadaan/pengadaan",['data'=>$data]);
        }else{
            return redirect('/auth');
        }   
    }
    
    //Controller Kasir
    public function kasirtransaksi(){
        if(Session('login')==true && Session('level')=="kasir"){
            $grandtotal = 0 ;
            Session::put('grandtotal', $grandtotal);
            
            $temp = DB::select("select * from temp_transaksi");
            if($temp != null){
                foreach($temp as $temp){
                    $grandtotal = $grandtotal + $temp->total;
                    Session::put('grandtotal', $grandtotal);
                } 
            }
            return view("kasir/transaksi");
        }else{
            return redirect('/auth');
        }   
    }
    public function kasirriwayat(){
        if(Session('login')==true && Session('level')=="kasir"){
            Session::put('kasir',null);
            $data = DB::select("select * from transaksi a, user b where a.id_user = b.id_user");
            
            return view("kasir/riwayat",["data"=>$data]);
        }else{
            return redirect('/auth');
        }   
    }
    public function kasirtransaksiresep(){
        if(Session('login')==true && Session('level')=="kasir"){
            Session::put('kasir','resep');
            return redirect("/kasir-transaksi");
        }else{
            return redirect('/auth');
        }   
    }
    public function kasirtransaksinonresep(){
        if(Session('login')==true && Session('level')=="kasir"){
            Session::put('kasir','nonresep');
            return redirect("/kasir-transaksi");
        }else{
            return redirect('/auth');
        }   
    }


    //CRUD User
    public function adduser(Request $request){
        if(Session('login')==true && Session('level')=="pemilik"){
            $username = $request->username;
            $password = $request->password;
            $nama = $request->nama;
            $id_level = $request->id_level;
            
            $cek = DB::select("select * from user where nama='$nama' AND username='$username'");
            if ($cek != null) {
                return redirect("pemilik-user")->with('gagal','.');
            }
        
            $save = DB::table('user')->insert([
                'nama' => $nama, 
                'username' => $username,
                'password' => $password,
                'id_level' => $id_level,
                'aktif' => 1
                ]);
            return redirect("pemilik-user")->with('sukses','.');
        }else{
            return redirect('/auth');
        }   
    }
    public function deluser($id){
        if(Session('login')==true && Session('level')=="pemilik"){
            DB::table('user')->where('id_user', $id)->update([
                'aktif' => 0,
                ]);
            return redirect("pemilik-user")->with('hapus','.');
        }else{
            return redirect('/auth');
        }   
    }
    public function edituser(Request $request){
        if(Session('login')==true && Session('level')=="pemilik"){
            DB::table('user')->where('id_user', $request->id_user)->update([
                'nama' => $request->nama,
                'username' => $request->username,
                'password' => $request->password,
                'id_level' => $request->id_level
                ]);
            return redirect("pemilik-user")->with('edit','.');
        }else{
            return redirect('/auth');
        }   
    }

    //CRUD Kategori
    public function addkategori(Request $request){
        if(Session('login')==true && Session('level')=="adminobat"){
            $kategori = $request->kategori;
            $cek = DB::select("select * from kategori where kategori='$kategori'");
            if($cek != null){
                return redirect("/obat-kategori")->with('gagal','.');
            }
            $save = DB::table('kategori')->insert([
                'kategori' => $kategori,
                'aktif' => 1
                ]);
            return redirect("/obat-kategori")->with('sukses','.');
        }else{
            return redirect('/auth');
        }   
    }
    public function delkategori($id){
        if(Session('login')==true && Session('level')=="adminobat"){
            DB::table('kategori')->where('id_kategori', $id)->update([
                'aktif' => 0,
                ]);
                return redirect("/obat-kategori")->with('hapus','.');
        }else{
            return redirect('/auth');
        }   
    }
    public function editkategori(Request $request){
        if(Session('login')==true && Session('level')=="adminobat"){
            DB::table('kategori')->where('id_kategori', $request->id_kategori)->update([
                'kategori' => $request->kategori
                ]);
            return redirect("/obat-kategori")->with('edit','.');
        }else{
            return redirect('/auth');
        }   
    }
    
    //CRUD Obat
    public function addobat(Request $request){
        if(Session('login')==true && Session('level')=="adminobat"){
            $cek = DB::select("select * from obat where nama_obat='$request->nama_obat'");
            if ($cek != null) {
                return redirect("obat-obat")->with('gagal','.');
            }else{
                $labaR = 0; $labaN = 0;
                $setting = DB::select("select * from setting");
                foreach ($setting as $set){
                    $labaR = $set->laba_resep;
                    $labaN = $set->laba_nonresep;
                }
                $save = DB::table('obat')->insert([
                    'nama_obat' => $request->nama_obat,
                    'id_kategori' => $request->id_kategori,
                    'satuan' => $request->satuan,
                    'labaResep'=>$labaR,
                    'labaNon'=>$labaN,
                    'selisih'=>$request->selisih,
                    'stokMinimal'=>$request->stokMinimal,
                    'aktif' => 1
                    ]);
                return redirect("/obat-obat")->with('sukses','.');
            }
        }else{
            return redirect('/auth');
        }   
    }
    public function delobat($id){
        if(Session('login')==true && Session('level')=="adminobat"){
            DB::table('obat')->where('id_obat', $id)->update([
                'aktif' => 0,
                ]);
            return redirect("obat-obat")->with('hapus','.');;
        }else{
            return redirect('/auth');
        }   
    }
    public function editobat(Request $request){
        if(Session('login')==true && Session('level')=="adminobat"){
            DB::table('obat')->where('id_obat', $request->id_obat)->update([
                'nama_obat' => $request->nama_obat,
                'id_kategori' => $request->id_kategori,
                'satuan' => $request->satuan,
                'stokMinimal' => $request->stokMinimal,
                'selisih' => $request->selisih
                ]);
            return redirect("obat-obat")->with('edit','.');;
        }else{
            return redirect('/auth');
        }   
    }
    //CRUD Laba
    public function editlaba(Request $request){
        if(Session('login')==true && Session('level')=="adminobat"){
            DB::table('setting')->where('id_setting', $request->id_setting)->update([
                'laba_resep' => $request->laba_resep,
                'laba_nonresep' => $request->laba_nonresep,
                ]);
            return redirect("obat-obat");
        }else{
            return redirect('/auth');
        }   
    }
    //CRUD Supplier
    public function addsupplier(Request $request){
        if(Session('login')==true && Session('level')=="pengadaan"){
            $cek = DB::select("select * from supplier where nama_supplier='$request->nama_supplier' OR telp='$request->telp'");
            if($cek != null){
                return redirect("/pengadaan-supplier")->with('gagal','.');
            }

            $save = DB::table('supplier')->insert([
                'nama_supplier' => $request->nama_supplier,
                'alamat' => $request->alamat,
                'telp' => $request->telp,
                'aktif' => 1
                ]);
            return redirect("/pengadaan-supplier")->with('sukses','.');
        }else{
            return redirect('/auth');
        }   
    }
    public function delsupplier($id){
        if(Session('login')==true && Session('level')=="pengadaan"){
            DB::table('supplier')->where('id_supplier', $id)->update([
                'aktif' => 0,
                ]);
            return redirect("pengadaan-supplier")->with('hapus','.');
        }else{
            return redirect('/auth');
        }   
    }
    public function editsupplier(Request $request){
        if(Session('login')==true && Session('level')=="pengadaan"){
            DB::table('supplier')->where('id_supplier', $request->id_supplier)->update([
                'nama_supplier' => $request->nama_supplier,
                'alamat' => $request->alamat,
                'telp' => $request->telp,
                ]);
            return redirect("pengadaan-supplier")->with('edit','.');
        }else{
            return redirect('/auth');
        }   
    }
    //CRUD PEngadaan
    public function addpengadaan(Request $request){
        if(Session('login')==true && Session('level')=="pengadaan"){
            //deklarasi
            $total = $request->jumlah * $request->harga_beli;
            $new_beli = 0;
            $new_jual = 0;
            $stok_awal = 0;
            $labaResep = 0;
            $labaNon = 0;
            $kadaluarsa_obat = 0;
            $beli_obat=0;
            $jual_obatResep = 0;
            $jual_obatNon = 0;
            $id = $request->id_obat;
            //get obat
            $obat = DB::select("select * from obat where id_obat=$id");
            foreach ($obat as $key ){
                $beli_obat = $key->harga_beli;
                $jual_obatResep = $key->harga_jualResep;
                $jual_obatNon = $key->harga_jualNon;
                $labaResep = $key->labaResep;
                $labaNon = $key->labaNon;
                $stok_awal = $key->stok;
            }
            
            //rerata tetimbang
            $new_beli = (($stok_awal*$beli_obat)+$total)/($stok_awal+$request->jumlah);
            $new_jualResep = $new_beli+(($labaResep/100)*$new_beli);
            $new_jualNon = $new_beli+(($labaNon/100)*$new_beli);
            ;

            //add penyetokan
            $save = DB::table('penyetokan')->insert([
                'id_obat' => $request->id_obat,
                'id_supplier' => $request->id_supplier,
                'jumlah' => $request->jumlah,
                'stok_awal' => $stok_awal,
                'stok_akhir' => $stok_awal+$request->jumlah,
                'harga_beli' => $request->harga_beli,
                'total' => $total,
                'tgl_kadaluarsa' =>$request->tgl_kadaluarsa
                ]);
            //edit obat
            DB::table('obat')->where('id_obat', $request->id_obat)->update([
                'stok' => $stok_awal+$request->jumlah,
                'harga_beli' => $new_beli,
                'harga_jualResep' => $new_jualResep,
                'harga_jualNon' => $new_jualNon,
                'tgl_kadaluarsa'=>$request->tgl_kadaluarsa
                ]);

            return redirect("/pengadaan-pengadaan");
        }else{
            return redirect('/auth');
        }   
    }
    

    //tambahan
    public function index()
    {
    return view('kasir.search');
    }
    public function search(Request $request)
    {
    if($request->ajax() && $request->search != "")
    {
    $output="";
    //$products=DB::table('obat')->where('nama_obat','LIKE','%'.$request->search."%")->get();
    $products = DB::select("select * from obat where nama_obat LIKE '%".$request->search."%' AND aktif=1 AND TIMESTAMPDIFF(DAY,now(),tgl_kadaluarsa) >= 1 AND STOK > 0");
    if($products)
    {
        if (Session('kasir')=='resep') {
            foreach ($products as $key => $product) {
                $output.='<tr>'.
                '<td>'.$product->nama_obat.'</td>'.
                '<td>'.$product->harga_jualResep.'</td>'.
                '<td><a href="/add'.$product->id_obat.'" class="btn btn-primary btn-xs">Tambahkan
                </a> </td>'.
                '</tr>';
                }        
        }else{
            foreach ($products as $key => $product) {
                $output.='<tr>'.
                '<td>'.$product->nama_obat.'</td>'.
                '<td>'.$product->harga_jualNon.'</td>'.
                '<td><a href="/add'.$product->id_obat.'" class="btn btn-primary btn-xs">Tambahkan
                </a> </td>'.
                '</tr>';
                }
        }
    
    return Response($output);
       }
       }
    }

    public function add($id){
        if(Session('login')==true && Session('level')=="kasir"){
            $data = DB::select("select * from obat where id_obat='$id'");
            
            foreach ($data as $key) {
                Session::put('temp-id_obat', $key->id_obat);
                Session::put('temp-nama_obat', $key->nama_obat);
                if (Session('kasir')=='resep') {
                    Session::put('temp-harga_jual', $key->harga_jualResep);
                    Session::put('temp-laba', $key->labaResep);    
                }else{
                    Session::put('temp-harga_jual', $key->harga_jualNon);
                    Session::put('temp-laba', $key->labaNon);    
                }
                Session::put('temp-harga_beli', $key->harga_beli);
                Session::put('temp-stok', $key->stok);
         };
            return redirect("kasir-transaksi");
        }else{
            return redirect('/auth');
        }   
    }
    public function addcart(Request $request){
        if(Session('login')==true && Session('level')=="kasir"){
            $data = DB::select("select * from obat where id_obat='$request->id_obat'");
            $cek = DB::select("select * from temp_transaksi where id_obat='$request->id_obat'");
            
            if ($cek != null) {
                foreach($cek as $cek){
                    DB::table('temp_transaksi')->where('id_obat', $request->id_obat)->update([
                        'qty'=>$cek->qty + $request->qty,
                        'total'=> $cek->total + ($request->qty * $request->harga_jual)
                        ]);
                };
                    
            }else{
                foreach($data as $data){
                    if ($data->stok < $request->qty) {
                        return redirect()->back()->withErrors(['msgstok','Stok tidak mencukupi']);
                      }
                }
                $save = DB::table('temp_transaksi')->insert([
                    'id_obat' => $request->id_obat, 
                    'nama_obat' => $request->nama_obat,
                    'qty' => $request->qty,
                    'harga_jual' => $request->harga_jual,
                    'harga_beli' => Session('temp-harga_beli'),
                    'laba' => Session('temp-laba'),
                    'total' => $request->qty * $request->harga_jual
                    ]);
            }
                    
                    Session::put('temp-id_obat', '');
                    Session::put('temp-nama_obat', '');
                    Session::put('temp-harga_jual', '');
                    Session::put('temp-laba', '');    
                    Session::put('temp-harga_jual', '');
                    Session::put('temp-laba', '');    
                    Session::put('temp-harga_beli', '');
                    Session::put('temp-stok', '');
            return redirect("kasir-transaksi");
        }else{
            return redirect('/auth');
        }   
    }
    public function editcart(Request $request){
        if(Session('login')==true && Session('level')=="kasir"){
            DB::table('temp_transaksi')->where('id_temp', $request->id_temp)->update([
                'qty' => $request->qty,
                'total' => $request->qty * $request->harga_jual
                ]);
            return redirect("kasir-transaksi");
        }else{
            return redirect('/auth');
        }   
    }

    public function delcart($id){
        if(Session('login')==true && Session('level')=="kasir"){
            DB::table('temp_transaksi')->where('id_temp', $id)->delete();
            return redirect("kasir-transaksi");
        }else{
            return redirect('/auth');
        }   
    }
    public function addtransaksi(Request $request){
        if(Session('login')==true && Session('level')=="kasir"){
            if (Session('grandtotal') > $request->bayar) {
                    return redirect()->back()->withErrors(['msguang','Uang tidak mencukupi']);
            }
            $id_user = Session('id_user');
            $inv = "";
            $getinv = DB::select("select unix_timestamp() as invoice");
            $gettemp = DB::select("select * from temp_transaksi");
            foreach ($getinv as $key){
            $inv = $key->invoice;
            };
            $save = DB::table('transaksi')->insert([
                'id_transaksi' => $inv,
                'inv' => "INV".$inv,
                'jenis' => Session('kasir'),
                'grand_total' => Session('grandtotal'),
                'bayar' => $request->bayar,
                'id_transaksi' => $inv, 
                'kembali' => $request->bayar - Session('grandtotal'),
                'id_user' => $id_user,
                ]);
            foreach ($gettemp as $key) {
                $save = DB::table('detail_transaksi')->insert([
                    'inv' => "INV".$inv,
                    'id_obat' => $key->id_obat,
                    'harga_jual' => $key->harga_jual,
                    'harga_beli' => $key->harga_beli,
                    'total' => $key->total,
                    'qty' => $key->qty,                  
                    ]);
                    DB::table('temp_transaksi')->where('id_obat', $key->id_obat)->delete();
            }
            Session::put('kasir','');
            Session::put('grandtotal','');
            return redirect("kasir-riwayat")->withErrors(['msgkembali','Stok tidak mencukupi']);
        }else{
            return redirect('/auth');
        }   
    }

    public function editprofil(Request $request){
        if(Session('login')==true){
            DB::table('user')->where('id_user', Session('id_user'))->update([
                'nama' => $request->nama,
                'username' => $request->username,
                'password' => $request->password,
                ]);

            Session::put('password',$request->password);
            Session::put('nama',$request->nama);
            Session::put('username',$request->username);
                
                return redirect()->back();
        }else{
            return redirect('/auth');
        }   
    }
    
}
