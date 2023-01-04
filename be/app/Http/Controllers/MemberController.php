<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\MemberSkill;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = Member::all();
        return response()->json($users, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSkills($username)
    {
        $member = Member::where("username", $username)->first();
        $skills = MemberSkill::where("member_id", $member->id)->get();
        return response()->json($skills, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $exist = Member::where("username", request()->username)->first();
        if ($exist) {
            return response()->json("UsernameExist", 400);
        }
        $member = new Member;
        $member->username = request()->username;
        $member->save();
        return response()->json("success", 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function postSkill(Request $request, $username)
    {
        $member = Member::where("username", $username)->first();
        $skill = new MemberSkill;
        $skill->skill = request()->skill;
        $skill->level = request()->level;
        $skill->member_id = $member->id;
        $skill->save();
        return response()->json("success", 200);
    }

    public function updateSkill(Request $request, $username, $skillId)
    {
        $member = Member::where("username", $username)->first();
        $skill = MemberSkill::find($skillId);
        $skill->skill = request()->skill;
        $skill->level = request()->level;
        $skill->save();
        return response()->json("success", 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteSkill($id, $skillId)
    {
        $skill = MemberSkill::find($skillId);
        $skill->delete();
        return response()->json("success", 200);
    }
}
