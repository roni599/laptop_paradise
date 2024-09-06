<?php

namespace App\Http\Controllers\Reserve;

use App\Http\Controllers\Controller;
use App\Models\Reserve;
use Illuminate\Http\Request;

class ReserveController extends Controller
{
    public function index()
    {
        $payments = Reserve::with(['user', 'paymenttype', 'investment','expenser'])->get();
        return response()->json($payments);
    }
}
