<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCandidateRequest;
use App\Http\Resources\Candidate as CandidateResource;
use App\Http\Resources\CandidateCollection;
use App\Repositories\CandidateRepository;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CandidateController extends Controller
{
    use ApiResponse;
    protected CandidateRepository $candidateRepository;

    public function __construct(CandidateRepository $candidateRepository)
    {
        $this->candidateRepository = $candidateRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $candidateCollection = new CandidateCollection($this->candidateRepository->index());
        if(count($candidateCollection) > 0) {
            return $this->successResponse($candidateCollection);
        } else {
            return $this->errorResponse(['Not found'], ResponseAlias::HTTP_NOT_FOUND);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCandidateRequest $request)
    {
        $candidateResource = new CandidateResource($this->candidateRepository->store($request->validated()));
        return $this->successResponse($candidateResource, ResponseAlias::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $candidateResource = $this->candidateRepository->show($id);
        return $this->successResponse($candidateResource, ResponseAlias::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
