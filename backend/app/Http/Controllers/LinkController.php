<?php 

namespace App\Http\Controllers;   

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\LinkResource;
use Illuminate\Http\JsonResponse;
use App\Models\Link;
use Validator;

use App\Services\LinkService;

class LinkController extends BaseController

{
    protected $linkService;

    public function __construct(LinkService $linkService)
    {
        $this->linkService = $linkService;
    }

    public function index(): JsonResponse{

        $user = Auth::user();
        $links = Link::where('user_id', $user->id)->orderBy('created_at','desc')->paginate(4);

        return $this->sendResponse([
            'data' => LinkResource::collection($links),
            'pagination' => $this->linkService->constructPaginationObject($links),
        ],
        'Links retrieved successfully.');
    }


    public function store(Request $request): JsonResponse{

        $input = $request->all();   

        $validator = $this->linkService->validateLink($input);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user = Auth::user();

        $link = Link::create([
            'title' => $input['title'],
            'url' => $input['url'],
            'short_url' => $this->linkService->hasShortUrl($input['short_url']),
            'user_id' => $user->id,
        ]); 

        return $this->sendResponse(new LinkResource($link), 'Link created successfully.');

    } 

    public function show($id): JsonResponse {
        $user = Auth::user();
        $link = Link::find($id);

        if (is_null($link)) {
            return $this->sendError('Link not found.');
        }
        $this->checkAuthorization($link);

        return $this->sendResponse(new LinkResource($link), 'Link retrieved successfully.');

    }

    public function update(Request $request, Link $link): JsonResponse {

        $input = $request->all();

        $this->checkAuthorization($link);

        $validator = $this->linkService->validateLink($input); 

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());   
        }   

        $link->title = $input['title'];
        $link->url = $input['url'];
        $link->short_url = $this->linkService->hasShortUrl($input['short_url']);

        $link->save(); 

        return $this->sendResponse(new LinkResource($link), 'Link updated successfully.');

    }

    public function destroy(Link $link): JsonResponse{

        $this->checkAuthorization($link);
        $link->delete();  

        return $this->sendResponse([], 'Link deleted successfully.');
    }

    public function map(string $urlHash): JsonResponse {

        $link = Link::where('short_url', $urlHash)->first();

        if (is_null($link)){
            return $this->sendError('Unknow link');
        }

        $link->url_visits = $this->linkService->visitLink($link->url_visits);
        $link->save();

        return $this->sendResponse($link->url,'Link mapped successfully.');
    }

    protected function checkAuthorization($link){
        $user = Auth::user();
        if ($this->linkService->isUserAuthorized($link,$user)) {
            return $this->sendError('Unauthorized to delete this link.');
        }
    }

}