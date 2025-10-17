<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminService;

class AdminDashboardController extends Controller
{
    public function __construct(
        private AdminService $adminService
    ) {}

    public function index()
    {
        $stats = $this->adminService->dashboardStats();
        return view('admin.dashboard', compact('stats'));
    }
}
