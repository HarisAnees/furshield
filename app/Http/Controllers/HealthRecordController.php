<?php
namespace App\Http\Controllers;
use App\Http\Requests\HealthRecordRequest; use App\Models\{HealthRecord,Pet}; use Illuminate\Http\Request;
class HealthRecordController extends Controller {
 public function index(Request $r){$u=$r->user(); $q=HealthRecord::with('pet')->whereHas('pet',fn($x)=>$x->where('user_id',$u->id)); if($u->role==='vet')$q=HealthRecord::with('pet')->whereHas('pet.appointments',fn($x)=>$x->where('vet_id',$u->vetProfile?->id)); if($u->role==='admin')$q=HealthRecord::with('pet'); return $q->latest('recorded_at')->paginate(30);}
 public function store(HealthRecordRequest $r){$pet=Pet::findOrFail($r->pet_id);$u=$r->user();$allowed=$u->role==='admin'||$pet->user_id===$u->id||($u->role==='vet'&&$pet->appointments()->where('vet_id',$u->vetProfile?->id)->exists());abort_unless($allowed,403);return response()->json($pet->healthRecords()->create($r->validated()),201);}
 public function show(Request $r,HealthRecord $healthRecord){$u=$r->user();$pet=$healthRecord->pet;$allowed=$u->role==='admin'||$pet->user_id===$u->id||($u->role==='vet'&&$pet->appointments()->where('vet_id',$u->vetProfile?->id)->exists());abort_unless($allowed,403);return $healthRecord->load('pet');}
 public function update(HealthRecordRequest $r,HealthRecord $healthRecord){$pet=$healthRecord->pet;$u=$r->user();abort_unless($u->role==='admin'||$pet->user_id===$u->id||$u->role==='vet',403);$healthRecord->update($r->validated());return $healthRecord;}
 public function destroy(Request $r,HealthRecord $healthRecord){$pet=$healthRecord->pet;$u=$r->user();abort_unless($u->role==='admin'||$pet->user_id===$u->id,403);$healthRecord->delete();return response()->noContent();}
}
