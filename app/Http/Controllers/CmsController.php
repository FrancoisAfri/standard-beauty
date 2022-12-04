<?php

namespace App\Http\Controllers;

use App\Cmsnews;
use App\ceoNews;
use App\HRPerson;
use App\User;
use App\cms_rating;
use App\DivisionLevel;
use App\CompanyIdentity;
use App\YoutubePost;
use Illuminate\Http\Request;
use App\Http\Controllers\AuditReportsController;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Http\RedirectResponse;
class CmsController extends Controller
{
	use BreadCrumpTrait, StoreImageTrait, uploadFilesTrait;
	
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function addnews()
    {
		$Cmsnews = Cmsnews::all();
        $divisionLevels = DivisionLevel::where('active', 1)->orderBy('id', 'desc')->get();

        $data['page_title'] = "Communications";
        $data['page_description'] = "Contents";
        $data['breadcrumb'] = [
            ['title' => 'Communications', 'path' => '/News', 'icon' => 'fa fa-handshake-o', 'active' => 0, 'is_module' => 1],
            ['title' => 'Content Management', 'active' => 1, 'is_module' => 0]
        ];
        $data['active_mod'] = 'Content Management';
        $data['active_rib'] = 'Manage Blog';
        $data['Cmsnews'] = $Cmsnews;
        $data['division_levels'] = $divisionLevels;
        
        AuditReportsController::store('Content Management', 'Content Added', "Content Content Management Accessed", 0);
        return view('cms.viewmews')->with($data);
    } 
	// view and edit youtube link
	public function youtubePost()
    {
		$post = YoutubePost::whereNotNull('link_post')->first();

		if (!empty($post->link_post)) $link = "/cms/update_youtube/$post->id";
		else $link = "/cms/update_youtube";
		
        $data['page_title'] = "Communications";
        $data['page_description'] = "Contents";
        $data['breadcrumb'] = [
            ['title' => 'Communications', 'path' => '/News', 'icon' => 'fa fa-handshake-o', 'active' => 0, 'is_module' => 1],
            ['title' => 'Content Management', 'active' => 1, 'is_module' => 0]
        ];
        $data['active_mod'] = 'Content Management';
        $data['active_rib'] = 'Youtube Post';
        $data['post'] = $post;
        $data['link'] = $link;
        
        AuditReportsController::store('Content Management', 'link page', "link Accessed", 0);
        return view('cms.add_youtube_link')->with($data);
    }
	// update youtube link post
	public function updatYoutube(Request $request, YoutubePost $link)
    {

        $this->validate($request, [

        ]);
        $NewsData = $request->all();
        unset($NewsData['_token']);

		if (!empty($link->link_post))
		{
			$link->link_post = $NewsData['link_post'];
			$link->update();
		}
		else 
		{
			$linkYou = new YoutubePost();
			$linkYou->link_post = $NewsData['link_post'];
			$linkYou->save();
		}
		
        AuditReportsController::store('Content Management', 'Link Updated', "Link Saved", 0);
        return redirect('/cms/youtube')->with('success_save', "Link Update successfully.");

    }
	
    public function addcmsnews(Request $request)
    {
        $this->validate($request, [
//            'name' => 'required',
//            'description' => 'required',

        ]);
        $NewsData = $request->all();
        unset($NewsData['_token']);

        $Expdate = !empty($NewsData['exp_date']) ? str_replace('/', '-', $NewsData['exp_date']): '';
        $Expdate = !empty($Expdate) ? strtotime($Expdate): 0;

        $crmNews = new Cmsnews();
        $crmNews->name = $NewsData['name'];
        $crmNews->link = $NewsData['link'];
        $crmNews->expirydate = $Expdate;
        $crmNews->status = 1;
        $crmNews->save();
		// save picture
		
        if ($request->hasFile('image')) {
            $fileExt = $request->file('image')->extension();
            if (in_array($fileExt, ['jpg', 'jpeg', 'png']) && $request->file('image')->isValid()) {
                $fileName = time() . "image." . $fileExt;
                $request->file('image')->storeAs('CMS/images', $fileName);
                //Update file name in the database
                $crmNews->image = $fileName;
                $crmNews->update();
            }
        }

        AuditReportsController::store('Content Management', 'Content Added', "Content Content Management Accessed", 0);
        return response()->json();
    }

    public function viewnews(Cmsnews $news)
    {

        // return $news;
        $hrDetails = HRPerson::where('status', 1)->get();
        $Cmsnews = Cmsnews::where('id', $news->id)->first();
        $divisionLevels = DivisionLevel::where('active', 1)->orderBy('id', 'desc')->get();

        $data['page_title'] = "Communications";
        $data['page_description'] = "Content";
        $data['breadcrumb'] = [
            ['title' => 'Communications', 'path' => '/News', 'icon' => 'fa fa-handshake-o', 'active' => 0, 'is_module' => 1],
            ['title' => 'Content Management', 'active' => 1, 'is_module' => 0]
        ];
        $avatar = $Cmsnews->image;
        $data['avatar'] = (!empty($avatar)) ? Storage::disk('local')->url("CMS/images/$avatar") : '';
        $data['active_mod'] = 'Content Management';
        $data['active_rib'] = 'Manage Blog';
        $data['Cmsnews'] = $Cmsnews;
        $data['division_levels'] = $divisionLevels;
        $data['hrDetails'] = $hrDetails;
       
        AuditReportsController::store('Content Management', 'Content Added', "Content Content Management Accessed", 0);
        return view('cms.edit_crm_news')->with($data);
    }

    public function newsAct(Cmsnews $news)
    {
        if ($news->status == 1)
            $stastus = 0;
        else
            $stastus = 1;

        $news->status = $stastus;
        $news->update();

        AuditReportsController::store('Content Management', 'Content Status Changed', "Content Status  Changed", 0);
        return back();
    }

    public function deleteNews(Cmsnews $news)
    {

        $news->delete();

        AuditReportsController::store('Content Management', 'Content News  Deleted', "Content News Deleted", 0);
        return back();
    }

    public function updatContent(Request $request, Cmsnews $news)
    {

        $this->validate($request, [

        ]);
        $NewsData = $request->all();
        unset($NewsData['_token']);


        $Expdate = $NewsData['exp_date'] = str_replace('/', '-', $NewsData['exp_date']);
        $Expdate = $NewsData['exp_date'] = strtotime($NewsData['exp_date']);

        $news->name = $NewsData['name'];
        $news->link = $NewsData['link'];
        $news->expirydate = $Expdate;
        $news->update();
		// get path 
		$CompanyIdentity = CompanyIdentity::first();
		$path = !empty($CompanyIdentity->document_root) ? $CompanyIdentity->document_root : '';
		$path = $path."/CMS/images";
		$Extensions = array('png', 'jpg');

        $Files = isset($_FILES['image']) ? $_FILES['image'] : array();
		if (isset($Files['name']) && $Files['name'] != '') {
			$fileName = time(). '_' . $Files['name'];
			$Explode = array();
			$Explode = explode('.', $fileName);
			$ext = end($Explode);
			$ext = strtolower($ext);
			if (in_array($ext, $Extensions)) {
				if (!is_dir("$path")) mkdir("$path", 0775);
				move_uploaded_file($Files['tmp_name'], "$path".'/' . $fileName) or die('Could not move file!');
				$news->image = $fileName;
                $news->update();
			}
		}
		
        /*if ($request->hasFile('image')) {
            $fileExt = $request->file('image')->extension();
            if (in_array($fileExt, ['jpg', 'jpeg', 'png']) && $request->file('image')->isValid()) {
                $fileName = time() . "image." . $fileExt;
                $request->file('image')->storeAs('CMS/images', $fileName);
                //Update file name in the database
                $news->image = $fileName;
                $news->update();
            }
        }*/

        AuditReportsController::store('Content Management', 'Content Updated', "Content Content Management Accessed", 0);
        return redirect('/cms/viewnews/' . $news->id)->with('success_application', "Content Update successfully.");

    }

    public function view(Cmsnews $id)
    {
        $newsID = $id->id;
        $Cmsnews = Cmsnews::where('id', $newsID)->first();

        $data['page_title'] = "Communications";
        $data['page_description'] = "Content";
        $data['breadcrumb'] = [
            ['title' => 'Communications Ceo News', 'path' => '/News', 'icon' => 'fa fa-handshake-o', 'active' => 0, 'is_module' => 1],
            ['title' => 'Content Management', 'active' => 1, 'is_module' => 0]
        ];
        $data['active_mod'] = 'Content Management';
        $data['active_rib'] = 'CEO News';
        $data['Cmsnews'] = $Cmsnews;

        AuditReportsController::store('Content Management', 'Company Ceo News Accessed', "Company Ceo News Content  Accessed", 0);
        return view('dashboard.view_news_dashboard')->with($data);
    }

    public function viewceo(ceoNews $viewceo)
    {
        $newsID = $viewceo->id;
        $Cmsnews = ceoNews::where('id', $newsID)->first();

        $data['page_title'] = "Communications";
        $data['page_description'] = "Content";
        $data['breadcrumb'] = [
            ['title' => 'CMS Ceo News', 'path' => '/News', 'icon' => 'fa fa-handshake-o', 'active' => 0, 'is_module' => 1],
            ['title' => 'Content Management', 'active' => 1, 'is_module' => 0]
        ];
        $data['active_mod'] = 'Content Management';
        $data['active_rib'] = 'CEO News';
        $data['Cmsnews'] = $Cmsnews;

        AuditReportsController::store('Content Management', 'Company Ceo News Accessed', "Company Ceo News Content  Accessed", 0);
        return view('cms.view_ceonews_dashboard')->with($data);
    }

    public function search()
    {
        $data['page_title'] = "CMS ";
        $data['page_description'] = "Search News";
        $data['breadcrumb'] = [
            ['title' => 'CMS Search News', 'path' => '/News', 'icon' => 'fa fa-spinner', 'active' => 0, 'is_module' => 1],
            ['title' => 'Content Management', 'active' => 1, 'is_module' => 0]
        ];
        $data['active_mod'] = 'Content Management';
        $data['active_rib'] = 'Search';


        AuditReportsController::store('Content Management', 'Company Search Accessed', "Company Search Accessed", 0);

        return view('cms.search_news')->with($data);

    }

    public function cmsceonews(Request $request)
    {

        $policyData = $request->all();
        unset($policyData['_token']);


        $actionFrom = $actionTo = 0;
        $name = $policyData['name'];
        $actionDate = $policyData['day'];
        if (!empty($actionDate)) {
            $startExplode = explode('-', $actionDate);
            $actionFrom = strtotime($startExplode[0]);
            $actionTo = strtotime($startExplode[1]);
        }
        $ceo_news = ceoNews::where(function ($query) use ($actionFrom, $actionTo) {
            if ($actionFrom > 0 && $actionTo > 0) {
                $query->whereBetween('ceo_news.date', [$actionFrom, $actionTo]);
            }
        })
            ->where(function ($query) use ($name) {
                if (!empty($name)) {
                    $query->where('ceo_news.name', 'ILIKE', "%$name%");
                }
            })
            ->orderBy('ceo_news.name')
            ->get();

        //  return $ceo_news;

        $data['ceo_news'] = $ceo_news;

        $data['page_title'] = "CMS ";
        $data['page_description'] = "CEO Message ";
        $data['breadcrumb'] = [
            ['title' => 'CMS Search News', 'path' => '/News', 'icon' => 'fa fa-spinner', 'active' => 0, 'is_module' => 1],
            ['title' => 'Content Management', 'active' => 1, 'is_module' => 0]
        ];
        $data['active_mod'] = 'Content Management';
        $data['active_rib'] = 'Search';

        AuditReportsController::store('Content Management', 'Company Ceo Messages Accessed', "Company Accessed", 0);
        return view('cms.ceonews_results')->with($data);


    }

    public function CamponyNews(Request $request)
    {
        $policyData = $request->all();
        unset($policyData['_token']);

        $actionFrom = $actionTo = 0;
        $name = $policyData['name'];
        $actionDate = $policyData['day'];
        if (!empty($actionDate)) {
            $startExplode = explode('-', $actionDate);
            $actionFrom = strtotime($startExplode[0]);
            $actionTo = strtotime($startExplode[1]);
        }

        $Cmsnews = DB::table('cms_news')
            ->select('cms_news.*')
            ->where(function ($query) use ($actionFrom, $actionTo) {
                if ($actionFrom > 0 && $actionTo > 0) {
                    $query->whereBetween('cms_news.expirydate', [$actionFrom, $actionTo]);
                }
            })
            ->where(function ($query) use ($name) {
                if (!empty($name)) {
                    $query->where('cms_news.name', 'ILIKE', "%$name%");
                }
            })
            ->limit(100)
            ->orderBy('cms_news.id')
            ->get();

        $data['Cmsnews'] = $Cmsnews;
        $data['page_title'] = "CMS";
        $data['page_description'] = "Campony News";
        $data['breadcrumb'] = [
            ['title' => 'CMS Search News', 'path' => '/News', 'icon' => 'fa fa-spinner', 'active' => 0, 'is_module' => 1],
            ['title' => 'Content Management', 'active' => 1, 'is_module' => 0]
        ];
        $data['active_mod'] = 'Content Management';
        $data['active_rib'] = 'Search';

        AuditReportsController::store('Content Management', 'Content search page Accessed', "Company search page Accessed", 0);
        return view('cms.camponynews_results')->with($data);

    }

    public function cmsratings($id, $cmsID)
    {

        $cms_news_rating = cms_rating::where('cms_id', $cmsID)->first();
        // return  $loggedInEmplID = Auth::user()->person->id;

        if (empty($cms_news_rating)) {
            $cms_news_rating = new cms_rating();
            $cms_news_rating->rating_1 = 0;
            $cms_news_rating->rating_2 = 0;
            $cms_news_rating->rating_3 = 0;
            $cms_news_rating->rating_4 = 0;
            $cms_news_rating->rating_5 = 0;
            $cms_news_rating->cms_id = $cmsID;
            $cms_news_rating->user_id = $loggedInEmplID = Auth::user()->person->id;
            $cms_news_rating->save();
        }

        if ($id == 1) {
            $cms_news_rating->rating_1 = 1;
            $cms_news_rating->rating_2 = 0;
            $cms_news_rating->rating_3 = 0;
            $cms_news_rating->rating_4 = 0;
            $cms_news_rating->rating_5 = 0;
        } elseif ($id == 2) {
            $cms_news_rating->rating_1 = 1;
            $cms_news_rating->rating_2 = 1;
            $cms_news_rating->rating_3 = 0;
            $cms_news_rating->rating_4 = 0;
            $cms_news_rating->rating_5 = 0;
        } elseif ($id == 3) {
            $cms_news_rating->rating_1 = 1;
            $cms_news_rating->rating_2 = 1;
            $cms_news_rating->rating_3 = 1;
            $cms_news_rating->rating_4 = 0;
            $cms_news_rating->rating_5 = 0;
        } elseif ($id == 4) {
            echo $cms_news_rating->rating_1;
            // die;
            $cms_news_rating->rating_1 = 1;
            $cms_news_rating->rating_2 = 1;
            $cms_news_rating->rating_3 = 1;
            $cms_news_rating->rating_4 = 1;
            $cms_news_rating->rating_5 = 0;
        } elseif ($id == 5) {
            $cms_news_rating->rating_1 = 1;
            $cms_news_rating->rating_2 = 1;
            $cms_news_rating->rating_3 = 1;
            $cms_news_rating->rating_4 = 1;
            $cms_news_rating->rating_5 = 1;
        }

        $cms_news_rating->update();

        AuditReportsController::store('Content Management', 'Content Ratings', "Content Ratings", 0);

        return back();
    }

    public function cms_report()
    {
        $Cmsnews = Cmsnews::all();
        //return $Cmsnews;

        $data['Cmsnews'] = $Cmsnews;
        $data['page_title'] = "CMS";
        $data['page_description'] = "Content";
        $data['breadcrumb'] = [
            ['title' => 'Reports', 'path' => '/News', 'icon' => 'fa fa-spinner', 'active' => 0, 'is_module' => 1],
            ['title' => 'Content Management', 'active' => 1, 'is_module' => 0]
        ];
        $data['active_mod'] = 'Content Management';
        $data['active_rib'] = 'Reports';

        AuditReportsController::store('Content Management', 'Content search page Accessed', "Company search page Accessed", 0);
        return view('cms.reports.search_results')->with($data);
    }

    public function cms_rankings()
    {

        $Cmsnews = Cmsnews::all();
        // return $Cmsnews;

        $data['Cmsnews'] = $Cmsnews;
        $data['page_title'] = "CMS";
        $data['page_description'] = "Campony News";
        $data['breadcrumb'] = [
            ['title' => 'Reports', 'path' => '/News', 'icon' => 'fa fa-spinner', 'active' => 0, 'is_module' => 1],
            ['title' => 'Content Management', 'active' => 1, 'is_module' => 0]
        ];
        $data['active_mod'] = 'Content Management';
        $data['active_rib'] = 'Reports';

        AuditReportsController::store('Content Management', 'Content search page Accessed', "Company search page Accessed", 0);
        return view('cms.reports.search_results')->with($data);
    }

    public function cms_Star_rankings(Request $request, Cmsnews $news)
    {
        $ID = $news->id;

        $ratings = cms_rating::select('cms_news_ratings.*', 'hr_people.id', 'hr_people.first_name', 'hr_people.surname')
            ->join('hr_people', 'cms_news_ratings.user_id', '=', 'hr_people.id')
            ->where('cms_id', $ID)
            ->get();
        // return $ratings;

        $data['news'] = $news;
        $data['ratings'] = $ratings;
        $data['page_title'] = "CMS";
        $data['page_description'] = "Campony News";
        $data['breadcrumb'] = [
            ['title' => 'Reports', 'path' => '/News', 'icon' => 'fa fa-spinner', 'active' => 0, 'is_module' => 1],
            ['title' => 'Content Management', 'active' => 1, 'is_module' => 0]
        ];
        $data['active_mod'] = 'Content Management';
        $data['active_rib'] = 'Reports';

        AuditReportsController::store('Content Management', 'Content search page Accessed', "Company search page Accessed", 0);
        return view('cms.partials.new_ratings')->with($data);
    }
	// general informations
	public function generalInformations()
    {
        $data['page_title'] = "General Info";
        $data['page_description'] = "General Informations";
        $data['breadcrumb'] = [
            ['title' => 'General ', 'path' => '/general_information/view', 'icon' => 'fa fa-handshake-o', 'active' => 0, 'is_module' => 1],
            ['title' => 'General Info', 'active' => 1, 'is_module' => 0]
        ];

        AuditReportsController::store('Content Management', 'Content Added', "Content Content Management Accessed", 0);
        return view('cms.view_general_info')->with($data);
    }
}
