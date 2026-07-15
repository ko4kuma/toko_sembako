<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $member = Member::all();
        return view('member.index', compact('member'));
    }

    public function create()
    {
        return view('member.create');
    }

    public function store(Request $request)
    {
        Member::create($request->all());

        return redirect()->route('member.index');
    }

    public function edit($id)
    {
        $member = Member::findOrFail($id);

        return view('member.edit', compact('member'));
    }

    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);

        $member->update($request->all());

        return redirect()->route('member.index');
    }
    public function search(Request $request)
    {
        $keyword = $request->query('q');

        $member = Member::where('no_hp', 'like', '%'.$keyword.'%')
            ->limit(10)
            ->get(['id', 'nama_member', 'no_hp']);

        return response()->json($member);
    }
    public function destroy($id)
    {
        $member = Member::findOrFail($id);

        $member->delete();

        return redirect()->route('member.index');
    }
}