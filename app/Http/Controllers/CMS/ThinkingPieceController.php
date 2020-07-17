<?php
namespace App\Http\Controllers\CMS;
use App\ThinkingPiece;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Auth;


class ThinkingPieceController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->module_name = 'THINKING_PIECE';
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()

    {
        is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'views');
        $title = __('constant.THINKING_PIECE');

        $thinkingPiece = ThinkingPiece::orderBy('thinking_piece_date', 'desc')->get();

        return view("admin.thinking-piece.index", compact("thinkingPiece", "title"));


    }




    public function create()

    {
        is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'creates');
        $title = __('constant.CREATE');



        return view("admin.thinking-piece.create", compact("title", "ThinkingPieces", "Teachers"));

    }


    public function edit($id)

    {
        is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'edits');
        $title = __('constant.EDIT');

        $thinking_piece = ThinkingPiece::findorfail($id);
        return view("admin.thinking-piece.edit", compact("title", "thinking_piece"));

    }


    public function show($id)

    {

        //

    }

    public function update(Request $request, $id)

    {
        is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'edits');
        
		$validatorFields = [
                'thinking_piece_title' => 'required',
				'thinking_piece_image' => 'image|nullable|mimes:jpg,JPG,jpeg,JPEG,png,PNG,gif,GIF|max:2048',
                'description' => 'required',
                'thinking_piece_date' => 'required|date',
                'thinking_piece_address' => 'required'
            ];
      

        $this->validate($request, $validatorFields);
		$thinkingPiece = ThinkingPiece::findorfail($id);
        $thinkingPiece->thinking_piece_title = $request->thinking_piece_title;
        $thinkingPiece->description = $request->description;
        $thinkingPiece->thinking_piece_date = $request->thinking_piece_date;
		 if (!is_dir('uploads')) {
            mkdir('uploads');
        }

        if (!is_dir('uploads/thinking_piece')) {
            mkdir('uploads/thinking_piece');
        }
        $destinationPath = 'uploads/thinking_piece'; // upload path
        $thinking_piece_url = '';
        $thinking_piecePath = null;
        if ($request->hasFile('thinking_piece_image')) {

            // Get filename with the extension
            $filenameWithExt = $request->file('thinking_piece_image')->getClientOriginalName();
            // Get just filename
            $filename = preg_replace('/\s+/', '_', pathinfo($filenameWithExt, PATHINFO_FILENAME));
            // Get just ext
            $extension = $request->file('thinking_piece_image')->getClientOriginalExtension();
            // Filename to store
            $thinking_piece_url = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $request->file('thinking_piece_image')->move($destinationPath, $thinking_piece_url);
            $thinking_piecePath = $destinationPath . "/" . $thinking_piece_url;
			$thinkingPiece->thinking_piece_image = $thinking_piecePath;
        }
        $thinkingPiece->thinking_piece_address = $request->thinking_piece_address;
        $thinkingPiece->updated_at = Carbon::now()->toDateTimeString();
        $thinkingPiece->save();


        return redirect(route('thinking_piece.index'))->with('success', __('constant.UPDATED', ['module' => __('constant.THINKING_PIECE')]));


    }


    public function destroy($id)

    {
        is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'deletes');
        $thinking_piece = ThinkingPiece::findorfail($id);
        $thinking_piece->delete();

        return back()->with('success', __('constant.REMOVED', ['module' => __('constant.THINKING_PIECE')]));

    }

   
    


    public function store(Request $request)
    {

         is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'creates');
         //dd($request->description);
		 $validatorFields = [
                'thinking_piece_title' => 'required',
				'thinking_piece_image' => 'required|image|mimes:jpg,JPG,jpeg,JPEG,png,PNG,gif,GIF|max:2048',
                'description' => 'required',
                'thinking_piece_date' => 'required|date',
                'thinking_piece_address' => 'required'
            ];

        $this->validate($request, $validatorFields);
		$thinkingPiece = new ThinkingPiece;
		$thinkingPiece->thinking_piece_title = $request->thinking_piece_title;
        $thinkingPiece->description = $request->description;
        $thinkingPiece->thinking_piece_date = $request->thinking_piece_date;
		
		 if (!is_dir('uploads')) {
            mkdir('uploads');
        }

        if (!is_dir('uploads/thinking_piece')) {
            mkdir('uploads/thinking_piece');
        }
        $destinationPath = 'uploads/thinking_piece'; // upload path
        $thinking_piece_url = '';
        $thinking_piecePath = null;
        if ($request->hasFile('thinking_piece_image')) {

            // Get filename with the extension
            $filenameWithExt = $request->file('thinking_piece_image')->getClientOriginalName();
            // Get just filename
            $filename = preg_replace('/\s+/', '_', pathinfo($filenameWithExt, PATHINFO_FILENAME));
            // Get just ext
            $extension = $request->file('thinking_piece_image')->getClientOriginalExtension();
            // Filename to store
            $thinking_piece_url = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $request->file('thinking_piece_image')->move($destinationPath, $thinking_piece_url);
            $thinking_piecePath = $destinationPath . "/" . $thinking_piece_url;
			$thinkingPiece->thinking_piece_image = $thinking_piecePath;
        }
        $thinkingPiece->thinking_piece_address = $request->thinking_piece_address;
        $thinkingPiece->updated_at = Carbon::now()->toDateTimeString();
        $thinkingPiece->save();
		
        return redirect(route('thinking_piece.index'))->with('success', __('constant.CREATED', ['module' => __('constant.THINKING_PIECE')]));

        }

    }

