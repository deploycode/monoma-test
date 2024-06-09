<?php

namespace App\Repositories;

use App\Models\Candidate;
use Illuminate\Support\Facades\Auth;

class CandidateRepository
{
    protected $model;

    public function __construct(Candidate $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        $user = Auth::user();
        if($user->role === 'agent') {
            return Candidate::query()->where('owner', $user->id)->get();
        }else {
            return $this->model->all();
        }

    }

    public function show($id)
    {
        $user = Auth::user();
        if($user->role === 'agent') {
            $candidate = Candidate::query()
                ->where('owner', $user->id)
                ->where('id', $id)->first();
            if ($candidate) {
                return $candidate;
            }
            return null;
        }else {
            return $this->model->find($id) ?? null;
        }

    }

    public function store(array $candidate)
    {
        $candidate['created_by'] = auth()->id();
        return $this->model->create($candidate);
    }

    public function update(array $candidate, $id){
        return $this->model->findOrFail($id)->update($candidate);
    }

    public function destroy($id){
        return $this->model->destroy($id);
    }
}
