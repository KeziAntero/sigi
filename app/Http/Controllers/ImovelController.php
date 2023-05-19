<?php

namespace App\Http\Controllers;

use App\Imovel;
use App\Owner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\UploadedFile;

class ImovelController extends Controller
{
    /**
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('manage_imovel');

        $imovelQuery = Imovel::query();

        $search = request('q');

        $imovelQuery->leftJoin('owners', 'owners.id', '=', 'imoveis.owner_id')
            ->select('imoveis.*', 'owners.id AS owner_id')
            ->where(function ($query) use ($search) {
                $query->where('imoveis.seq', 'like', '%' . $search . '%')
                    ->orWhere('imoveis.tipo', 'like', '%' . $search . '%')
                    ->orWhere('imoveis.setor', 'like', '%' . $search . '%')
                    ->orWhere('imoveis.quadra', 'like', '%' . $search . '%')
                    ->orWhere('imoveis.lote', 'like', '%' . $search . '%')
                    ->orWhere('owners.name_owner', 'like', '%' . $search . '%')
                    ->orWhere('owners.cpf', 'like', '%' . $search . '%')
                    ->orWhere('owners.id', 'like', '%' . $search . '%')
                    ->orWhere('owner_id', 'like', '%' . $search . '%');
            });

        $imoveis = $imovelQuery->paginate(10);
        $mensagens = Session::get('mensagens', []);
        return view('imoveis.index', compact('imoveis', 'mensagens'));
    }


    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create', new Imovel);
        return view('imoveis.create');
    }
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->authorize('create', new Imovel);

        $newImovel = $request->validate([
            'seq'       => 'required|max:10',
            'tipo'      => 'required|in:territorial,predial',
            'setor'     => 'required|max:02',
            'quadra'    => 'required|max:05',
            'lote'      => 'required|max:05',
            'cpf'       => 'required|max:15',
            'name_owner' => 'required|max:60',
            'latitude'  => 'nullable|required_with:longitude|max:15',
            'longitude' => 'nullable|required_with:latitude|max:15',
        ]);

        $newImovel['creator_id'] = auth()->id();

        $owner = Owner::where('cpf', $newImovel['cpf'])->first();
        if ($owner == null) {
            $owner = Owner::create($newImovel);
        }
        $newImovel['owner_id'] = $owner->id;

        $imovel = Imovel::create($newImovel);

        if ($imovel) {
            if ($request->hasFile('images')) {
                $images = $request->file('images');
                foreach ($images as $image) {
                    if ($image->isValid()) {
                        $extension = $image->extension();
                        $imageName = md5($image->getClientOriginalName() . strtotime("now")) . "." . $extension;
                        $image->storeAs('public/fachadas', $imageName);
                        $imovel->images()->create(['path' => 'fachadas/' . $imageName]);
                    }
                }
            }

            return redirect()->route('imoveis.index')->with('success', 'Imóvel criado com sucesso.');
        } else {
            return redirect()->route('imoveis.create')->with('error', 'Erro ao criar imóvel.');
        }
    }

    /**
     * 
     *
     * @param  integer  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $imovel = Imovel::find($id);
        return view('imoveis.show', compact('imovel'));
    }

    /**
     * 
     *
     * @param  integer  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {

        $imovel = Imovel::findOrFail($id);
        $this->authorize('update', $imovel);
        return view('imoveis.edit', compact('imovel'));
    }
    /**
     * 
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  integer  $id
     * @return \Illuminate\Routing\Redirector
     */

    public function update(Request $request, $id)
    {
        $imovel = Imovel::findOrFail($id);

        $validatedData = $request->validate([
            'seq' => 'required|max:10',
            'tipo' => 'required|in:territorial,predial',
            'setor' => 'required|max:02',
            'quadra' => 'required|max:05',
            'lote' => 'required|max:05',
            'cpf' => 'required|max:15',
            'name_owner' => 'required|max:60',
            'latitude' => 'nullable|required_with:longitude|max:15',
            'longitude' => 'nullable|required_with:latitude|max:15',
        ]);

        $owner = Owner::firstOrCreate(['cpf' => $validatedData['cpf']], $validatedData);

        $imovel = Imovel::findOrFail($id);

        $imovel->update(['owner_id' => $owner->id] + $validatedData);

        if ($imovel) {
            return redirect()->route('imoveis.index', $imovel)->with('success', 'Imóvel atualizado com sucesso.');
        } else {
            return redirect()->route('imoveis.edit', $id)->with('error', 'Erro ao atualizar imóvel.');
        }
    }


    /**
     * 
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $imovel = Imovel::findOrFail($id);
        $this->authorize('delete', $imovel);

        $request->validate(['imovel_id' => 'required']);

        if ($imovel->delete()) {
            return redirect()->route('imoveis.index')->with('success', 'Imóvel excluído com sucesso.');
        } else {
            return redirect()->route('imoveis.index')->with('error', 'Erro ao excluir imóvel.');
        }
    }
}
