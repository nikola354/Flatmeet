<?php

namespace App\Http\Controllers;

use App\Events\MessageSeen;
use App\Events\MessageSent;
use App\Models\BuildingsAddress;
use App\Models\Message;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
	// save user's message and broadcast it along with sender's and recipient's information on the presence channel
	public function store(Request $request){
		$user = Auth::user();
		$recipient = User::where('id', $request->to)->select('id', 'first_name', 'last_name', 'file_name')->first();
		$message = $user->messages()->create([
			'body' => $request->message,
			'to' => $request->to
		]);

		broadcast(new MessageSent($message, $user, $recipient))->toOthers();
		return [
			'user' => $user,
			'recipient' => $recipient
		];
	}

	// get user's messages with another user
	public function fetchMessages(Request $request){
		return DB::table('messages')
				->select('users.file_name', 'messages.from', 'messages.to', 'messages.body', 'messages.seen')
				->join('users', 'users.id', '=', 'messages.from')
				->whereRaw('(messages.from = ? and messages.to = ?) or (messages.from = ? and messages.to = ?)', [$request->from, $request->to, $request->to, $request->from])
				->orderBy('messages.id', 'asc')
				->get();
	}

	// get user's contacts with all necessary information along with them
	public function load($buildingCode, $contactID = null){
		$email = Auth::user()->email;
		$id = Auth::user()->id;
		$contactID = ($contactID !== null) ? Crypt::decrypt($contactID) : null;
		$building = BuildingsAddress::where('building_code', $buildingCode)->first();
		$contacts = DB::select('select contact_id, contact_first_name, contact_last_name, contact_email, contact_file_name, messages.id as message_id, messages.body as message, messages.from as sender, messages.seen, 0 as hasUnseenMessages from (select a.id as contact_id, a.first_name as contact_first_name, a.last_name as contact_last_name, a.email as contact_email, a.file_name as contact_file_name from neighbors join users a on a.email = neighbors.email where neighbors.building_code = ? and neighbors.email != ? and neighbors.status = "accepted") as x left outer join messages on (messages.from = ? and messages.to = contact_id) or (messages.from = contact_id and messages.to = ?) order by message_id desc', [$buildingCode, $email, $id, $id]);
		$cont = array();
		$emails = array();

		for($i=0;$i<count($contacts);$i++){
			$contact = $contacts[$i]; 

			if(!in_array($contact->contact_email, $emails)){
				$cont[$contact->contact_email] = $contact;
				array_push($emails, $contact->contact_email);
			}

			if($contact->sender !== $id && !$contact->seen){
				$cont[$contact->contact_email]->hasUnseenMessages = 1;
			}
		}

		return view('messenger', ['contacts' => $cont, 'building' => $building, 'contact' => $contactID]);
	}

	// fetch user's contacts only
	public function fetchContacts($buldingCode, Request $request){
		$contacts = DB::select('select contact_id, contact_first_name, contact_last_name, contact_email, contact_file_name, messages.id as message_id, messages.body as message, messages.from as sender, messages.seen from (select a.id as contact_id, a.first_name as contact_first_name, a.last_name as contact_last_name, a.email as contact_email, a.file_name as contact_file_name from neighbors join users a on a.email = neighbors.email where neighbors.building_code = ? and neighbors.email != ? and neighbors.status = "accepted") as x left outer join messages on (messages.from = ? and messages.to = contact_id) or (messages.from = contact_id and messages.to = ?) order by message_id desc', [$buldingCode, $request->email, auth()->user()->id, auth()->user()->id]);
		$cont = array();
		$emails = array();

		for($i=0;$i<count($contacts);$i++){
			if(!in_array($contacts[$i]->contact_email, $emails)){
				array_push($cont, $contacts[$i]);
				array_push($emails, $contacts[$i]->contact_email);
			}
		}

		return $cont;
	}

	// get users' ids whose messages have not been seen by the auth user yet
	public function countUnSeenMessages(Request $request){
		$users = DB::table('messages')
			->select(DB::raw('messages.from as id'))
			->where([
				['messages.to', '=', auth()->user()->id],
				['messages.seen', '=', 0]
			])
			->groupBy('messages.from')
			->pluck('id');

		return $users;
	}

	// make the messages seen that are directed to the auth user, and broadcast the event on the presence channel
	public function makeSeen(Request $request){
		$messages = Message::where(['from' => $request->from, 'to' => Auth::user()->id])->update(['seen' => 1]);
		broadcast(new MessageSeen(Auth::user()->id, (int) $request->from))->toOthers();
	}

	// send a message to all users
	public function sendMessageAll(Request $request){
		$ids = DB::table('users')
			->select('users.id')
			->join('neighbors', 'neighbors.email', '=', 'users.email')
			->where([
				['neighbors.building_code', '=', $request->buildingCode],
				['users.id', '<>', $request->from]
			])
			->pluck('id');

		$now = Carbon::now()->toDateTimeString();
		$user = Auth::user();

		foreach($ids as $id){
			$recipient = User::where('id', $id)->select('id', 'first_name', 'last_name', 'file_name')->first();
			$message = $user->messages()->create([
				'body' => $request->message,
				'to' => $id
			]);
			broadcast(new MessageSent($message, $user, $recipient))->toOthers();
		}

		return response()->json(['status' => 200, 'user' => $user]);
	}
}