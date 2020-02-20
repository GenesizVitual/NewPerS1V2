<?php
if(version_compare(PHP_VERSION, '7.2.0', '>=')) {
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}
use App\Province as province;
use App\District as kabupaten;
use App\JadwalPelatihanModel as jadwalPelatihan;
use App\WaktuPelModel as waktu_pel;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('cek-aktivasi', 'aktivasiController@proses_aktivasi');


Route::get('/', 'aktivasiController@cek_ativasi');

Route::get('page', function(){
    return view('front_end.index');
});

Route::get('register', function(){
    $data= [
        'provinsi'=>province::all(),
        'kabupaten'=>kabupaten::all()
    ];
   return view('front_end.register', $data);
});

Route::get('login', function(){
   return view('front_end.login');
});

Route::get('loginbpk', function(){
    $data= [
      'provinsi'=>province::all(),
      'kabupaten'=>kabupaten::all()
    ];
   return view('front_end.loginbpk', $data);
});

Route::get('daftar', function(){
    $data= [
        'provinsi'=>province::all(),
        'jadwal_pelatihan'=> jadwalPelatihan::all()
    ];
    return view('front_end.pelatihan',$data);
});

Route::get('syarat', function (){
    return view('front_end.syarat');
});

//=========================================== Ganti password ===========================================================
Route::get('lupa-password','RegisterController@ganti_password');

Route::post('shadow_password','RegisterController@shadow_password');

//========================================== Login =====================================================================
//Route::get('login', 'RegisterController@Login');

Route::post('login','RegisterController@StoreLogin');

Route::get('signup_admin', 'RegisterController@loginBpk');

Route::get('signup_inspektorat', 'RegisterController@loginInspektorat');

Route::get('signup', 'RegisterController@Signup');

Route::post('signup_admin', 'RegisterController@loginbpka');

Route::get('halama_superadmin_bpk', 'RegisterController@halaman_superadmin_bpk');

Route::post('signup_inspektorats', 'RegisterController@loginInspektorats');

Route::post('signup','RegisterController@StoreAccount');

Route::get('singout','RegisterController@Signout');

Route::get('keluar_pegawai','RegisterController@keluar_pegawai');

Route::get('keluar_pegawai_instansi','RegisterController@keluar_pegawai_in');


Route::get('login_admin_bpk','RegisterController@loginadminbpk');

Route::post('login_admin_bpk','RegisterController@loginsuperadminbpk');


//========================================== Dashboard =================================================================

Route::get('dashboard', 'DashboardController@index');

Route::get('infolangganan', 'DashboardController@informasi');

//========================================= Profil Instansi ============================================================

Route::get('profileInstansi', 'InstanceController@index');

Route::get('profilInstansi', 'InstanceController@create');

Route::post('profilInstansi', 'InstanceController@store');

Route::get('editInstansi/{id}/edit','InstanceController@edit');

Route::get('getDataInstansi','InstanceController@getData');

Route::put('profilInstansi/{id}/update','InstanceController@update');


//========================================== Buat Akun =================================================================

Route::get('createAccount', 'UserInstanceController@index');

Route::get('newAccount', 'UserInstanceController@create');

Route::post('newAccount', 'UserInstanceController@store');

Route::get('newAccount/{id}/edit', 'UserInstanceController@edit');

Route::put('newAccount/{id}/edit', 'UserInstanceController@update');

Route::delete('newAccount/{id}/delete', 'UserInstanceController@destroy');

Route::get('verifikasi/{token}', 'UserInstanceController@setujui');

//============================================ Bidang ==================================================================

Route::get('sector', 'SectorControllers@index');

Route::get('sector/create', 'SectorControllers@create');

Route::post('sector/store', 'SectorControllers@store');

Route::get('sector/{id}/edit', 'SectorControllers@edit');

Route::put('sector/{id}/update', 'SectorControllers@update');

Route::put('sector/{id}/destroy', 'SectorControllers@delete');

//=========================================== Authorized ===============================================================

Route::get('authorized', 'AuthorizedController@index');

Route::get('authorized/create', 'AuthorizedController@create');

Route::post('authorized/store', 'AuthorizedController@store');

Route::get('authorized/{id}/edit', 'AuthorizedController@edit');

Route::put('authorized/{id}/update', 'AuthorizedController@update');

Route::put('authorized/{id}/destroy', 'AuthorizedController@delete');



//========================================= Tahun Anggaran =============================================================

Route::get('fiscalyears', 'FiscalyearsControllers@index');

Route::get('fiscalyears/create', 'FiscalyearsControllers@create');

Route::post('fiscalyears/create', 'FiscalyearsControllers@store');

Route::get('fiscalyears/{id}/edit', 'FiscalyearsControllers@edit');

Route::put('fiscalyears/{id}/edit', 'FiscalyearsControllers@update');

Route::put('fiscalyears/{id}/destroy', 'FiscalyearsControllers@destroy');

//========================================= Jenis Barang ===============================================================

Route::get('typeOfGoods', 'typeOfGoodsController@index');

Route::get('typeOfGoods/create', 'typeOfGoodsController@create');

Route::post('typeOfGoods/create', 'typeOfGoodsController@store');

Route::get('typeOfGoods/{id}/edit', 'typeOfGoodsController@edit');

Route::put('typeOfGoods/{id}/edit', 'typeOfGoodsController@update');

Route::put('typeOfGoods/{id}/delete', 'typeOfGoodsController@destroy');

//========================================= Suppliers ==================================================================

Route::get('suppliers', 'SuppliersController@index');

Route::get('suppliers/create', 'SuppliersController@create');

Route::post('suppliers/create', 'SuppliersController@store');

Route::get('suppliers/{id}/edit','SuppliersController@edit');

Route::put('suppliers/{id}/edit','SuppliersController@update');

Route::get('suppliers/{id}', 'SuppliersController@detail_supplier');


Route::put('suppliers/{id}/delete', 'SuppliersController@destroy');

//=========================================== Barang ===================================================================

Route::get('warehouse','WarehouseController@index');

Route::get('warehouse/create','WarehouseController@create');

Route::post('warehouse/create','WarehouseController@store');

Route::get('warehouse/{id}/edit','WarehouseController@edit');

Route::put('warehouse/{id}/edit','WarehouseController@update');

Route::put('warehouse/{id}/delete','WarehouseController@delete');

Route::post('import-data-barang','WarehouseController@import');

//========================================program===========================//

Route::get('program', 'ProgramController@index');

Route::post('program/create', 'ProgramController@store');

Route::get('program/{id}/edit', 'ProgramController@edit');

Route::put('program/{id}/edit','ProgramController@update');

Route::put('program/{id}/destroy','ProgramController@delete');

Route::post('singkron_dpa','ProgramController@singkronDPA');

//============================================ Kegiatan =====================================================================

Route::get('keg/{id}/list', 'KegController@keg_list');

Route::get('keg/{id}/create', 'KegController@createkeg');

Route::put('keg/{id}/create', 'KegController@kegStore');

Route::get('keg/{kegID}', 'KegController@kegEdit');

Route::put('keg/{kegID}', 'KegController@kegUpdate');

Route::put('keg/delete/{kegID}', 'KegController@kegDelete');

//============================================ Belanja==============================================================

Route::get('belanja/{id}/list', 'BelanjaController@listBelanja');

Route::put('belanja/{id}/list', 'BelanjaController@store');

Route::get('belanja/{idkeg}/{idGoods}/list', 'BelanjaController@edit');

Route::put('belanja/{idGoods}/update', 'BelanjaController@update');

Route::put('belanja/{idGoods}/delete', 'BelanjaController@delete');

//========================================== DPA Persediaan ==============================================================

Route::get('dpa', 'DpaController@index');

Route::get('createDpa','DpaController@create');

Route::post('createDpa/store','DpaController@store');

//Route::post('createDpa/storep','DpaController@storep');

Route::get('editDpa/{id}/edit','DpaController@edit');

Route::put('editDpa/{id}/edit','DpaController@update');

Route::put('deleteDpa/{id}/delete','DpaController@delete');

//========================================== Nota Pesanan ==============================================================

Route::get('nota_p','NoteReceiptController@index');

Route::get('buat_nota','NoteReceiptController@create');

Route::post('buat_nota/store','NoteReceiptController@store');

Route::get('nota_p/{id}/edit','NoteReceiptController@edit');

Route::put('nota_p/{id}/update','NoteReceiptController@update');

Route::put('nota_p/{id}/delete','NoteReceiptController@delete');

Route::get('cetak_nota_pesanan/{id}','NoteReceiptController@report_rincian_surat');

Route::get('rincian_barang/{id}','NoteReceiptController@rincian_surat');

Route::post('tambah_rincian_barang','NoteReceiptController@store_rincian_barang');

Route::get('detail_rincian_barang/{id}','NoteReceiptController@rincian_barang');

Route::get('edit_rincian_barang/{id}','NoteReceiptController@edit_rincian_barang');

Route::put('ubah_rincian_barang/{id}','NoteReceiptController@update_rincian_barang');

Route::put('delete_rincian_barang/{id}','NoteReceiptController@delete_rincian_barang');

Route::get('cek_belanja/{id}','NoteReceiptController@getSisaJumlah_belanja');

Route::get('daftar_berita_acara_penerimaan_hasil_pekerjaan','NoteReceiptController@daftar_berita_acara_penerimaan_hasil_pekerjaan');

Route::get('tambah_berita_acara_hasil_pekerjaan', 'NoteReceiptController@create_berita_acara_Hp');

Route::post('buat_nota_berita_hasil_pekerjaan/store','NoteReceiptController@store_berita_acara_hp');

Route::get('nota_BPH/{id}/edit','NoteReceiptController@edit_berita_acara_Hp');

Route::put('nota_BPH/{id}/update','NoteReceiptController@update_berita_acara_Hp');

Route::put('nota_BPH/{id}/delete','NoteReceiptController@delete_berita_acara_Hp');

Route::get('rincian_berita_acara_HP/{id}','NoteReceiptController@detail_berita_acara_hp');

Route::get('cetak_rincian_berita_acara_HP/{id}','NoteReceiptController@print_detail_berita_acara_hp');

Route::get('cek_tanggal','NoteReceiptController@tanggal');

Route::get('berita_acara_penerimaan_barang_jasa','NoteReceiptController@daftar_berita_acara_penerimaan_barang');

Route::get('tambah_berita_acara_penerimaan_barang_jasa','NoteReceiptController@create_berita_acara_penerimaan_barang');

Route::post('tambah_berita_acara_penerimaan_barang_jasa/store','NoteReceiptController@store_berita_acara_penerimaan_barang');

Route::get('berita_acara_penerimaan/{id}/edit','NoteReceiptController@edit_berita_acara_penerimaan_barang');

Route::put('edit_berita_acara_penerimaan_barang_jasa/{id}/update','NoteReceiptController@update_berita_acara_penerimaan_barang');

Route::put('berita_acara_penerimaan/{id}/delete','NoteReceiptController@delete_berita_acara_penerimaan_barang');

Route::get('rincian_berita_acara/{id}/detail','NoteReceiptController@detail_surat_berita_acara_penerimaan');

Route::get('print_rincian_berita_acara/{id}/detail','NoteReceiptController@print_detail_surat_berita_acara_penerimaan');

Route::get('berita_acara_serah_terima_pekerjaan_pembelian','NoteReceiptController@daftar_berita_acara_serah_terima_pekerjaan');

Route::get('tambah_berita_acara_serah_terima_pekerjaan','NoteReceiptController@tambah_berita_acara_serah_terima_pekerjaan');

Route::post('tambah_berita_acara_serah_terima_pekerjaan/store','NoteReceiptController@store_berita_acara_serah_terima_pekerjaan');

Route::get('berita_acara_serah_terima_pekerjaan/{id}/edit','NoteReceiptController@edit_berita_acara_serah_terima_pekerjaan');

Route::put('edit_berita_acara_serah_terima_pekerjaan/{id}/update','NoteReceiptController@update_berita_acara_serah_terima_pekerjaan');

Route::put('berita_acara_serah_terima_pekerjaan/{id}/delete','NoteReceiptController@delete_berita_acara_serah_terima_pekerjaan');

Route::get('rincian_berita_acara_serah_terima_pekerjaan/{id}/detail','NoteReceiptController@rincian_berita_acara_serah_terima_pekerjaan');

Route::get('cetak_rincian_berita_acara_serah_terima_pekerjaan/{id}/detail','NoteReceiptController@print_rincian_berita_acara_serah_terima_pekerjaan');

//=========================================== SPJ ======================================================================

Route::get('goodsreceipt', 'SpjController@index');

Route::post('goodsreceipt/create', 'SpjController@store');

Route::get('goodsreceipt/{id}/edit', 'SpjController@edit');

Route::put('goodsreceipt/{id}/edit','SpjController@update');

Route::put('goodsreceipt/{id}/destroy','SpjController@delete');

//============================================ TBK =====================================================================

Route::get('tbk/{id}/list', 'TbkController@tbk_list');

Route::get('tbk/{id}/create', 'TbkController@createtbk');

Route::get('tbkResponse/{id}', 'TbkController@tbk_respone');

Route::put('tbk/{id}/create', 'TbkController@tbkStore');

Route::get('tbk/{tbkID}', 'TbkController@tbkEdit');

Route::put('tbk/{tbkID}', 'TbkController@tbkUpdate');

Route::put('tbk/delete/{tbkID}', 'TbkController@tbkDelete');


//============================================ Penerimaan ==============================================================

Route::get('goodreceipt/{id}/list', 'GoodreceiptController@listReceipt');

Route::put('goodreceipt/{id}/list', 'GoodreceiptController@store');

Route::get('goodreceipt/{idtbk}/{idGoods}/list', 'GoodreceiptController@edit');

Route::put('goodreceipt/{idGoods}/update', 'GoodreceiptController@update');

Route::put('goodreceipt/{idGoods}/delete', 'GoodreceiptController@delete');

Route::put('goodreceipt/{idtbk}/delete_by_jenis_barang', 'GoodreceiptController@delete_by_jenis_barang');

//============================================== Pengeluaran ===========================================================

Route::get('expendures', 'ExpenduresController@index');

Route::get('expendures/{idGoods}', 'ExpenduresController@get_receipt');

Route::get('expendures_habis/{idGoods}', 'ExpenduresController@get_receipt_habis');

Route::post('expendures/store', 'ExpenduresController@store');

Route::get('expendures_bidang/{idbidang}', 'ExpenduresController@get_pengeluaran_base_bidang');

Route::get('expenduresa_bidang/{idbidang}', 'ExpenduresController@get_pengeluarans_base_bidang');

Route::get('import_stok', 'StokController@import_stok');

Route::get('import_stok_tahun_mendatang', 'StokController@import_stok_tahun_ke_tahun_mendatang');

//===================================== Lihat data Pengeluaran =========================================================

Route::get('expendures/{id_penerimaan}/out_item', 'ExpenduresController@get_expendures');

Route::put('expendures/{id_pengeluaran}/recover', 'ExpenduresController@recover_receipt');

//===================================== Surat Permintaan ===============================================================

Route::get('letterofRequets', 'LetterOfRequest@index');

Route::get('CreateletterofRequets', 'LetterOfRequest@create');

Route::post('letterRequest/create', 'LetterOfRequest@store');

Route::get('edit_letter_request/{id}', 'LetterOfRequest@edit');

Route::put('edits_letter_request/{id}', 'LetterOfRequest@update');

Route::get('delete_letter_request/{id}', 'LetterOfRequest@delete');

Route::put('expendures_bidang_permintaan', 'ExpenduresController@get_pengeluaran_base_bidang');

Route::put('expendures_bidang_pengeluaran', 'ExpenduresController@get_pengeluarans_base_bidang');

//======================================= Surat Pengeluaran ============================================================
Route::get('letterofExpenditure', 'LetterOfExpenditures@index');

Route::get('CreateletterofExpenditure', 'LetterOfExpenditures@create');

Route::post('StoreletterofExpenditure', 'LetterOfExpenditures@store');

Route::get('EditletterofExpenditure/{id}', 'LetterOfExpenditures@edit');

Route::put('UpdateletterofExpenditure/{id}', 'LetterOfExpenditures@update');

Route::get('DeleteletterofExpenditure/{id}', 'LetterOfExpenditures@detele');

//========================================== Laporan Penerimaan ========================================================

Route::get('report/penerimaan', 'GoodreceiptController@laporan_penerimaan_content');

Route::get('recepit_exits', 'GoodreceiptController@get_data');

Route::post('report_receipt', 'GoodreceiptController@set_data');

Route::get('report_bpk/penerimaan', 'GoodreceiptController@laporan_penerimaan_content_bpk');

Route::get('report_inspektorat/penerimaan', 'GoodreceiptController@laporan_penerimaan_content_pemrov');

Route::get('get_inspektorat_stok_opname_content', 'MutasiController@get_pemprov_stok_opname_content');

Route::get('report_inspektorat_pemkot/penerimaan', 'GoodreceiptController@laporan_penerimaan_content_pemkot');

Route::get('report_inspektorat_pemkabs/penerimaan', 'GoodreceiptController@laporan_penerimaan_content_pemkab');

Route::post('report_bpk_receipt', 'GoodreceiptController@set_data_bpk');

//========================================== Laporan Pengeluaran =======================================================

Route::get('report/pengeluaran', 'ExpenduresController@laporan_pengeluaran_content');

Route::get('report_bpk/pengeluaran', 'ExpenduresController@laporan_bpk_pengeluaran_content');

Route::get('report_inspektorat/pengeluaran', 'ExpenduresController@laporan_pemprov_pengeluaran_content');

Route::get('report_inspektorat_pemkot/pengeluaran', 'ExpenduresController@laporan_pemkot_pengeluaran_content');

Route::get('report_inspektorat_pemkab/pengeluaran', 'ExpenduresController@laporan_pemkab_pengeluaran_content');

Route::get('report_expendures', 'ExpenduresController@get_data');

Route::post('report_receipt_exp', 'ExpenduresController@set_data');

Route::post('report_bpk_receipt_exp', 'ExpenduresController@set_data_bpk');



//========================================== Laporan Pakai Habis =======================================================

Route::get('report/bph', 'ExpenduresController@laporan_bph_content');

Route::get('report_bpk/bph', 'ExpenduresController@laporan_bpk_bph_content');

Route::get('report_inspektorat/bph', 'ExpenduresController@laporan_pemrov_bph_content');

Route::get('report_inspektorat_pemkot/bph', 'ExpenduresController@laporan_pemkot_bph_content');

Route::get('report_inspektorat_pemkab/bph', 'ExpenduresController@laporan_pemkab_bph_content');

Route::get('bph', 'ExpenduresController@get_data_bph');

Route::post('bph/post', 'ExpenduresController@set_data_bph');

Route::post('bph_bpk/post', 'ExpenduresController@set_data_bph_bpk');

//========================================== Laporan Semester ==========================================================
Route::get('report/semester', 'ExpenduresController@laporan_semester');

Route::get('semester', 'ExpenduresController@get_data_semester');

Route::post('print_report_semester', 'ExpenduresController@set_data_semester');

Route::get('report/semester/bpk', 'ExpenduresController@laporan_semester_bpk');

Route::get('report/semester/inspekorat', 'ExpenduresController@laporan_semester_pemprov');

Route::get('report/semester/inspekoratpemkot', 'ExpenduresController@laporan_semester_pemkot');

Route::get('report/semester/inspekoratpemkab', 'ExpenduresController@laporan_semester_pemkab');

//========================================== Kartu Barang ==============================================================

Route::get('report_kb', 'MutasiController@laporan_kb_content');

Route::get('report_bpk_kb', 'MutasiController@laporan_kb_content_bpk');

Route::get('report_inspektorat_kb', 'MutasiController@laporan_kb_content_pemprov');

Route::get('report_inspektorat_pemkot_kb', 'MutasiController@laporan_kb_content_pemkot');

Route::get('report_inspektorat_pemkab_kb', 'MutasiController@laporan_kb_content_pemkab');

Route::post('get_kb', 'MutasiController@get_kb');

Route::post('get_bpk_kb', 'MutasiController@get_bpk_kb');

Route::post('set_kb', 'MutasiController@set_kb');

Route::post('set_bpk_kb', 'MutasiController@set_bpk_kb');

//========================================= Laporan Mutasi =============================================================

Route::get('get_mutasi', 'MutasiController@remake_get_mutasi');

Route::get('get_mutasi_', 'MutasiController@laporan_mutasi_content');

Route::get('get_mutasi_bpk', 'MutasiController@laporan_bpk_mutasi_content');

Route::get('get_mutasi_inspektorat', 'MutasiController@laporan_pemprov_mutasi_content');

Route::get('get_mutasi_inspektorat_pemkot', 'MutasiController@laporan_pemkot_mutasi_content');

Route::get('get_mutasi_inspektorat_pemkab', 'MutasiController@laporan_pemkab_mutasi_content');

Route::post('get_mutasi_print', 'MutasiController@set_mutasi');

Route::post('get_mutasi_print_bpk', 'MutasiController@set_mutasi_bpk');

//==========================================  Laporan Stok Barang ======================================================

Route::get('get_stok_', 'MutasiController@get_stok_goods_');

Route::get('get_stok', 'MutasiController@get_stok_goods');

Route::get('get_bpk_stok_', 'MutasiController@get_bpk_stok_goods_');

Route::get('get_inspektorat_stok_', 'MutasiController@get_pemprov_stok_goods_');

Route::get('get_inspektorat_pemkot_stok_', 'MutasiController@get_pemkot_stok_goods_');

Route::get('get_inspektorat_pemkab_stok_', 'MutasiController@get_pemkab_stok_goods_');

Route::post('get_stok_print', 'MutasiController@set_stok_goods');

Route::post('get_stok_print_print', 'MutasiController@set_bpk_stok_goods');

//============================================ Laporan Stok Opname =====================================================

Route::get('get_stok_opname', 'MutasiController@get_stok_opname');

//Route::get('get_stok_opname_cek', 'MutasiController@get_new_stok_opname');

Route::get('get_stok_opname_content', 'MutasiController@get_stok_opname_content');

Route::get('get_bpk_stok_opname_content', 'MutasiController@get_bpk_stok_opname_content');

//Route::get('get_bpk_stok_opname_content', 'MutasiController@get_pemprov_stok_opname_content');

Route::get('get_inspektorat_pemkot_stok_opname_content', 'MutasiController@get_pemkot_stok_opname_content');

Route::get('get_inspektorat_pemkab_stok_opname_content', 'MutasiController@get_pemkab_stok_opname_content');

Route::post('get_stok_opname_print', 'MutasiController@set_stok_opname');

//============================================ Print Cetak Surat =======================================================

Route::get('PrinteLetterExp/{id}', 'LetterOfExpenditures@printLetter');

Route::post('PrinteLetterReq/{id}', 'LetterOfRequest@printLetter');
//
Route::get('singkron', 'MutasiController@singron_mutasi');

//================================================== Laporan Berita Acara Pemeriksaan ==================================

Route::get('berita_acara_pemeriksaan', 'GoodreceiptController@laporan_berita_acara_pemeriksaan');

Route::get('berita_acara_pemeriksaan_inspektorat', 'GoodreceiptController@laporan_berita_acara_pemeriksaan_inspektorat');

Route::get('berita_acara_pemeriksaan_inspektorat_pemkab', 'GoodreceiptController@laporan_berita_acara_pemeriksaan_inspektorat_pemkab');

Route::get('berita_acara_pemeriksaan_inspektorat_pemkot', 'GoodreceiptController@laporan_berita_acara_pemeriksaan_inspektorat_pemkot');

Route::get('berita_acara_pemeriksaan_bpk', 'GoodreceiptController@laporan_berita_acara_pemeriksaan_bpk');

Route::post('cetak_berita_acara_pemeriksaan', 'GoodreceiptController@print_berita_acara_pemeriksaan');

//============================================ Stok gudang =============================================================

Route::get('stock', 'StokController@index');

Route::get('getDataStock/{id_tahun_anggaran}', 'StokController@getDataStock');

Route::get('insertStok', 'StokController@create');

Route::post('storeStok', 'StokController@store');

Route::get('editStok/{id}', 'StokController@edit');

Route::put('updateStok/{id}', 'StokController@update');

Route::get('deleteStok/{id}', 'StokController@delete');


//=========================================== Langganan ================================================================

Route::get('langganan','LanggananCotroller@create');

Route::get('get_price/{id}','LanggananCotroller@getPrice');

Route::get('get_periode/{id}','LanggananCotroller@getPeriode');

Route::post('prosesLangganan','LanggananCotroller@prosesLangganan');

Route::get('daftartagihan','LanggananCotroller@index');

Route::get('memberbiasa','LanggananCotroller@memberbiasa');

Route::get('detailtagihan/{id}','LanggananCotroller@detail');

Route::get('detail_print/{id}','LanggananCotroller@detail_print');

Route::get('konfirmasi/{id}','LanggananCotroller@konfirmasi');

Route::get('cek_periode','LanggananCotroller@informasi');

Route::put('prosesConfirm/{id}','LanggananCotroller@prosesConfirm');


//=============================================== Laporan Rekaputulasi Persediaan ======================================

Route::get('report_rekap_spj', 'SpjController@report_spj');

Route::post('report_rekap_spj_print', 'SpjController@report_spj_print');

Route::get('report_rekap_spj_inpektorat', 'SpjController@report_spj_inspektorat');

Route::get('report_rekap_spj_inspektorat_print', 'SpjController@report_spj_inspektorat_print');

Route::get('report_rekap_spj_inspektorat_print', 'SpjController@report_spj_inspektorat_print');

Route::get('report_rekap_spj_bpk', 'SpjController@report_spj_Bpk');

Route::get('report_rekap_spj_inpektorat_pemkab', 'SpjController@report_spj_inspektorat_pemkab');

Route::get('report_rekap_spj_inpektorat_pemkot', 'SpjController@report_spj_inspektorat_pemkot');


//================================================= Laporan Realisasi Barang Pakai Habis ===============================
Route::get('report_realisasi_pakai_habis','BelanjaController@report_realisasi_pakai_habis');

Route::get('report_realisasi_pakai_habis_inspektorat','BelanjaController@report_realisasi_pakai_habis_inspektorat');

Route::get('report_realisasi_pakai_habis_inspektorat_pemkab','BelanjaController@report_realisasi_pakai_habis_ins_pemkab');

Route::get('report_realisasi_pakai_habis_inspektorat_pemkot','BelanjaController@report_realisasi_pakai_habis_ins_pemkot');

Route::get('report_realisasi_pakai_habis_bpk','BelanjaController@report_realisasi_pakai_habis_bpk');

Route::get('cek_data_realisasi','BelanjaController@data_realisasi_pakai_habis');

Route::post('cetak_realisasi_pakai_habis','BelanjaController@cetak_realisasi_pakai_habis');

//================================================== Laporan Rekapitulasi barang =======================================

Route::get('laporan_perjenis_barang','GoodreceiptController@laporan_perjenis_barang');

Route::post('print_laporan_perjenis_barang','GoodreceiptController@print_perjenis_barang');

Route::get('laporan_perjenis_barang_bpk','GoodreceiptController@laporan_perjenis_barang_bpk');

Route::get('laporan_perjenis_barang_inspektorat','GoodreceiptController@laporan_perjenis_barang_inspektorat');

Route::get('laporan_perjenis_barang_inspektorat_pemkab','GoodreceiptController@laporan_perjenis_barang_inspektorat_pemkab');

Route::get('laporan_perjenis_barang_inspektorat_pemkot','GoodreceiptController@laporan_perjenis_barang_inspektorat_pemkot');


//================================================== Laporan Berita Acara Pemeriksaan ==================================

Route::get('berita_acara_pemeriksaan', 'GoodreceiptController@laporan_berita_acara_pemeriksaan');

Route::get('cek_berita_acara', 'MutasiController@get_stok_opname_cek_base_jenis_barang');

Route::get('berita_acara_pemeriksaan_inspektorat', 'GoodreceiptController@laporan_berita_acara_pemeriksaan_inspektorat');

Route::get('berita_acara_pemeriksaan_inspektorat_pemkab', 'GoodreceiptController@laporan_berita_acara_pemeriksaan_inspektorat_pemkab');

Route::get('berita_acara_pemeriksaan_inspektorat_pemkot', 'GoodreceiptController@laporan_berita_acara_pemeriksaan_inspektorat_pemkot');

Route::get('berita_acara_pemeriksaan_bpk', 'GoodreceiptController@laporan_berita_acara_pemeriksaan_bpk');

Route::post('cetak_berita_acara_pemeriksaan', 'GoodreceiptController@print_berita_acara_pemeriksaan');


//======================================================================================================================

Route::get('tiket_bantuan','TiketbantuanController@index');

Route::get('buat_tiket_bantuan','TiketbantuanController@create');

Route::post('buat_tiket_bantuan','TiketbantuanController@store');

Route::get('lihattiket/{id}','TiketbantuanController@detail');

//======================================================================================================================

Route::get('getMessage', 'InfoController@getMessage');

Route::get('getMessage/{id}', 'InfoController@getMessages');


//======================================================================================================================
//======================================================================================================================
//======================================================================================================================
//======================================================================================================================
//======================================================================================================================
//======================================================================================================================
//======================================================================================================================
//======================================================================================================================
//======================================================================================================================


Route::get('dashboard_bpk','DashboardBpkController@index');

Route::get('bpkAccount', 'AdminBPKController@index');

Route::get('tambah_akun', 'AdminBPKController@create');

Route::get('ubah_akun/{id}', 'AdminBPKController@edit');

Route::put('ubah_akun/{id}', 'AdminBPKController@update');

Route::put('hapus_akun/{id}', 'AdminBPKController@delete');

Route::post('tambah_akun', 'AdminBPKController@store');

Route::get('hak_akses/{id}', 'AdminBPKController@hak_akses');

Route::put('hak_akses/{id}', 'AdminBPKController@tambah_hak_akses');

Route::put('hapus_hak_akses/{id}', 'AdminBPKController@hapus_hak_akses');

Route::get('getHakakses/{id}', 'AdminBPKController@get_hak_akses');

//=======================
//===============================================================================================

Route::get('loginSebagaiInspektorat','AdminInspektoratController@index');

Route::post('login_admin_inspektorat','AdminInspektoratController@login');

Route::get('dashboardisnpektorat','DashboardSuperAdminInspetorat@index');

Route::get('buatAccoutAdminInspektorat','AdminInspetorat@index');

Route::get('tambahAccountInspektorat', 'AdminInspetorat@create');

Route::post('tambah_akun_inspektorat', 'AdminInspetorat@store');

Route::get('ubahAccountInspektorat/{id}', 'AdminInspetorat@edit');

Route::put('ubahAccountInspektorat/{id}', 'AdminInspetorat@update');

Route::put('hapusAccountInspektorat/{id}', 'AdminInspetorat@delete');

Route::get('hak_akses_inspektorat/{id}', 'AdminInspetorat@hak_akses');

Route::get('hak_aksesInspektorat/{id}', 'AdminInspetorat@get_hak_akses');

Route::put('tambah_hak_akses_inspektorat/{id}', 'AdminInspetorat@tambah_hak_akses');

Route::put('hapus_hak_akses_inspektorat/{id}', 'AdminInspetorat@hapus_hak_akses');
//======================================================================================================================
//======================================================================================================================
//======================================================================================================================
//======================================================================================================================
//======================================================================================================================

Route::post('login_bpk', 'RegisterController@loginbpka');

Route::get('halaman_instansi', 'BPKController@index');

Route::get('halaman_instasi_inspetorat', 'InspektoratController@index');

Route::get('lihatInstansi/{id}','BPKController@lihat_instansi');

Route::get('lihatInstansi_in/{id}','InspektoratController@lihat_instansi');



//============================================== Super admin pemkot ====================================================

Route::get('loginSebagaiInspektoratPemkot','Superadmin_inspektorat_pemkot_Controller@login');

Route::post('loginSebagaiInspektoratPemkot','Superadmin_inspektorat_pemkot_Controller@storelogin');

Route:: get('daftar_admin_inspektorat_pemkot','Superadmin_inspektorat_pemkot_Controller@index');

Route:: get('daftarAccountInspektoratPemkot','AdminInspektoratPemkotController@index');

Route::get('createAdminInspektoratPemkot','AdminInspektoratPemkotController@create');
Route::post('createAdminInspektoratPemkot','AdminInspektoratPemkotController@store');

Route::get('editAdminInspektoratPemkot/{id}','AdminInspektoratPemkotController@edit');
Route::put('editAdminInspektoratPemkot/{id}','AdminInspektoratPemkotController@update');

Route::put('deleteAdminInspektoratPemkot/{id}','AdminInspektoratPemkotController@delete');

Route::get('hak_akses_inspektorat_pemkot/{id}','HakAksesInpektoratPemkot@daftar_instansi');
Route::get('hakAksesInpektoratPemkot/{id}','HakAksesInpektoratPemkot@get_hak_akses');

Route::put('tambah_hak_akses_inspektorat_pemkot/{id}','HakAksesInpektoratPemkot@tambah_hak_akses');
Route::put('hapus_hak_akses_inspektorat_pemkot/{id}','HakAksesInpektoratPemkot@hapus_hak_akses');

//=====================================================admin inspektorat pemkot ========================================
Route::get('halaman_instasi_inspetorat_pemkot','InspektoratController@hakAksespemkot');

Route::get('lihatInstansiPemkot_in/{id}','InspektoratController@lihat_instansiPemkot');

Route::get('halaman_instasi_inspetorat_pemkot', 'InspektoratController@hakAksespemkot');

Route::get('keluar_pegawai_instansi_pemkot','RegisterController@keluar_pegawai_in_pemkot');


//================================================= admin inspektorat pemkab============================================

Route::get('loginSebagaiInspektoratPemKab','Superadmin_inspektorat_pemkab_Controller@login');
Route::post('loginSebagaiInspektoratPemKab','Superadmin_inspektorat_pemkab_Controller@storelogin');

Route::get('daftar_admin_inspektorat_pemkab','AdminInspektoratPemkabController@index');

Route::get('dashboard_pemkab','AdminInspektoratPemkabController@index');
Route::get('daftarAccountInspektoratPemkab','AdminInspektoratPemkabController@daftarAdminInspektorat');
Route::get('createAdminInspektoratPemkab','AdminInspektoratPemkabController@create');
Route::post('createAdminInspektoratPemkab','AdminInspektoratPemkabController@store');

Route::get('editAdminInspektoratPemkab/{id}','AdminInspektoratPemkabController@edit');
Route::put('editAdminInspektoratPemkab/{id}','AdminInspektoratPemkabController@update');
Route::put('deleteAdminInspektoratPemkab/{id}','AdminInspektoratPemkabController@delete');

Route::get('hak_akses_inspektorat_pemkab/{id}','HakAksesInspektoratPemKab@daftar_instansi');
Route::get('hakAksesInpektoratPemkab/{id}','HakAksesInspektoratPemKab@get_hak_akses');
Route::put('tambah_hak_akses_inspektorat_pemkab/{id}','HakAksesInspektoratPemKab@tambah_hak_akses');
Route::put('hapus_hak_akses_inspektorat_pemkab/{id}','HakAksesInspektoratPemKab@hapus_hak_akses');

//=====================================================admin inspektorat pemkab ========================================
Route::get('halaman_inspektorat_pemkab','InspektoratPemkabController@halaman');

Route::get('lihatInstansiPemkab_in/{id}','InspektoratPemkabController@lihat_instansiPemkab');

Route::get('halaman_instasi_inspektorat_pemkab', 'InspektoratController@hakAksespemkot');

Route::get('keluar_pegawai_instansi_pemkab','RegisterController@keluar_pegawai_in_pemkab');


//======================================================================================================================

//============================================= Super Admin=============================================================
Route::get('superusers','PrivateAccountController@index');

Route::post('superusers','PrivateAccountController@login');

Route::get('superadminbpk','SuperadminBpkController@index');

Route::get('tambahaccountsuperadminbpk','SuperadminBpkController@create');

Route::post('storeSuperadminBpk','SuperadminBpkController@store');

Route::get('ubahaccountsuperadminbpk/{id}','SuperadminBpkController@edit');

Route::put('updateSuperadminBpk/{id}','SuperadminBpkController@update');

Route::put('hapusaccountsuperadminbpk/{id}','SuperadminBpkController@delete');


Route::get('superadminspektorat','AdminInspektoratController@list_superadmin_inspektorat');

Route::get('tambahaccountsuperadminInspektorat','AdminInspektoratController@create');

Route::post('storeSuperadminInspektorat','AdminInspektoratController@store');

Route::get('ubahaccountsuperadmininspektorat/{id}','AdminInspektoratController@edit');

Route::put('ubahaccountsuperadmininspektorat/{id}','AdminInspektoratController@update');

Route::put('hapusaccountsuperadmininspektorat/{id}','AdminInspektoratController@delete');

Route::get('superadmininspektoratPemkot','Superadmin_inspektorat_pemkot_Controller@list_data_inspektorat_pemkot');

Route::get('tambahaccountsuperadminInspektoratpemkot','Superadmin_inspektorat_pemkot_Controller@create');

Route::post('storeSuperadminInspektoratPemkot','Superadmin_inspektorat_pemkot_Controller@store');

Route::get('ubahaccountsuperadmininspektoratpemkot/{id}','Superadmin_inspektorat_pemkot_Controller@edit');

Route::put('ubahaccountsuperadmininspektoratpemkot/{id}','Superadmin_inspektorat_pemkot_Controller@update');

Route::put('hapusaccountsuperadmininspektoratpemkot/{id}','Superadmin_inspektorat_pemkot_Controller@delete');

Route::get('superadmininspektoratPemkab','Superadmin_inspektorat_pemkab_Controller@index');

Route::get('tambahaccountsuperadminInspektoratpemkab','Superadmin_inspektorat_pemkab_Controller@create');
Route::post('tambahaccountsuperadminInspektoratpemkab','Superadmin_inspektorat_pemkab_Controller@store');

Route::get('ubahaccountsuperadminInspektoratpemkab/{id}','Superadmin_inspektorat_pemkab_Controller@edit');
Route::put('ubahaccountsuperadminInspektoratpemkab/{id}','Superadmin_inspektorat_pemkab_Controller@update');

Route::put('hapusaccountsuperadminInspektoratpemkab/{id}','Superadmin_inspektorat_pemkab_Controller@delete');

Route::get('pengguna_persediaan', 'Superadmin_pengguna_persediaan@index');

Route::get('provinsi','ProvinsiController@index');

Route::get('tambahprovinsi','ProvinsiController@create');

Route::post('storeProvinsi','ProvinsiController@store');

Route::get('editprovinsi/{id}','ProvinsiController@edit');

Route::put('updateprovinsi/{id}','ProvinsiController@update');

Route::put('hapusprovinsi/{id}','ProvinsiController@delete');

Route::get('kabupaten','KabupatenController@index');

Route::get('tambahkabupaten','KabupatenController@create');

Route::post('storekabupaten','KabupatenController@store');

Route::get('editkabupaten/{id}','KabupatenController@edit');

Route::get('getkabupaten/{id}','KabupatenController@getKabupaten');

Route::put('updatekabupaten/{id}','KabupatenController@update');

Route::put('hapuskabupaten/{id}','KabupatenController@delete');

Route::get('tarif','TarifPaketController@index');

Route::get('tambahtarifpaket','TarifPaketController@create');

Route::post('tambahtarifpaket','TarifPaketController@store');

Route::get('ubahtarifPaket/{id}','TarifPaketController@edit');

Route::put('ubahtarifPaket/{id}','TarifPaketController@update');

Route::put('hapustarifPaket/{id}','TarifPaketController@delete');

Route::get('daftar_langganan', "LanggananCotroller@dataLangganana");

Route::get('lihat_struk/{id}',"LanggananCotroller@dataStruck");

Route::put('lihat_struk/{id}',"LanggananCotroller@update_status_aktif");

Route::put('off_langganan/{id}',"LanggananCotroller@off_langganan");

Route::get('pesan/{user_id}', 'infoController@superadmin_kirim_pesan_ke_pengguna');

Route::get('pesan_to/{user_id}','infoController@halaman_pesan');

Route::post('pesan_to/{user_id}','infoController@store_pesan');

Route::put('hapus_pesan/{id_pesan}', 'infoController@delete_pesan');

//===================================================Pelatihan =========================================================

Route::get('jadwal_pel','JadwalPelatihanController@index');

Route::get('create_jadwal_pel','JadwalPelatihanController@create');

Route::post('create_jadwal_pel','JadwalPelatihanController@store');

Route::get('edit_jadwal_pel/{id}','JadwalPelatihanController@edit');

Route::put('update_jadwal_pel/{id}','JadwalPelatihanController@update');

Route::put('hapus_jadwal_pel/{id}','JadwalPelatihanController@delete');

Route::get('waktu_pelatihan','WaktuPelController@index');

Route::get('create_waktu_pelatihan','WaktuPelController@create');

Route::post('store_waktu_pel','WaktuPelController@store');

Route::get('edit_waktu_pel/{id}','WaktuPelController@edit');

Route::put('update_waktu_pel/{id}','WaktuPelController@update');

Route::put('hapus_hapus_pel/{id}','WaktuPelController@delete');

Route::get('getWaktuPelatihan/{id}','WaktuPelController@get_waktu_pelatihan');

Route::get('kupon','KuponController@index');

Route::get('create_kupon', 'KuponController@create');

Route::post('store_kupon', 'KuponController@store');

Route::put('filterKupon', 'KuponController@filterCoupon');

Route::get('biaya_pel','BiayaPelatihanController@index');

Route::get('create_biaya_pel','BiayaPelatihanController@create');

Route::post('store_biaya_pel','BiayaPelatihanController@store');

Route::get('edit_biaya_pel/{id}','BiayaPelatihanController@edit');

Route::put('update_biaya_pel/{id}','BiayaPelatihanController@update');

Route::put('delete_biaya_pel/{id}','BiayaPelatihanController@delete');

Route::get('get_biaya_pel/{id}/{id2}','BiayaPelatihanController@getBiayaPelatihan');

Route::get('konfirmasi_pelatihan/{kode_pelatihan}','ConfirmPelatihanController@pageKonfirmasi');

Route::post('konfirmasi_pelatihan','ConfirmPelatihanController@konfirmasiPelatihan');

//============================================Registrasi Pelatihan =====================================================

Route::post('registrasiPelatihan','RegisterPelatihanController@daftar');

Route::get('testEmail', function (){
     return view('front_end.page_konfirmasi');
});

Route::get('list_registrasi_pelatihan','RegisterPelatihanController@index');

Route::get('list_konfirmasi','ConfirmPelatihanController@index');


//================================== URL Baru ==========================================================================

	
Route::get('tbkResponse/{id}', 'TbkController@tbk_respone');

Route::post('goodreceipt/multiStore', 'GoodreceiptController@Multistore');

Route::get('report_rekap_spj_bpk', 'SpjController@report_spj_Bpk');

Route::get('report_rekap_spj_inpektorat_pemkab', 'SpjController@report_spj_inspektorat_pemkab');

Route::get('report_rekap_spj_inpektorat_pemkot', 'SpjController@report_spj_inspektorat_pemkot');

Route::get('report_realisasi_pakai_habis_inspektorat','BelanjaController@report_realisasi_pakai_habis_inspektorat');

Route::get('report_realisasi_pakai_habis_inspektorat_pemkab','BelanjaController@report_realisasi_pakai_habis_ins_pemkab');

//Route::get('report_realisasi_pakai_habis_inspektorat_pemkot','BelanjaController@laporan_perjenis_barang_inspektorat_pemkot');

Route::get('report_realisasi_pakai_habis_bpk','BelanjaController@report_realisasi_pakai_habis_bpk');

Route::get('laporan_perjenis_barang_bpk','GoodreceiptController@laporan_perjenis_barang_bpk');

Route::get('laporan_perjenis_barang_inspektorat','GoodreceiptController@laporan_perjenis_barang_inspektorat');

Route::get('laporan_perjenis_barang_inspektorat_pemkab','GoodreceiptController@laporan_perjenis_barang_inspektorat_pemkab');

Route::get('laporan_perjenis_barang_inspektorat_pemkot','GoodreceiptController@laporan_perjenis_barang_inspektorat_pemkot');



//======================================================================================================================

Route::get('data-simda','Simda\KodeRekening@index');

Route::get('belanja/{kd_urusan}/{kd_unit}/{kd_bidang}/{kd_prog}/{kd_keg}/{kd_rek_1}/{kd_rek_2}/{kd_rek_3}/{kd_rek_4}/{kd_rek_5}/'
    ,'Simda\KodeRekening@belanja');

Route::post('import-to-persediaan','Simda\SimtoToPersediaan@importSimda');


//==============================================Laporan Rekapitulasi ===================================================

Route::get('laporan-permintaan-bpk','MutasiController@format_permintaan_bpk_content');

Route::get('cek-laporan-bpk-baru', 'MutasiController@format_permintaan_bpk');

Route::post('print-laporan-bpk-baru', 'MutasiController@print_mutasi_tambah_kurang');