<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tradepair extends Model
{
    protected $table = 'bitcoinx_tradepairs';

    public function tradepairsdetails()
	{
	  return $this->belongsTo('App\User', 'user_id');
	}

	public function getCoinName($pairid,$type=NULL){
		$pair = Tradepair::where('id',$pairid)->first();
		if($type == 'coinone'){
			return $pair->coinone;
		}elseif($type == 'cointwo'){
			return $pair->cointwo;
		}else{
			return $pair;
		}
	}

	public function coinonedetail()
    {
      return $this->belongsTo('App\Models\Commission', 'coinone' ,'source');
    }
    public function cointwodetail()
    {
      return $this->belongsTo('App\Models\Commission', 'cointwo' ,'source');
    }

    public function getcointwo()
	{
	  return $this->cointwo;
	}

	public function getTradepairs($coinone,$cointwo,$active)
	{  return $this->where([
		['coinone', '=', $coinone],
		['cointwo', '=', $cointwo],
		['active', '=', $active] ])->first();
	}

	public function setcointwo($value)
	{
	   $this->cointwo=$value;
	}
	public function setid($value)
	{
	   $this->id=$value;
	}
	public function getid()
	{
	   return $this->id;
	}

}
