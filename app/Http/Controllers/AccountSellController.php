<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountSell\StoreAccountSellRequest;
use App\Http\Requests\AccountSell\UpdateAccountSellRequest;
use App\Models\AccountSell;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

class AccountSellController extends Controller
{

    public function index()
    {
        $accountsSales = AccountSell::paginate();
        return view(
            view: 'admin.accounts-sales.pages.index',
            data: compact('accountsSales'),
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(
            view: 'admin.accounts-sales.pages.create'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAccountSellRequest $request)
    {
        $data = $request->except(['_token', 'image_1', 'image_2', 'image_3', 'image_4', 'image_5', 'image_6']);
        $data['id'] = Uuid::uuid4()->toString();

        $data['image_1'] = $request->file('image_1')?->store('uploads');
        $data['image_2'] = $request->file('image_2')?->store('uploads/' . $data['id']);
        $data['image_3'] = $request->file('image_3')?->store('uploads/' . $data['id']);
        $data['image_4'] = $request->file('image_4')?->store('uploads/' . $data['id']);
        $data['image_5'] = $request->file('image_5')?->store('uploads/' . $data['id']);
        $data['image_6'] = $request->file('image_6')?->store('uploads/' . $data['id']);

        if (!$accountSell = AccountSell::create($data))
        {
            return redirect()->route('admin.accounts-sales.index')->withErrors(['error' => 'Problema na criação da conta']);
        }

        return redirect()->route('admin.accounts-sales.index')->with(['success' => 'Conta criada com sucesso']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!$accountSell = AccountSell::find($id)) {
            return redirect()->back()->withErrors(['not found']);
        }
        return view(
            view: 'admin.accounts-sales.pages.edit',
            data: compact('accountSell')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAccountSellRequest $request, string $id)
    {
        if (!$accountSell = AccountSell::find($id)) {
            return redirect()->back()->withErrors(['not found']);
        }
        $data = $request->except('_token', '_method', 'image_1', 'image_2', 'image_3', 'image_4', 'image_5', 'image_6');

        $data['image_2'] = $request->file('image_2')?->store('uploads/' . $accountSell->id);
        $data['image_3'] = $request->file('image_3')?->store('uploads/' . $accountSell->id);
        $data['image_4'] = $request->file('image_4')?->store('uploads/' . $accountSell->id);
        $data['image_5'] = $request->file('image_5')?->store('uploads/' . $accountSell->id);
        $data['image_6'] = $request->file('image_6')?->store('uploads/' . $accountSell->id);

        $accountSell->update($data);
        return redirect()->route('admin.accounts-sales.index')->with(['success' => 'Updated with success']);
    }

    /**
     * Remove a specifc image
     */
    public function deleteImage(string $id, int $image)
    {
        if (!$accountSell = AccountSell::find($id)) {
            return redirect()->back()->withErrors(['not found']);
        }
        
        $pathFile = $accountSell->{"image_$image"};
        $accountSell->{"image_$image"} = null;
        $accountSell->save();
        Storage::delete($pathFile);

        return response(null, 204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!$accountSell = AccountSell::find($id)) {
            return redirect()->back()->withErrors(['not found']);
        }
        Storage::deleteDirectory('uploads/' . $accountSell->id);
        $accountSell->delete();
        return redirect()->route('admin.accounts-sales.index')->with(['success' => 'Deleted']);
    }
}
