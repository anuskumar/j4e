<?php

namespace App\Http\Controllers;

use App\Models\BulkEmailLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminBulkEmailController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'user.type:superadmin']);
    }

    public function index(Request $request)
    {
        $query = BulkEmailLog::with('sender')->orderByDesc('created_at');

        if ($request->filled('type') && in_array($request->type, ['customer', 'reseller'], true)) {
            $query->where('recipient_type', $request->type);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('subject', 'like', '%' . $search . '%')
                    ->orWhere('message', 'like', '%' . $search . '%');
            });
        }

        $logs = $query->paginate(20)->withQueryString();

        $filters = [
            'type' => $request->input('type', 'all'),
            'search' => $request->search,
        ];

        return view('admin.bulk_email.index', compact('logs', 'filters'));
    }

    public function show(BulkEmailLog $bulkEmailLog)
    {
        $bulkEmailLog->load('sender');

        return view('admin.bulk_email.show', compact('bulkEmailLog'));
    }

    public function downloadAttachment(BulkEmailLog $bulkEmailLog, int $index): StreamedResponse
    {
        $attachments = $bulkEmailLog->attachments ?? [];

        if (! isset($attachments[$index]['path'])) {
            abort(404);
        }

        $path = $attachments[$index]['path'];
        $name = $attachments[$index]['name'] ?? basename($path);

        if (! Storage::disk('local')->exists($path)) {
            abort(404);
        }

        return Storage::disk('local')->download($path, $name);
    }
}
