<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Blog; 
use Validator;
use Redirect;
use Response;
use DB;
class BlogController extends Controller
{
    function index()
    {
        $data = DB::table('blogs')
        ->orderBy('id', 'DESC')
        ->limit(2)
        ->get();
     return view('blog')->with(['data'=>$data]);
    }

    function load_data(Request $request)
    {
       
     if($request->ajax())
     {
      if($request->id > 0)
      {
       $data = DB::table('blogs')
          ->where('id', '<', $request->id)
          ->orderBy('id', 'DESC')
          ->limit(2)
          ->get();
      }
      else
      {
       $data = DB::table('blogs')
          ->orderBy('id', 'DESC')
          ->limit(2)
          ->get();
      }
      $output = '';
      $last_id = '';
      if(!$data->isEmpty())
      {
       foreach($data as $row)
       {
        $output .= '
        <div class="row">
         <div class="col-md-12">
          <h3 class="text-info"><b>'.$row->post_name.'</b></h3>
          <p>'.$row->post_description.'</p>
          <br />
          <div class="col-md-6">
           <p><b>Publish Date - '.$row->created_at.'</b></p>
          </div>
          
          <br />
          <hr />
         </div>         
        </div>
        ';
        $last_id = $row->id;
       }
       $output .= '
       <div id="load_more">
        <button type="button" name="load_more_button" class="btn btn-success form-control" data-id="'.$last_id.'" id="load_more_button">Load More</button>
       </div>
       ';
      }
      else
      {
       $output .= '
       <div id="load_more">
        <button type="button" name="load_more_button" class="btn btn-info form-control">No Data Found</button>
       </div>
       ';
      }
      echo $output;
     }
    }
}

?>
