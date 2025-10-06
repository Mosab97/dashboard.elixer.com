<?php

namespace App\Http\Controllers\CP\Attachments;

use App\Enums\EventWorkshopAttachmentType;
use App\Enums\InnovationResourceAttachmentType;
use App\Enums\ProgramAttachmentType;
use App\Enums\ProjectAttachmentType;
use App\Exports\ApartmentsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\CP\AttachmentRequest;
use App\Models\Apartment;
use App\Models\Attachment;
use App\Models\EventWorkshop;
use App\Models\InnovationResource;
use App\Models\Program;
use App\Models\Project;
use App\Services\Filters\AttachmentFilterService;
use App\Traits\HasCommonData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use OwenIt\Auditing\Models\Audit;
use Yajra\DataTables\Facades\DataTables;

class AttachmentController extends Controller
{

    protected $filterService;
    private $_model;
    protected $config;

    public function __construct(Attachment $_model, AttachmentFilterService $filterService)
    {
        $this->_model = $_model;
        $this->filterService = $filterService;
        $this->config = config('modules.attachments');
        Log::info('............... ' . $this->config['controller'] . ' initialized with ' . $this->config['singular_name'] . ' model ...........');
    }

    protected function getCommonData($action = null)
    {
        $data = [
            '_view_path' =>  $this->config['view_path'],
            '_model' => $this->_model
        ];
        // dd($data);
        return $data;
    }


    public function index(Request $request)
    {
        Log::info('Starting index method', ['method' => $request->method()]);

        try {
            $data = $this->getCommonData('index');
            Log::info('Common data retrieved', ['data' => array_keys($data)]);

            if ($request->isMethod('GET')) {
                Log::info('Processing GET request');
                return view($data['view'] . 'index', $data);
            }

            if ($request->isMethod('POST')) {
                Log::info('Processing POST request');

                $attachable_type = $request['params']['attachable_type'];
                $attachable_id = $request['params']['attachable_id'];
                // Validate model class
                if (!class_exists($attachable_type)) {
                    Log::error("Model class validation failed", ['model' => $attachable_type]);
                    throw new \Exception("Model class {$attachable_type} does not exist");
                }
                Log::info("Model class validated successfully");

                // Validate model ID
                if (!isset($attachable_id)) {
                    Log::error("Model ID validation failed");
                    throw new \Exception("Model ID does not exist");
                }
                Log::info("Model ID validated successfully");

                // Build query
                Log::info("Building query with relationships");
                $items = $this->_model->query()
                    ->with(['attachment_type']);

                // Apply model filter
                if ($attachable_type) {
                    Log::info("Applying model type filter", ['attachable_type' => $attachable_type]);
                    $items->where('attachable_type', $attachable_type);
                }

                // Apply model ID filter
                if ($attachable_id) {
                    Log::info("Applying model ID filter", ['attachable_id' => $attachable_id]);
                    $items->where('attachable_id', $attachable_id);
                }

                // Apply sorting
                $items->latest($this->_model::ui['table'] . '.updated_at');
                Log::info("Query built successfully");

                // Build DataTables response
                Log::info("Preparing DataTables response");
                $response = DataTables::eloquent($items)
                    ->addColumn('source', function ($attachment) {
                        Log::debug("Processing source column", ['attachment_id' => $attachment->id]);
                        return $attachment->source;
                    })
                    ->addColumn('title', function ($attachment) {
                        Log::debug("Processing title column", ['attachment_id' => $attachment->id]);
                        return '<a target="_blank" href="' . $attachment->file_path . '">' . $attachment->file_name . '</a>';
                    })
                    ->editColumn('created_at', function ($attachment) {
                        Log::debug("Processing created_at column", ['attachment_id' => $attachment->id]);
                        return [
                            'display' => e(
                                $attachment->created_at->format('m/d/Y')
                            ),
                            'timestamp' => $attachment->created_at->timestamp
                        ];
                    })
                    ->addColumn('action', function ($item) use ($attachable_type, $attachable_id) {
                        return view($this->config['view_path'] . '.actions', [
                            '_model' => $item,
                            'config' => $this->config,
                            'attachable_type' => $attachable_type,
                            'attachable_id' => $attachable_id,
                        ])->render();
                    })
                    ->rawColumns(['source', 'title', 'action']);

                Log::info("DataTables response prepared successfully");
                return $response->make();
            }
        } catch (\Exception $e) {
            Log::error('Error in index method', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }


    public function create(Request $request)
    {
        $data = $this->getCommonData('create');
        $data['attachable_type'] = $request->attachable_type;
        $data['attachable_id'] = $request->attachable_id;
        $createView = view(
            $this->config['view_path'] . '.addedit_modal',
            $data
        )->render();
        return response()->json(['createView' => $createView]);
    }
    public function edit(Request $request, Attachment $_model)
    {
        $data = $this->getCommonData('edit');
        // is not required becuase i just need to update the type and the file
        $data['attachable_type'] = $request->attachable_type;
        $data['attachable_id'] = $request->attachable_id;
        $data['_model'] = $_model;

        $createView = view(
            $this->config['view_path'] . '.addedit_modal',
            $data
        )->render();
        return response()->json(['createView' => $createView]);
    }




    private function handleError($request, $message, $errors = [])
    {
        Log::warning('Handling error response', [
            'message' => $message,
            'errors' => $errors
        ]);

        if ($request->ajax()) {
            return response()->json([
                'status' => false,
                'message' => $message,
                'errors' => ['name' => [$message]] // Change to specific field error
            ], 422);
        }

        return redirect()
            ->back()
            ->withInput()
            ->withErrors(['name' => $message]) // Attach error to specific field
            ->with('error', null); // Don't set general error message
    }


    // Updated addedit method
    public function addedit(AttachmentRequest $request)
    {
        $id = $request->get($this->config['id_field']);

        try {
            DB::beginTransaction();
            Log::info('DB transaction started');

            $data = $request->validated(); // Use validated data instead of all()
            $data['attachable_type'] = $request->attachable_type;
            $data['attachable_id'] = $request->attachable_id;

            // If updating, store the old file path to delete later
            $oldPath = null;
            $oldName = null;
            if ($id) {
                $item = $this->_model->findOrFail($id);
                $oldPath = $item->file_path;
                $oldName = $item->file_name;
                Log::info('Found existing attachment', [
                    'id' => $id,
                    'old_path' => $oldPath,
                    'old_name' => $oldName
                ]);
            }

            // Handle new file upload
            if ($request->hasFile('attachment_file') && $request->file('attachment_file')->isValid()) {
                Log::info('Processing new file upload');

                // Capture file information BEFORE moving the file
                $file = $request->file('attachment_file');
                $originalFilename = $file->getClientOriginalName();
                $mimeType = $file->getMimeType();
                $fileSize = $file->getSize();

                $fileExtension = strtolower($file->getClientOriginalExtension()); // normalize to lowercase
                // Store the file
                $path = Storage::disk('public')->putFile('attachments', $file);
                $fileName = basename($path);

                // Set all file related data
                $data['file_path'] = $path;
                $data['file_hash'] = $fileName;
                $data['file_name'] = $originalFilename;
                $data['file_type'] = $mimeType;
                $data['file_size'] = $fileSize;
                $data['file_extension'] = $fileExtension;

            }

            // Create or update the attachment
            if ($id) {
                Log::info('Updating existing attachment', ['id' => $id]);
                $item->update($data);

                // Delete old file if a new one was uploaded
                if ($oldPath && $request->hasFile('attachment_file')) {
                    Log::info('Attempting to delete old file', [
                        'old_path' => $oldPath,
                        'old_name' => $oldName
                    ]);
                    Storage::disk('public')->delete($oldPath);
                }
            } else {
                Log::info('Creating new attachment');
                $item = $this->_model->create($data);
                Log::info('New attachment created', ['id' => $item->id]);
            }

            DB::commit();
            Log::info('DB transaction committed');

            $message = $id
                ? t($this->config['singular_name'] . ' has been updated successfully!')
                : t($this->config['singular_name'] . ' has been added successfully!');

            Log::info('Attachment operation completed successfully', [
                'operation' => $id ? 'update' : 'create',
                'id' => $item->id
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'status' => true,
                    'message' => $message,
                    'id' => $item->id
                ]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in attachment add/edit process', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->except(['password'])
            ]);

            return $this->handleError($request, $e->getMessage());
        }
    }
    public function delete(Request $request, Attachment $_model)
    {

        try {
            DB::beginTransaction();
            Log::info('DB transaction started');

            // Store the file path before deleting the model
            $oldPath = $_model->file_path;
            $oldName = $_model->file_name;

            Log::info('Preparing to delete attachment', [
                'path' => $oldPath,
                'name' => $oldName
            ]);

            // Delete the model
            $_model->delete();
            Log::info('Attachment record deleted from database');

            // Delete the physical file
            if ($oldPath) {
                Log::info('Attempting to delete physical file', [
                    'path' => $oldPath,
                    'name' => $oldName
                ]);
                $deleteResult = Storage::disk('public')->delete($oldPath);
                Log::info('Delete file result', ['message' => $deleteResult]);
            }

            DB::commit();
            Log::info('DB transaction committed');

            Log::info($this->config['singular_name'] . ' deleted successfully', [
                $this->config['id_field'] => $this->_model->id
            ]);

            return jsonCRMResponse(true, t($this->config['singular_name'] . ' Deleted Successfully!'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting ' . $this->config['singular_name'], [
                $this->config['id_field'] => $this->_model->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return jsonCRMResponse(false, 'An error occurred while deleting the ' . $this->config['singular_name'] . '. Please try again.', 500);
        }
    }



}
