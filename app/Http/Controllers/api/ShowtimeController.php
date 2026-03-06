<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ShowtimeService;
use Illuminate\Http\Request;

class ShowtimeController extends Controller
{
    protected $service;

    public function __construct(ShowtimeService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json($this->service->getAllShowtimes());
    }

    public function show($id)
    {
        return response()->json($this->service->getShowtimeById($id));
    }

    public function checkSeats($id)
    {
        return response()->json($this->service->getAvailableSeats($id));
    }
}
