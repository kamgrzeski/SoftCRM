<?php

namespace App\Http\Controllers\CRM;

use App\Client;
use App\Companies;
use App\Invoices;
use App\Http\Controllers\Controller;
use App\Language;
use Carbon\Carbon;
use ConsoleTVs\Invoices\Classes\Invoice;
use Validator;
use Illuminate\Support\Facades\Input;
use View;
use Request;
Use Illuminate\Support\Facades\Redirect;
use Config;

class InvoicesController extends Controller
{
    /**
     * @return array
     */
    private function getDataAndPagination()
    {
        $dataWithInvoices = [
            'invoices' => Invoices::all(),
            'invoicesPaginate' => Invoices::paginate(Config::get('crm_settings.pagination_size'))
        ];

        return $dataWithInvoices;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View::make('crm.invoices.index')->with($this->getDataAndPagination());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $dataOfCompanies = Companies::pluck('name', 'id');
        $dataOfClient = Client::pluck('full_name', 'id');
        return View::make('crm.invoices.create')->with(
            [
                'dataOfCompanies' => $dataOfCompanies,
                'dataOfClient' => $dataOfClient
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $allInputs = Input::all();

        $validator = Validator::make($allInputs, Invoices::getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::to('invoices/create')->with('message_danger', $validator->errors());
        } else {
            if (Invoices::insertRow($allInputs)) {
                return Redirect::to('invoices')->with('message_success', Language::getMessage('messages.SuccessInvoicesStore'));
            } else {
                return Redirect::back()->with('message_success', Language::getMessage('messages.ErrorInvoicesStore'));
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $dataOfInvoices = Invoices::find($id);

        return View::make('crm.invoices.show')
            ->with([
                'invoices' => $dataOfInvoices,
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $invoicesDetails = Invoices::find($id);

        return View::make('crm.invoices.edit')
            ->with('invoices', $invoicesDetails);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $allInputs = Input::all();

        $validator = Validator::make($allInputs, Invoices::getRules('STORE'));

        if ($validator->fails()) {
            return Redirect::back()->with('message_danger', $validator);
        } else {
            if (Invoices::updateRow($id, $allInputs)) {
                return Redirect::to('invoices')->with('message_success', Language::getMessage('messages.SuccessInvoicesStore'));
            } else {
                return Redirect::back()->with('message_danger', Language::getMessage('messages.ErrorInvoicesStore'));
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $invoicesDetails = Invoices::find($id);
        $invoicesDetails->delete();

        return Redirect::to('invoices')->with('message_success', Language::getMessage('messages.SuccessInvoicesDelete'));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function enable($id)
    {
        $invoicesDetails = Invoices::find($id);

        if (Invoices::setActive($invoicesDetails->id, TRUE)) {
            return Redirect::back()->with('message_success', Language::getMessage('messages.SuccessInvoicesActive'));
        } else {
            return Redirect::back()->with('message_danger', Language::getMessage('messages.InvoicesIsActived'));
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function disable($id)
    {
        $invoicesDetails = Invoices::find($id);

        if (Invoices::setActive($invoicesDetails->id, FALSE)) {
            return Redirect::back()->with('message_success', Language::getMessage('messages.InvoicesIsNowDeactivated'));
        } else {
            return Redirect::back()->with('message_danger', Language::getMessage('messages.InvoicesIsDeactivated'));
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function search()
    {
        $getValueInput = Request::input('search');
        $findInvoicesByValue = count(Invoices::trySearchInvoicesByValue('full_name', $getValueInput, 10));
        $dataOfInvoices = $this->getDataAndPagination();

        if (!$findInvoicesByValue > 0) {
            return redirect('invoices')->with('message_danger', Language::getMessage('messages.ThereIsNoInvoices'));
        } else {
            $dataOfInvoices += ['invoices_search' => $findInvoicesByValue];
            Redirect::to('invoices/search')->with('message_success', 'Find ' . $findInvoicesByValue . ' invoices!');
        }

        return View::make('crm.invoices.index')->with($dataOfInvoices);
    }

    public function getInvoice($id)
    {
        $invoices = Invoices::find($id);
        $time = Carbon::parse(Carbon::now());

        $invoice = Invoice::make()
            ->logo(Config::get('crm_settings.invoice_logo_link'))
            ->currency(Config::get('crm_settings.currency'))
            ->number($invoices->id)
            ->tax(Config::get('crm_settings.invoice_tax'))
            ->notes($invoices->notes)
            ->customer([
                'name'      => $invoices->client->full_name,
                'id'        => $invoices->client->id,
                'phone'     => $invoices->client->phone,
                'location'  => $invoices->client->location,
                'zip'       => $invoices->client->zip,
                'city'      => $invoices->client->city,
                'country'   => $invoices->client->country
            ])
            ->addItem($invoices->subject, $invoices->cost, $invoices->amount, 1);

        //this is for multi companies but can be import from config only for one company
        $invoice->business_details["name"] = $invoices->companies->name;
        $invoice->business_details["phone"] = $invoices->companies->phone;
        $invoice->business_details["location"] = $invoices->companies->billing_address;
        $invoice->business_details["zip"] = $invoices->companies->postal_code;
        $invoice->business_details["city"] = $invoices->companies->city;
        $invoice->business_details["country"] = $invoices->companies->country;

        return $invoice->show($time->timestamp . '_softCRM_' . 'Billennium');
    }
}
