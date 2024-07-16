<?php
namespace App\Http\Controllers\Api;

use  App\Http\Requests\Api\SendInqueryRequest;
use App\Services\Api\HelpdeskService;

class HelpdeskController extends ApiController
{
    public function __construct(
        public HelpdeskService $service
    ) {}

    public function contact_us(SendInqueryRequest $request)
    {
        $helpDeskSent = $this->service->sendInquiry($request);
        return $this->setApiResponse(
            $helpDeskSent,
            $helpDeskSent ? 200 : 400,
            [],
            $helpDeskSent ? __('helpdesk.api.request_send_successfully') : __('helpdesk.api.request_send_failed')
        );
    }
}
