<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search', '');

        // Get talents (role = 'talent') with their services
        $talents = User::where('role', 'talent')
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })
            ->with('services')
            ->paginate(12);

        // Dummy carousel images (static for now)
        $carouselImages = [
            'https://ps.w.org/image-slider-widget/assets/banner-772x250.png?rev=1674939',
            'https://ps.w.org/image-slider-widget/assets/banner-772x250.png?rev=1674939',
            'https://ps.w.org/image-slider-widget/assets/banner-772x250.png?rev=1674939',
        ];

        return view('dashboard.index', compact('talents', 'carouselImages', 'search'));
    }
}
