<?php

namespace Juhasev\LaravelSes\Controllers;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Juhasev\LaravelSes\Contracts\EmailLinkContract;
use Juhasev\LaravelSes\Contracts\SentEmailContract;
use Juhasev\LaravelSes\Factories\EventFactory;
use Juhasev\LaravelSes\ModelResolver;

class LinkController extends BaseController
{
    /**
     * Link clicked
     *
     * @param $linkIdentifier
     * @return RedirectResponse
     * @throws Exception
     */

    public function click($linkIdentifier)
    {
        try {
            $emailLink = ModelResolver::get('EmailLink')::whereLinkIdentifier($linkIdentifier)->firstOrFail();

            $emailLink->setClicked(true)->incrementClickCount();

            $this->sendEvent($emailLink);

            return redirect($emailLink->original_url);

        } catch (ModelNotFoundException $e) {

            Log::info("Could not find link ($linkIdentifier). Email link click count not incremented!");
        }
    }

    /**
     * Sent event to listeners
     *
     * @param EmailLinkContract $emailLink
     */

    protected function sendEvent(EmailLinkContract $emailLink)
    {
        event(EventFactory::create('Link', 'EmailLink', $emailLink->id));
    }
}
