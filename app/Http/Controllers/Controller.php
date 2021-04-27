<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Session;


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

    //controller adminobat
    public function obatkategori(){
        if(Session('login')==true && Session('level')=="adminobat"){
            $data = DB::select("SELECT * from kategori where aktif=1");
            return view("adminobat/kategori",['data'=>$data]);
        }else{
            return redirect('/auth');
        }   
    }
    
    //CRUD Obat
    public function adduser(Request $request){
        if(Session('login')==true && Session('level')=="pemilik"){
            $username = $request->username;
            $password = $request->password;
            $nama = $request->nama;
            $id_level = $request->id_level;
        
            $save = DB::table('user')->insert([
                'nama' => $nama, 
                'username' => $username,
                'password' => $password,
                'id_level' => $id_level,
                'aktif' => 1
                ]);
            return redirect("pemilik-user");
        }else{
            return redirect('/auth');
        }   
    }
    public function deluser($id){
        if(Session('login')==true && Session('level')=="pemilik"){
            DB::table('user')->where('id_user', $id)->update([
                'aktif' => 0,
                ]);
            return redirect("pemilik-user");
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
            return redirect("pemilik-user");
        }else{
            return redirect('/auth');
        }   
    }

    //CRUD Kategori
    public function addkategori(Request $request){
        if(Session('login')==true && Session('level')=="adminobat"){
            $kategori = $request->kategori;
            $save = DB::table('kategori')->insert([
                'kategori' => $kategori,
                'aktif' => 1
                ]);
            return redirect("/obat-kategori");
        }else{
            return redirect('/auth');
        }   
    }
    public function delkategori($id){
        if(Session('login')==true && Session('level')=="adminobat"){
            DB::table('kategori')->where('id_kategori', $id)->update([
                'aktif' => 0,
                ]);
            return redirect("obat-kategori");
        }else{
            return redirect('/auth');
        }   
    }
    public function editkategori(Request $request){
        if(Session('login')==true && Session('level')=="adminobat"){
            DB::table('kategori')->where('id_kategori', $request->id_kategori)->update([
                'kategori' => $request->kategori
                ]);
            return redirect("obat-kategori");
        }else{
            return redirect('/auth');
        }   
    }
        
}
