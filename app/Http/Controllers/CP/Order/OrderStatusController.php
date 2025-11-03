<?php

namespace App\Http\Controllers\CP\Order;

use App\Enums\OrderStatus;
use App\Exceptions\CustomBusinessException;
use App\Http\Controllers\Controller;
use App\Models\Constant;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderStatusController extends Controller
{
    private $_model;

    private $config;

    public function __construct(Order $_model)
    {
        $this->config = config('modules.orders');

        $this->_model = $_model;
    }

    public function get_status_form(Request $request, Order $_model): JsonResponse
    {
        try {
            $data = [
                '_view_path' => $this->config['view_path'],
                '_model' => $_model,
                'config' => $this->config,
                'status_list' => OrderStatus::cases(),
                'title' => t('Change Status'),
            ];

            $view = view($data['_view_path'] . '.modals.status_form', $data)->render();

            Log::info('Status form rendered successfully', [
                'order_id' => $_model->id,
                'view_path' => $data['_view_path'] . '.modals.status_form',
            ]);

            return response()->json(['createView' => $view]);
        } catch (\Exception $e) {
            Log::error('Error in get_status_form', [
                'order_id' => $_model->id,
                'error_message' => $e->getMessage(),
                'error_line' => $e->getLine(),
                'error_file' => $e->getFile(),
            ]);

            return response()->json([
                'error' => t('An error occurred while rendering the status form.'),
                'error_message' => $e->getMessage(),
            ], 500);
        }
    }

    public function update_status(Request $request, Order $_model): JsonResponse
    {
        try {
            DB::beginTransaction();
            $_model->update([
                'status' => $request->status,
            ]);
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => t('Status has been updated successfully!'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in updateStatus', [
                'order_id' => $_model->id,
                'requested_status' => $request->status,
                'current_status' => $_model->status,
                'error_message' => $e->getMessage(),
                'error_line' => $e->getLine(),
                'error_file' => $e->getFile(),
            ]);
            return response()->json([
                'status' => false,
                'message' => t('An error occurred while updating the status.'),
            ], 500);
        }
    }
}
