<?php

namespace App\Repositories;

use App\Models\Candidate;

class CandidateRepository
{
    protected $model;

    public function __construct(Candidate $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        return $this->model->all();
    }

    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    public function store(array $candidate)
    {
        $candidate['created_by'] = 1; // auth()->id()
        return $this->model->create($candidate);
    }

    public function update(array $candidate, $id){
        return $this->model->findOrFail($id)->update($candidate);
    }

    public function destroy($id){
        return $this->model->destroy($id);
    }
}
