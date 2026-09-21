<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Order extends Model { 
    protected $fillable=['user_id','status','subtotal','notes']; 
    protected function casts():array{return ['subtotal'=>'decimal:2'];} 
    public function user(){return $this->belongsTo(User::class);} 
    public function items(){return $this->hasMany(OrderItem::class);} 
    public function getTotalAmountAttribute(){
        if (!is_null($this->subtotal) && (float)$this->subtotal > 0) {
            return (float)$this->subtotal;
        }
        return (float)($this->items->sum('line_total') ?: $this->items->sum(function($item) {
            return ($item->unit_price ?? 0) * ($item->quantity ?? 1);
        }));
    }
}
