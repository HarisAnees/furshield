<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class ProductRequest extends FormRequest { public function authorize():bool{return $this->user()?->role==='admin';} public function rules():array{return ['name'=>'required|string|max:255','slug'=>'nullable|string|max:255|unique:products,slug,'.$this->route('product')?->id,'category'=>'required|string|max:100','description'=>'nullable|string','price'=>'required|numeric|min:0','stock_quantity'=>'required|integer|min:0','image_path'=>'nullable|string|max:1000','is_active'=>'boolean'];} }
