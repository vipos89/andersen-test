<?php
declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Interfaces\RepositoryInterfaces\TransactionInterface;
use App\Traits\Api\ApiResponse;
use Illuminate\Http\Response;

class TransactionController extends Controller
{
    use ApiResponse;

    /**
     * @var TransactionInterface
     */
    private $transactionRepository;

    /**
     * TransactionController constructor.
     * @param TransactionInterface $transactionRepository repository
     */
    public function __construct(TransactionInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Display a listing of the user transactions.
     *
     * @return Response
     */
    public function index()
    {
        return $this->transactionRepository
            ->getUserTransactions(auth()->user()->getAuthIdentifier());
    }

    /**
     * Create new transaction
     * @param TransactionRequest $transactionRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TransactionRequest $transactionRequest)
    {
        try {
            $res = $this->transactionRepository->createTransaction(
                $transactionRequest->input('from'),
                $transactionRequest->input('to'),
                (int)$transactionRequest->input('amount')
            );
            return $this->successResponse('Success', $res);
        } catch (\Exception $exception) {
            return $this->errorResponse('Error');
        }
    }
}
