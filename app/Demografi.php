<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Demografi extends Model
{
    protected $table = 'pkbl_lapkinerja_transaksi_demografimb';

    const CREATED_AT = 'add_date';
    const UPDATED_AT = 'update_date';
}
