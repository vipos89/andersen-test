<?php
declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Exceptions\ExceedingLimitException;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Interfaces\RepositoryInterfaces\TransactionInterface;
use App\Services\TransactionService;
use App\Traits\Api\ApiResponse;
use Illuminate\Http\JsonResponse;
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
     *
     * @param TransactionInterface $transactionRepository repository
     */
    public function __construct(TransactionInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Display a listing of the user transactions.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $data = $this->transactionRepository
                ->getUserTransactions(
                    auth()->user()->getAuthIdentifier()
                );
            return $this->successResponse(
                'User transactions',
                TransactionResource::collection($data)
            );
        } catch (\Exception $exception) {
            return $this->errorResponse(
                $exception->getMessage(),
                Response::HTTP_NOT_FOUND
            );
        }
    }

    /**
     * Create new transaction
     *
     * @param TransactionRequest $transactionRequest validation
     *
     * @return JsonResponse
     */
    public function store(TransactionRequest $transactionRequest): JsonResponse
    {
        try {
            $res = (new TransactionService())
                ->createTransaction(
                    $transactionRequest->input('from'),
                    $transactionRequest->input('to'),
                    (int)$transactionRequest->input('amount')
                );
            return $this->successResponse(
                'Success',
                new TransactionResource($res)
            );
        } catch (ExceedingLimitException $exception) {
            return $this->errorResponse(
                $exception->getMessage(),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        } catch (\Exception $exception) {
            return $this->errorResponse(
                $exception->getMessage(),
                Response::HTTP_EXPECTATION_FAILED
            );
        }
    }
}
