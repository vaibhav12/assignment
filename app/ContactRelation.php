<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactRelation extends Model
{
    protected $fillable = ['contact_id','relation_contact_id'];
}
