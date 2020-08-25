<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Interfaces\RepositoryInterfaces\TransactionInterface;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct(TransactionInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Display a listing of the user transactions.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->transactionRepository->getUserTransactions(auth()->user()->getAuthIdentifier());
    }

    /**
     * Create new transaction
     *
     * @param TransactionRequest $transactionRequest
     * @return \Illuminate\Http\Response
     */
    public function store(TransactionRequest $transactionRequest)
    {
        return $this->transactionRepository->createTransaction(
            $transactionRequest->input('from'),
            $transactionRequest->input('to'),
            $transactionRequest->input('amount')
        );
    }
}
