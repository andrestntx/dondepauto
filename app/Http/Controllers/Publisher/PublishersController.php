<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 21/04/2016
 * Time: 11:46 AM
 */

namespace App\Http\Controllers\Publisher;

use App\Entities\Platform\User;
use App\Facades\PublisherFacade;
use App\Facades\SpaceFacade;
use App\Http\Requests\RUser\Publisher\CompleteRequest;
use App\Http\Requests\RUser\Publisher\UpdateRequest;
use App\Services\PublisherService;
use Illuminate\Http\Request;

class PublishersController extends \App\Http\Controllers\Admin\PublishersController
{
    protected $facade;
    protected $spaceFacade;

    /**
     * [$routePrefix prefix route in more one response view]
     * @var string
     */
    protected $routePrefix = 'medios';
    /**
     * [$viewPath folder views Controller]
     * @var string
     */
    protected $viewPath = 'publisher';

    /**
     * [$modelName used in views]
     * @var string
     */
    protected $modelName = "publisher";

    /**
     * AdvertisersController constructor.
     * @param PublisherFacade $facade
     * @param PublisherService $service
     * @param SpaceFacade $spaceFacade
     */
    function __construct(PublisherFacade $facade, PublisherService $service, SpaceFacade $spaceFacade)
    {
        $this->facade = $facade;
        $this->service = $service;
        $this->spaceFacade = $spaceFacade;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User  $publisher
     * @return \Illuminate\Http\Response
     */
    public function account(User $publisher)
    {
        /*if($user->complete_data) {
            return $this->view('account.form', [
                'publisher' => $user,
                'formData'  => $this->getSimpleFormData('update-account', $user)
            ]);
        }*/

        if(\Gate::allows('account', $publisher)) {
            \Alert::success($publisher->company)->details('Tu registro ha sido confirmado!  Completa tus datos y establece contacto con el área de compras y negociaciones.');

            return $this->view('complete.form', [
                'publisher'     => $publisher,
                'formData'      => $this->getSimpleFormData('complete', $publisher)
            ]);
        }

        return redirect()->route('home');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CompleteRequest  $request
     * @param  User  $publisher
     * @return \Illuminate\Http\Response
     */
    public function complete(CompleteRequest $request, User $publisher)
    {
        $this->authorize('account', $publisher);
        $this->facade->completeData($request->all(), $publisher);

        \Alert::success($publisher->company)->details('Gracias por completar tu datos de contacto! Ahora podrás presentar tus ofertas y activarte como Proveedor.');
        return redirect()->route('medios.agreement', $publisher);
    }

    /**
     * @param User $user
     * @return \Illuminate\Auth\Access\Response
     */
    public function publish(User $user)
    {
        return $this->view('complete-thanks', ['publisher' => $user]);
    }

    /**
     * @param User $user
     * @return \Illuminate\Auth\Access\Response
     */
    public function firstSpace(User $user)
    {
        return $this->view('publish', ['publisher' => $user]);
    }

    /**
     * @param UpdateRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateAccount(UpdateRequest $request, User $user)
    {
        $this->facade->updateModel($request->all(), $user);
        return $this->redirect('inventory', $user);
    }

    /**
     * @param $code
     * @return mixed
     */
    public function confirm($code)
    {
        $publisher = $this->facade->confirm($code);
        return redirect()->route('medios.account', $publisher);
    }

    /**
     * @param User $publisher
     * @return \Illuminate\Auth\Access\Response
     */
    public function agreement(User $publisher)
    {
        $this->authorize('agreement', $publisher);
        return $this->view('agreement.info', ['publisher' => $publisher]);
    }

    /**
     * @param User $publisher
     * @return \Illuminate\Auth\Access\Response
     */
    public function completeAgreement(User $publisher)
    {
        $this->authorize('agreement', $publisher);

        if(auth()->user()->isPublisher()) {
            return $this->view('agreement.form', ['publisher' => $publisher, 'representative' => $publisher->getRepresentativeOrNew()]);
        }

        return view('admin.publishers.agreement')->with([
            'publisher' => $publisher,
            'representative' => $publisher->getRepresentativeOrNew()
        ]);
    }

    /**
     * @param Request $request
     * @param User $publisher
     * @return array
     */
    public function changeAgreement(Request $request, User $publisher)
    {
        $this->authorize('changeAgreement', $publisher);
        $this->facade->changeAgreement($publisher, $request->get('comments'));
        return ['success' => 'true'];
    }


    /**
     * @param Request $request
     * @param User $publisher
     * @return array
     */
    public function postCompleteAgreement(Request $request, User $publisher)
    {
        $this->authorize('agreement', $publisher);
        $this->facade->completeAgreement($publisher, $request->get('publisher'), $request->get('repre'));
        return ['success' => 'true', 'file' => route('medios.agreement.letter', $publisher)];
    }

    /**
     * @param User $publisher
     * @return mixed
     */
    public function getLetter(User $publisher)
    {
        return $this->facade->generateLetter($publisher);
    }

    /**
     * @param User $publisher
     * @return $this
     */
    public function faqs(User $publisher)
    {
        return view('publisher.faqs')->with('publisher', $publisher);
    }

    /**
     * @param Request $request
     * @param User $user
     */
    public function uploadDocuments(Request $request, User $user)
    {
        \Log::info($request->all());
        $this->facade->saveDocuments($user, $request->file('commerce'), $request->file('rut'), $request->file('bank'),$request->file('letter'));
    }


    public function uploadLogo(Request $request, User $publisher)
    {
        $this->facade->saveLogo($publisher, $request->file('logo'));
        return ['success' => 'true'];
    }


}