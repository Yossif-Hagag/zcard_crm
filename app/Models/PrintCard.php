<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrintCard extends Model
{
    use HasFactory;

      // Define the table associated with the model if it's not the plural form of the model name
      protected $table = 'print_cards';

      // Specify the attributes that are mass assignable
      protected $fillable = [
          'print_id',
          'deal_id',
          'customer_name',
          'customer_phone',
          'card_name',
          'confirm_status',
          'confirm_reason',
          'card_code',
      ];

      // Define any relationships if necessary
      public function printing()
      {
          return $this->belongsTo(Printing::class, 'print_id');
      }
}
