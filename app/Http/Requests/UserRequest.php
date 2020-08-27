<?php
declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:50',
            'email' => request()->route('user')
                ? 'required|email|max:255|unique:users,email,' . request()->route('user')
                : 'required|email|max:255|unique:users,email',
            'password' => request()->route('user')
                ? 'nullable' : 'required|max:50'
        ];
    }

    /**
     * @param  array $errors
     * @return JsonResponse
     */
    public function response($errors = []): JsonResponse
    {
        return new JsonResponse(
            [
            'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
            'errors' => $errors,
            ], Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
