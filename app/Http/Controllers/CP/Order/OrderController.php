<?php

namespace App\Http\Controllers\CP\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\CP\ProductRequest;
use App\Models\Category;
use App\Models\Order;
use App\Services\Filters\OrderFilterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Elibyy\TCPDF\TCPDFHelper;

class OrderController extends Controller
{
    protected $filterService;

    private $_model;

    private $config;

    public function __construct(
        Order $_model,
        OrderFilterService $filterService,
    ) {
        $this->config = config('modules.orders');
        $this->_model = $_model;
        $this->filterService = $filterService;

        Log::info('............... ' . $this->config['controller'] . ' initialized with ' . $this->config['singular_name'] . ' model ...........');
    }

    public function index(Request $request)
    {
        if ($request->isMethod('GET')) {
            $data = $this->getCommonData('index');

            return view($data['_view_path'] . 'index', $data);
        }

        if ($request->isMethod('POST')) {
            $items = $this->_model->query()
                ->latest($this->config['table'] . '.updated_at');

            if ($request->input('params')) {
                $this->filterService->applyFilters($items, $request->input('params'));
            }

            return DataTables::eloquent($items)
                ->editColumn('created_at', function ($item) {
                    if ($item->created_at) {
                        return [
                            'display' => $item->created_at->format('Y-m-d'),
                            'timestamp' => $item->created_at->timestamp,
                        ];
                    }
                })
                ->addColumn('customer_name', function ($item) {
                    $fullName = trim(($item->first_name ?? '') . ' ' . ($item->last_name ?? ''));
                    return '<a href="' . route($this->config['full_route_name'] . '.edit', ['_model' => $item->id]) . '" class="fw-bold text-gray-800 text-hover-primary">'
                        . ($fullName ?: 'N/A') . '</a>';
                })
                ->editColumn('phone', function ($item) {
                    return $item->phone ?? 'N/A';
                })
                ->editColumn('email', function ($item) {
                    return $item->email ?? 'N/A';
                })
                ->addColumn('status', function ($item) {
                    $html = '<a href="' . route($this->config['full_route_name'] . '.get_status_form', ['_model' => $item->id]) . '" class="fw-bold text-gray-800 text-hover-primary btn_get_status_form_order">';
                    $html .= $item->status->getBadge();
                    $html .= '</a>';
                    return $html ?: 'N/A';
                })
                ->editColumn('payment_method', function ($item) {
                    return $item->payment_method ? $item->payment_method->getLabel() : 'N/A';
                })
                ->addColumn('total_price', function ($item) {
                    return number_format($item->total_price_after_discount ?? 0, 2);
                })
                ->addColumn('action', function ($item) {
                    try {
                        return view($this->config['view_path'] . '.actions', [
                            '_model' => $item,
                            'config' => $this->config,
                        ])->render();
                    } catch (\Exception $e) {
                        Log::error('Error in getActionButtons', [
                            'error' => $e->getMessage(),
                            'model_id' => $item->id,
                        ]);
                        throw $e;
                    }
                })
                ->rawColumns(['customer_name', 'status', 'payment_method', 'total_price', 'action'])
                ->make(true);
        }
    }



    public function edit(Request $request, Order $_model)
    {
        $data = $this->getCommonData('edit');
        $data['_model'] = $_model;

        return view($data['_view_path'] . '.addedit', $data);
    }

    public function addedit(Request $request)
    {
        try {
            DB::beginTransaction();

            $id = $request->input($this->config['id_field']);
            $validatedData = $request->validate([
                'status' => 'required|in:' . implode(',', \App\Enums\OrderStatus::toArray()),
            ]);

            if (!empty($id)) {
                $order = $this->_model->findOrFail($id);
                $order->update($validatedData);
                
                Log::info($this->config['singular_name'] . ' updated successfully', [
                    $this->config['id_field'] => $order->id,
                    'status' => $validatedData['status']
                ]);
            }

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'status' => true,
                    'message' => t($this->config['singular_name'] . ' Updated Successfully!'),
                ]);
            }

            return redirect()
                ->route($this->config['full_route_name'] . '.edit', ['_model' => $id])
                ->with('status', t($this->config['singular_name'] . ' Updated Successfully!'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating ' . $this->config['singular_name'], [
                'error' => $e->getMessage(),
                'request_data' => $request->except(['password', 'token']),
            ]);

            if ($request->ajax()) {
                return jsonCRMResponse(false, 'An error occurred while updating the ' . $this->config['singular_name'] . '. Please try again.', 500);
            }

            return back()->withErrors(['error' => 'An error occurred while updating the ' . $this->config['singular_name'] . '. Please try again.'])->withInput();
        }
    }

    public function details(Request $request, Order $_model)
    {
        try {
            // Load relationships
            $_model->load(['items.product', 'region', 'coupon']);

            $data = [
                '_model' => $_model,
                'config' => $this->config,
            ];

            $view = view($this->config['view_path'] . '.details', $data)->render();

            return response()->json([
                'status' => true,
                'message' => 'Order details loaded successfully',
                'createView' => $view
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error loading order details', [
                'error' => $e->getMessage(),
                'order_id' => $_model->id,
            ]);

            return jsonCRMResponse(false, 'An error occurred while loading order details. Please try again.', 500);
        }
    }

    public function print(Request $request, Order $_model)
    {
        try {

            // Load relationships
            $_model->load(['items.product', 'region', 'coupon']);

            $data = [
                '_model' => $_model,
                'config' => $this->config,
            ];
// return view($this->config['view_path'] . '.pdf', $data);
            // Get the HTML content
            $html = view($this->config['view_path'] . '.pdf', $data)->render();

            // Generate PDF using TCPDF Helper
            $pdf = new TCPDFHelper();
            
            // Set document information
            $pdf->SetCreator(config('app.name'));
            $pdf->SetAuthor(config('app.name'));
            $pdf->SetTitle(t('Order') . ' #' . $_model->id);
            $pdf->SetSubject(t('Order Details'));

            // Remove default header/footer
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);

            // Set RTL support
            $isRtl = isRtl();
            if ($isRtl) {
                $pdf->setRTL(true);
            }

            // Set margins
            $pdf->SetMargins(15, 15, 15);
            $pdf->SetAutoPageBreak(TRUE, 15);

            // Set font for RTL support (DejaVu Sans supports Arabic)
            $pdf->SetFont('dejavusans', '', 10);

            // Add a page
            $pdf->AddPage();

            // Write HTML content
            $pdf->writeHTML($html, true, false, true, false, '');

            // Output PDF
            $filename = 'order_' . $_model->id . '_' . date('Y-m-d') . '.pdf';
            
            return $pdf->Output($filename, 'I');
        } catch (\Exception $e) {
            Log::error('Error generating order PDF', [
                'error' => $e->getMessage(),
                'order_id' => $_model->id,
                'trace' => $e->getTraceAsString(),
            ]);

            return jsonCRMResponse(false, 'An error occurred while generating the PDF. Please try again.', 500);
        }
    }

    public function delete(Request $request, Order $_model)
    {
        try {
            DB::beginTransaction();

            $_model->delete();
            DB::commit();

            Log::info($this->config['singular_name'] . ' deleted successfully', [$this->config['id_field'] => $_model->id]);

            return jsonCRMResponse(true, t($this->config['singular_name'] . ' Deleted Successfully!'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting ' . $this->config['singular_name'], [
                'error' => $e->getMessage(),
            ]);

            return jsonCRMResponse(false, 'An error occurred while deleting the ' . $this->config['singular_name'] . '. Please try again.', 500);
        }
    }

    protected function getCommonData($action = null)
    {
        $data = [
            '_view_path' => $this->config['view_path'],
            '_model' => $this->_model,
            'config' => $this->config,
        ];

        return $data;
    }

    /**
     * Generate a unique slug from the given name
     */
    private function generateSlug($name, $excludeId = null)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while ($this->_model->where('slug', $slug)
            ->when($excludeId, function ($query) use ($excludeId) {
                return $query->where('id', '!=', $excludeId);
            })
            ->exists()
        ) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
