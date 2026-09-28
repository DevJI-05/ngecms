<?php

namespace App\Http\Controllers\Gas;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInquiryRequest;
use App\Models\Inquiry;
use App\Models\Service;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('gas/Contact', [
            'settings' => SiteSetting::current(),
            'services' => Service::query()->orderBy('sort_order')->pluck('name'),
        ]);
    }

    public function store(StoreInquiryRequest $request): RedirectResponse
    {
        $inquiry = Inquiry::query()->create($request->validated());

        Inertia::flash('inquirySubmitted', [
            'nama' => $inquiry->nama,
            'ref' => 'NGE-'.$inquiry->created_at->format('Y').'-'.str_pad((string) $inquiry->id, 4, '0', STR_PAD_LEFT),
        ]);

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Inquiry berhasil dikirim. Tim kami akan segera menghubungi Anda.',
        ]);

        return back();
    }
}
