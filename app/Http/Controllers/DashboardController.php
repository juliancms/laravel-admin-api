<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\ChartResource;

class DashboardController extends Controller
{
    public function chart()
    {
        Gate::authorize('view', 'orders');

        $orders = Order::query()
            ->join('orders_items', 'orders.id', '=', 'orders_items.order_id')
            ->selectRaw("DATE_FORMAT(orders.created_at, '%Y-%m-%d') as date, sum(orders_items.quantity*orders_items.price) as sum")
            ->groupBy('date')
            ->get();

        return ChartResource::collection($orders);
    }
}
