<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\CompanyDocument;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function setup(): View
    {
        $profile = auth()->user()->companyProfile;
        return view('company.setup', compact('profile'));
    }

    public function storeSetup(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'company_name'        => ['required', 'string', 'max:255'],
            'registration_number' => ['required', 'string', 'max:100',
                'unique:company_profiles,registration_number,'
                . auth()->user()->companyProfile->id],
            'contact_person'      => ['required', 'string', 'max:255'],
            'address'             => ['required', 'string'],
            'phone'               => ['required', 'string', 'max:20'],
            'website'             => ['nullable', 'url', 'max:255'],
            'logo'                => ['nullable', 'image', 'mimes:jpg,png', 'max:2048'],
            'brela_document'      => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'nida_document'       => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'tra_document'        => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        $profile = auth()->user()->companyProfile;

        if ($request->hasFile('logo')) {
            $data['logo_path'] = $request->file('logo')->store('company/logos', 'public');
        }

        $profile->update(array_except($data, ['logo', 'brela_document', 'nida_document', 'tra_document']));

        // Store documents
        foreach (['brela_document' => 'brela', 'nida_document' => 'nida', 'tra_document' => 'tra'] as $field => $type) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $path = $file->store("company/{$profile->id}/docs", 'private');
                CompanyDocument::create([
                    'company_id'        => $profile->id,
                    'document_type'     => $type,
                    'original_filename' => $file->getClientOriginalName(),
                    'file_path'         => $path,
                    'mime_type'         => $file->getMimeType(),
                    'file_size'         => $file->getSize(),
                ]);
            }
        }

        return redirect()->route('company.dashboard')
            ->with('status', 'Company details submitted. Our team will review your documents shortly.');
    }

    public function edit(): View
    {
        $profile = auth()->user()->companyProfile?->load('documents');
        return view('company.profile.edit', compact('profile'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'contact_person' => ['required', 'string', 'max:255'],
            'address'        => ['required', 'string'],
            'phone'          => ['required', 'string', 'max:20'],
            'website'        => ['nullable', 'url', 'max:255'],
        ]);

        auth()->user()->companyProfile->update($data);

        return back()->with('status', 'Profile updated successfully.');
    }
}
