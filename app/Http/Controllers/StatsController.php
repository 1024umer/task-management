<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function index(){
        $authUserId = auth()->user()->id;
        $work = Work::whereHas('proposal', function ($query) use ($authUserId) {
                $query->where('user_id', $authUserId);
            })
            ->get();
    
        $pendingCount = $work->where('is_pending', 1)->count();
        $completedCount = $work->where('is_completed', 1)->count();
        $reviewCount = $work->where('is_review', 1)->count();
        $progressCount = $work->where('is_progress', 1)->count();
    
        return response()->json([
            'pending_count' => $pendingCount,
            'completed_count' => $completedCount,
            'progress_count' => $progressCount,
            'review_count' => $reviewCount,
        ]);
    }
}
