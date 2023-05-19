<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TodoListController extends Controller
{
    public function index(){
        $lists = TodoList::all();
        return response($lists);
    }

    public function show($id){
        $list = TodoList::findOrFail($id);
        return response($list);
    }

    public function store(Request $request){

        $request->validate(['name' => ['required']]);

        $list = TodoList::create($request->all());
        return $list;
    }


    public function update(Request $request, TodoList $list){
        $request->validate(["name"=> "required"]);
        $list->update($request->all());
        return response($list);
    }


    public function destroy(TodoList $list){
        $deleteList = $list->delete();
        return response($deleteList, Response::HTTP_NO_CONTENT);
    }
}
