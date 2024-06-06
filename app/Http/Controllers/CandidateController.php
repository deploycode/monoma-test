<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCandidateRequest;
use App\Http\Resources\Candidate as CandidateResource;
use App\Http\Resources\CandidateCollection;
use App\Repositories\CandidateRepository;
use Illuminate\Http\Request;


class CandidateController extends Controller
{
    protected CandidateRepository $candidateRepository;

    public function __construct(CandidateRepository $candidateRepository)
    {
        $this->candidateRepository = $candidateRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): CandidateCollection
    {
        return new CandidateCollection($this->candidateRepository->index());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCandidateRequest $request): CandidateResource
    {
        return new CandidateResource($this->candidateRepository->store($request->all()));
        // return new JsonResponse($this->candidateRepository->store($request->all()), ResponseAlias::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Candidate $lead)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Candidate $lead)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Candidate $lead)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Candidate $lead)
    {
        //
    }
}
