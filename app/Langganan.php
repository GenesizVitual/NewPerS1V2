<?php

namespace App;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Langganan extends Model
{
    //
    //use Cachable;
    protected $table = 'langganan';

    protected $fillable =['paket_harga_id','priode_paket_id','begin_date','end_date','status','user_id'];

    public function get_periode()
    {
        return $this->belongsTo('App\PriodePaket','priode_paket_id');
    }

    public function get_harga()
    {
        return $this->belongsTo('App\PaketPrice','paket_harga_id');
    }

    public function get_user()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
