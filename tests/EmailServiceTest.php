<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class EmailServiceTest extends TestCase
{
    use DatabaseTransactions;

    static $userEmailTest = "andres@dondepauto.co";
    protected $emailService;

    /**
     * EmailServiceTest constructor.
     */
    public function __construct()
    {
        $this->emailService = new \App\Services\EmailService();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getTestUsers()
    {
        return App\Entities\Platform\User::where('email_us_LI', '=', static::$userEmailTest)->get();
    }

    /**
     * @return \App\Entities\Platform\User
     */
    public function getTestUser()
    {
        return $this->getTestUsers()->first();
    }

    /**
     * @return \App\Entities\Platform\Space\Space
     */
    public function getTestSpace()
    {
        return App\Entities\Platform\Space\Space::orderBy('id_espacio_LI', 'desc')->take(1)->get()->first();
    }

    /**
     * @return \App\Entities\Proposal\Proposal
     */
    public function getTestProposal()
    {
        return App\Entities\Proposal\Proposal::orderBy('id', 'desc')->take(1)->get()->first();
    }

    /**
     * Test for a new publisher user create from the CRM
     */
    public function testSendPublisherInvitation()
    {
        $this->emailService->sendPublisherInvitation($this->getTestUser(), 'codigo');
    }

    /**
     * Test for a new advertiser user create from the CRM
     */
    public function testSendAdvertiserInvitation()
    {
        $this->emailService->sendAdvertiserInvitation($this->getTestUser(), 'codigo');
    }

    /**
     * Test for a publisher user requests changes in terms
     */
    public function testChangeAgreement()
    {
        $this->emailService->changeAgreement($this->getTestUser(), "A new test commment");
    }

    /**
     * Email test notify the change role
     */
    public function testChangeAdvertiserRole()
    {
        $this->emailService->notifyChangeAdvertiserRole($this->getTestUser());
    }

    /**
     * Email test notify the change role
     */
    public function testChangePublisherRole()
    {
        $this->emailService->notifyChangePublisherRole($this->getTestUser());
    }

    /**
     * Test when an user publish a new offer
     */
    public function testNewOffer()
    {
        $this->emailService->notifyNewOffer($this->getTestUser(), $this->getTestSpace());
    }

    public function testEditOffer()
    {
        $this->emailService->notifyEditOffer($this->getTestSpace());
    }

    public function testInactiveOffer()
    {
        $this->emailService->notifyInactiveOffer($this->getTestSpace(), 'terms');
    }

    public function testDocuments()
    {
        $this->emailService->notifyDocuments($this->getTestUser());
    }

    public function testUserDelete()
    {
        $this->emailService->notifyUserDelete($this->getTestUser());
    }

    public function testSuggest()
    {
        $this->emailService->suggest($this->getTestSpace(), $this->getTestUsers());
    }

    public function testProposalSelected()
    {
        $this->emailService->notifyProposalSelected($this->getTestProposal());
    }

    public function testSendProposal()
    {
        $this->emailService->sendProposal($this->getTestProposal(), $this->getTestUser());
    }


}
