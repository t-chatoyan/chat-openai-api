<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UpdateCustomerPasswordRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ChangePasswordController extends Controller
{
    /**
     * @param UpdatePasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function passwordResetProcess(UpdateCustomerPasswordRequest $request)
    {
        return $this->updatePasswordRow($request)->count() > 0 ? $this->resetPassword($request) : $this->tokenNotFoundError();
    }

    /**
     * @param $request
     * @return \Illuminate\Database\Query\Builder
     */
    private function updatePasswordRow($request)
    {
        return DB::table('password_resets')->where([
            'email' => $request->email,
            'token' => $request->token
        ]);
    }

    private function tokenNotFoundError()
    {
        return response()->json([
            'error' => 'Your email or token is wrong.'
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    private function resetPassword($request)
    {
        $userData = Customer::whereEmail($request->email)->first();

        $userData->update([
            'password' => bcrypt($request->password)
        ]);
        $this->updatePasswordRow($request)->delete();
        return response()->json([
            'data' => 'Password has been updated.'
        ], Response::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEmail(Request $request)
    {
        try {
            $customer = DB::table('password_resets')->where('token', $request->token)->first();
            $email = $customer->email;
            return response()->json([
                'email' => $email,
                'status' => true,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'messages' => $e->getMessage(),
                'status' => false,
            ], 500);
        }
    }
}
