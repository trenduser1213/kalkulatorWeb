<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class KalkulatorController extends Controller
{
    public function calculate(Request $request)
    {
        try {
            // Validasi input
            $validator = Validator::make($request->all(), [
                'operand1' => 'required|numeric',
                'operator' => 'required|in:+,-,*,/',
                'operand2' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors(),
                ], 400);
            }

            // Mendapatkan input dari permintaan
            $operand1 = $request->input('operand1');
            $operator = $request->input('operator');
            $operand2 = $request->input('operand2');

            // Melakukan operasi kalkulator
            $result = 0;
            if ($operator === '+') {
                $result = $operand1 + $operand2;
            } elseif ($operator === '-') {
                $result = $operand1 - $operand2;
            } elseif ($operator === '*') {
                $result = $operand1 * $operand2;
            } elseif ($operator === '/') {
                $result = $operand1 / $operand2;
            }

            // Mengembalikan hasil sebagai JSON
            return response()->json([
                'status' =>'Success',
                'result' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
