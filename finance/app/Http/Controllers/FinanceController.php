<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Goal;
use App\Models\GatewayUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function setSalary(Request $request): JsonResponse
    {
        $user = GatewayUser::findOrFail(auth()->user()->id);

        $user->salary = $request->input('salary');
        $user->save();

        return response()->json(['message' => 'Зарплата обновлена']);
    }

    public function addExpense(Request $request): JsonResponse
    {
        $request->validate([
            'category' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        $user = GatewayUser::findOrFail(auth()->user()->id);

        $expense = new Expense();
        $expense->user_id = $user->id;
        $expense->category = $request->input('category');
        $expense->amount = $request->input('amount');
        $expense->save();

        return response()->json(['message' => 'Расход добавлен']);
    }

    public function calculate(): JsonResponse
    {
        $user = GatewayUser::findOrFail(auth()->user()->id);
        $salary = $user->salary;

        $expenses = Expense::where('user_id', $user->id)->get();

        $total_expenses = $expenses->sum('amount');

        $savings_percentage = $salary > 0 ? (($salary - $total_expenses) / $salary) * 100 : 0;

        $advice = '';
        if ($savings_percentage < 10) {
            $advice = 'Вам стоит подумать о сокращении расходов.';
        } elseif ($savings_percentage > 50) {
            $advice = 'Вы отлично копите! Можете позволить себе больше тратить.';
        }

        return response()->json([
            'salary' => $salary,
            'total_expenses' => $total_expenses,
            'savings_percentage' => $savings_percentage,
            'advice' => $advice,
        ]);
    }

    public function addGoal(Request $request): JsonResponse
    {
        $request->validate([
            'goal_name' => 'required|string',
            'goal_amount' => 'required|numeric',
        ]);

        $user = GatewayUser::findOrFail(auth()->user()->id);

        $goal = new Goal();
        $goal->user_id = $user->id;
        $goal->goal_name = $request->input('goal_name');
        $goal->goal_amount = $request->input('goal_amount');
        $goal->save();

        return response()->json(['message' => 'Цель накоплений добавлена']);
    }
}
