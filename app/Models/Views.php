<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Views extends Model
{
    use HasFactory;

    protected $fillable = [
      'post_id',
      'user_ip',
      'method',
      'host',
      'url',
      'referer',
      'country',
      'device',
      'operating',
      'browser',
      'browser_version',
      'time_zone',
      'asn',
      'asn_org',
      'view_at',
      'date_at',
    ];
}
