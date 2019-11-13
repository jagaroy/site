<?php

namespace Bulkly\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Bulkly\BufferPosting;
use DB;
use Session;

class HistoryController extends Controller
{
    public function index(){
        if(!Auth::guard('web')->check()){
            return redirect('/login');
        }

        // Session::put('group_name', "");
        // Session::put('date', "");
        // Session::put('group_type', "");

        $group_name = Session::get('group_name');
        $date = Session::get('date');
        $group_type = Session::get('group_type');	

        if (strlen($group_name)>0) {

        	$histories = DB::table('buffer_postings')
					->join('social_post_groups', 'social_post_groups.id', '=', 'buffer_postings.group_id')
					->join('social_accounts', 'social_accounts.id', '=', 'buffer_postings.account_id')
					->select(['buffer_postings.id as buffer_postings_id', 'buffer_postings.post_text as buffer_postings_post_text', 'social_post_groups.name as group_name', 'social_post_groups.type as group_type', 'social_accounts.name as account_name', 'buffer_postings.updated_at as buffer_postings_updated_at', ])
					->where('social_post_groups.name', $group_name)
					->paginate(10);
        }else{
        	$histories = DB::table('buffer_postings')
					->join('social_post_groups', 'social_post_groups.id', '=', 'buffer_postings.group_id')
					->join('social_accounts', 'social_accounts.id', '=', 'buffer_postings.account_id')
					->select(['buffer_postings.id as buffer_postings_id', 'buffer_postings.post_text as buffer_postings_post_text', 'social_post_groups.name as group_name', 'social_post_groups.type as group_type', 'social_accounts.name as account_name', 'buffer_postings.updated_at as buffer_postings_updated_at', ])
					->paginate(10);
        }
		
    	return view('history.index')->with('histories', $histories);
    }

    public function search(Request $request){
        if(!Auth::guard('web')->check()){
            return redirect('/login');
        }

        Session::put('group_name', $request->group_name);
        Session::put('date', $request->date);
        Session::put('group_type', $request->group_type);

		return response()->json(['res'=>'success']);
		
    }
    
}

