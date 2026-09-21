<?php

namespace App\Http\Controllers;

use App\Http\Requests\PetRequest;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PetController extends Controller
{
    public function index(Request $request)
    {
        return $request->user()->pets()->with(['healthRecords','medicalDocuments'])->latest()->paginate(12);
    }

    public function store(PetRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store("pets/{$request->user()->id}", 'local');
        }
        unset($data['image']);
        $pet = $request->user()->pets()->create($data);
        return response()->json($pet, 201);
    }

    public function show(Request $request, Pet $pet)
    {
        abort_unless($pet->user_id === $request->user()->id, 403);
        return response()->json($pet->load(['healthRecords','medicalDocuments','appointments.vet.user']));
    }

    public function update(PetRequest $request, Pet $pet)
    {
        abort_unless($pet->user_id === $request->user()->id, 403);
        $data = $request->validated();
        if ($request->hasFile('image')) {
            if ($pet->image_path) Storage::disk('local')->delete($pet->image_path);
            $data['image_path'] = $request->file('image')->store("pets/{$request->user()->id}", 'local');
        }
        unset($data['image']);
        $pet->update($data);
        return response()->json($pet);
    }

    public function destroy(Request $request, Pet $pet)
    {
        abort_unless($pet->user_id === $request->user()->id, 403);
        $pet->delete();
        return response()->json(['message'=>'Pet deleted.']);
    }
}
