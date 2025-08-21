@extends('layouts.app')
@section('title', 'Profile')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="nav-align-top">
        <ul class="nav nav-pills flex-column flex-md-row mb-6">
            <li class="nav-item">
            <a class="nav-link" href="pages-account-settings-account.html"
                ><i class="icon-base ti tabler-users icon-sm me-1_5"></i> Account</a
            >
            </li>
            <li class="nav-item">
            <a class="nav-link" href="pages-account-settings-security.html"
                ><i class="icon-base ti tabler-lock icon-sm me-1_5"></i> Security</a
            >
            </li>
            <li class="nav-item">
            <a class="nav-link active" href="javascript:void(0);"
                ><i class="icon-base ti tabler-bookmark icon-sm me-1_5"></i> Billing & Plans</a
            >
            </li>
            <li class="nav-item">
            <a class="nav-link" href="pages-account-settings-notifications.html"
                ><i class="icon-base ti tabler-bell icon-sm me-1_5"></i> Notifications</a
            >
            </li>
            <li class="nav-item">
            <a class="nav-link" href="pages-account-settings-connections.html"
                ><i class="icon-base ti tabler-link icon-sm me-1_5"></i> Connections</a
            >
            </li>
        </ul>
        </div>
        <div class="card mb-6">
        <!-- Current Plan -->
        <h5 class="card-header">Current Plan</h5>
        <div class="card-body">
            <div class="row row-gap-6">
            <div class="col-md-6 mb-1">
                <div class="mb-6">
                <h6 class="mb-1">Your Current Plan is Basic</h6>
                <p>A simple start for everyone</p>
                </div>
                <div class="mb-6">
                <h6 class="mb-1">Active until Dec 09, 2021</h6>
                <p>We will send you a notification upon Subscription expiration</p>
                </div>
                <div>
                <h6 class="mb-1">
                    <span class="me-1">$199 Per Month</span>
                    <span class="badge bg-label-primary rounded-pill">Popular</span>
                </h6>
                <p class="mb-1">Standard plan for small to medium businesses</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="alert alert-warning mb-6" role="alert">
                <h5 class="alert-heading mb-1 d-flex align-items-center">
                    <span class="alert-icon rounded"
                    ><i class="icon-base ti tabler-alert-triangle icon-md"></i
                    ></span>
                    <span>We need your attention!</span>
                </h5>
                <span class="ms-11 ps-1">Your plan requires update</span>
                </div>
                <div class="plan-statistics">
                <div class="d-flex justify-content-between">
                    <h6 class="mb-1">Days</h6>
                    <h6 class="mb-1">12 of 30 Days</h6>
                </div>
                <div class="progress rounded mb-1">
                    <div
                    class="progress-bar w-25 rounded"
                    role="progressbar"
                    aria-valuenow="25"
                    aria-valuemin="0"
                    aria-valuemax="100"></div>
                </div>
                <small>18 days remaining until your plan requires update</small>
                </div>
            </div>
            <div class="col-12 d-flex gap-2 flex-wrap">
                <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#pricingModal">
                Upgrade Plan
                </button>
                <button class="btn btn-label-danger cancel-subscription">Cancel Subscription</button>
            </div>
            </div>
        </div>
        <!-- /Current Plan -->
        </div>
        <div class="card mb-6">
        <h5 class="card-header">Payment Methods</h5>
        <div class="card-body">
            <div class="row gx-6">
            <div class="col-md-6">
                <form id="creditCardForm" class="row g-6" onsubmit="return false">
                <div class="col-12 mb-2">
                    <div class="form-check form-check-inline my-2 ms-2 me-6">
                    <input
                        name="collapsible-payment"
                        class="form-check-input"
                        type="radio"
                        value=""
                        id="collapsible-payment-cc"
                        checked="" />
                    <label class="form-check-label" for="collapsible-payment-cc"
                        >Credit/Debit/ATM Card</label
                    >
                    </div>
                    <div class="form-check form-check-inline ms-2 my-2">
                    <input
                        name="collapsible-payment"
                        class="form-check-input"
                        type="radio"
                        value=""
                        id="collapsible-payment-cash" />
                    <label class="form-check-label" for="collapsible-payment-cash">Paypal account</label>
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label w-100" for="paymentCard">Card Number</label>
                    <div class="input-group input-group-merge">
                    <input
                        id="paymentCard"
                        name="paymentCard"
                        class="form-control credit-card-mask"
                        type="text"
                        placeholder="1356 3215 6548 7898"
                        aria-describedby="paymentCard2" />
                    <span class="input-group-text cursor-pointer" id="paymentCard2"
                        ><span class="card-type"></span
                    ></span>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label" for="paymentName">Name</label>
                    <input type="text" id="paymentName" class="form-control" placeholder="John Doe" />
                </div>
                <div class="col-6 col-md-3">
                    <label class="form-label" for="paymentExpiryDate">Exp. Date</label>
                    <input
                    type="text"
                    id="paymentExpiryDate"
                    class="form-control expiry-date-mask"
                    placeholder="MM/YY" />
                </div>
                <div class="col-6 col-md-3">
                    <label class="form-label" for="paymentCvv">CVV Code</label>
                    <div class="input-group input-group-merge">
                    <input
                        type="text"
                        id="paymentCvv"
                        class="form-control cvv-code-mask"
                        maxlength="3"
                        placeholder="654" />
                    <span class="input-group-text cursor-pointer" id="paymentCvv2"
                        ><i
                        class="icon-base ti tabler-help-circle text-body-secondary"
                        data-bs-toggle="tooltip"
                        data-bs-placement="top"
                        title="Card Verification Value"></i
                    ></span>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-check form-switch ms-2 my-2">
                    <input type="checkbox" class="form-check-input" id="future-billing" />
                    <label for="future-billing" class="switch-label">Save card for future billing?</label>
                    </div>
                </div>
                <div class="col-12 mt-6">
                    <button type="submit" class="btn btn-primary me-3">Save Changes</button>
                    <button type="reset" class="btn btn-label-secondary">Cancel</button>
                </div>
                </form>
            </div>
            <div class="col-md-6 mt-12 mt-md-0">
                <h6 class="mb-6">My Cards</h6>
                <div class="added-cards">
                <div class="cardMaster p-6 bg-lighter rounded mb-6">
                    <div class="d-flex justify-content-between flex-sm-row flex-column">
                    <div class="card-information me-2">
                        <img
                        class="mb-2"
                        src="../../assets/img/icons/payments/mastercard.png"
                        alt="Master Card" />
                        <div class="d-flex align-items-center mb-2 flex-wrap gap-2">
                        <h6 class="mb-0 me-2">Tom McBride</h6>
                        <span class="badge bg-label-primary">Primary</span>
                        </div>
                        <span class="card-number"
                        >&#8727;&#8727;&#8727;&#8727; &#8727;&#8727;&#8727;&#8727; 9856</span
                        >
                    </div>
                    <div class="d-flex flex-column text-start text-lg-end">
                        <div class="d-flex order-sm-0 order-1 mt-sm-0 mt-4">
                        <button
                            class="btn btn-sm btn-label-primary me-4"
                            data-bs-toggle="modal"
                            data-bs-target="#editCCModal">
                            Edit
                        </button>
                        <button class="btn btn-sm btn-label-danger">Delete</button>
                        </div>
                        <small class="mt-sm-4 mt-2 order-sm-1 order-0">Card expires at 12/26</small>
                    </div>
                    </div>
                </div>
                <div class="cardMaster p-6 bg-lighter rounded">
                    <div class="d-flex justify-content-between flex-sm-row flex-column">
                    <div class="card-information me-2">
                        <img class="mb-2" src="../../assets/img/icons/payments/visa.png" alt="Visa Card" />
                        <h6 class="mb-2">Mildred Wagner</h6>
                        <span class="card-number"
                        >&#8727;&#8727;&#8727;&#8727; &#8727;&#8727;&#8727;&#8727; 5896</span
                        >
                    </div>
                    <div class="d-flex flex-column text-start text-lg-end">
                        <div class="d-flex order-sm-0 order-1 mt-sm-0 mt-4">
                        <button
                            class="btn btn-sm btn-label-primary me-4"
                            data-bs-toggle="modal"
                            data-bs-target="#editCCModal">
                            Edit
                        </button>
                        <button class="btn btn-sm btn-label-danger">Delete</button>
                        </div>
                        <small class="mt-sm-4 mt-2 order-sm-1 order-0">Card expires at 10/27</small>
                    </div>
                    </div>
                </div>
                </div>
                <!-- Modal -->
                <!-- Add New Credit Card Modal -->
                <div class="modal fade" id="editCCModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-simple modal-add-new-cc">
                    <div class="modal-content">
                    <div class="modal-body">
                        <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
                        <div class="text-center mb-6">
                        <h2>Edit Card</h2>
                        <p class="text-body-secondary">Edit your saved card details</p>
                        </div>
                        <form id="editCCForm" class="row g-3" onsubmit="return false">
                        <div class="col-12 form-control-validation">
                            <label class="form-label w-100" for="modalEditCard">Card Number</label>
                            <div class="input-group input-group-merge">
                            <input
                                id="modalEditCard"
                                name="modalEditCard"
                                class="form-control credit-card-mask-edit"
                                type="text"
                                placeholder="4356 3215 6548 7898"
                                value="4356 3215 6548 7898"
                                aria-describedby="modalEditCard2" />
                            <span class="input-group-text cursor-pointer" id="modalEditCard2"
                                ><span class="card-type-edit"></span
                            ></span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="modalEditName">Name</label>
                            <input
                            type="text"
                            id="modalEditName"
                            class="form-control"
                            placeholder="John Doe"
                            value="John Doe" />
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label" for="modalEditExpiryDate">Exp. Date</label>
                            <input
                            type="text"
                            id="modalEditExpiryDate"
                            class="form-control expiry-date-mask-edit"
                            placeholder="MM/YY"
                            value="08/28" />
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label" for="modalEditCvv">CVV Code</label>
                            <div class="input-group input-group-merge">
                            <input
                                type="text"
                                id="modalEditCvv"
                                class="form-control cvv-code-mask-edit"
                                maxlength="3"
                                placeholder="654"
                                value="XXX" />
                            <span class="input-group-text cursor-pointer" id="modalEditCvv2"
                                ><i
                                class="icon-base ti tabler-help-circle text-body-secondary"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="Card Verification Value"></i
                            ></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" id="editPrimaryCard" />
                            <label for="editPrimaryCard">Set as primary card</label>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary me-sm-4 me-1">Update</button>
                            <button
                            type="reset"
                            class="btn btn-label-danger"
                            data-bs-dismiss="modal"
                            aria-label="Close">
                            Remove
                            </button>
                        </div>
                        </form>
                    </div>
                    </div>
                </div>
                </div>
                <!--/ Add New Credit Card Modal -->

                <!--/ Modal -->
            </div>
            </div>
        </div>
        </div>
        <div class="card mb-6">
        <!-- Billing Address -->
        <h5 class="card-header">Billing Address</h5>
        <div class="card-body">
            <form id="formAccountSettings" onsubmit="return false">
            <div class="row g-6">
                <div class="col-sm-6 form-control-validation">
                <label for="companyName" class="form-label">Company Name</label>
                <input
                    type="text"
                    id="companyName"
                    name="companyName"
                    class="form-control"
                    placeholder="Pixinvent" />
                </div>
                <div class="col-sm-6 form-control-validation">
                <label for="billingEmail" class="form-label">Billing Email</label>
                <input
                    class="form-control"
                    type="text"
                    id="billingEmail"
                    name="billingEmail"
                    placeholder="john.doe@example.com" />
                </div>
                <div class="col-sm-6">
                <label for="taxId" class="form-label">Tax ID</label>
                <input
                    type="text"
                    id="taxId"
                    name="taxId"
                    class="form-control"
                    placeholder="Enter Tax ID" />
                </div>
                <div class="col-sm-6">
                <label for="vatNumber" class="form-label">VAT Number</label>
                <input
                    class="form-control"
                    type="text"
                    id="vatNumber"
                    name="vatNumber"
                    placeholder="Enter VAT Number" />
                </div>
                <div class="col-sm-6">
                <label for="mobileNumber" class="form-label">Mobile</label>
                <div class="input-group input-group-merge">
                    <span class="input-group-text">US (+1)</span>
                    <input
                    class="form-control mobile-number"
                    type="text"
                    id="mobileNumber"
                    name="mobileNumber"
                    placeholder="202 555 0111" />
                </div>
                </div>
                <div class="col-sm-6">
                <label for="country" class="form-label">Country</label>
                <select id="country" class="form-select select2" name="country">
                    <option selected>USA</option>
                    <option>Canada</option>
                    <option>UK</option>
                    <option>Germany</option>
                    <option>France</option>
                </select>
                </div>
                <div class="col-12">
                <label for="billingAddress" class="form-label">Billing Address</label>
                <input
                    type="text"
                    class="form-control"
                    id="billingAddress"
                    name="billingAddress"
                    placeholder="Billing Address" />
                </div>
                <div class="col-sm-6">
                <label for="state" class="form-label">State</label>
                <input class="form-control" type="text" id="state" name="state" placeholder="California" />
                </div>
                <div class="col-sm-6">
                <label for="zipCode" class="form-label">Zip Code</label>
                <input
                    type="text"
                    class="form-control zip-code"
                    id="zipCode"
                    name="zipCode"
                    placeholder="231465"
                    maxlength="6" />
                </div>
            </div>
            <div class="mt-6">
                <button type="submit" class="btn btn-primary me-3">Save changes</button>
                <button type="reset" class="btn btn-label-secondary">Discard</button>
            </div>
            </form>
        </div>
        <!-- /Billing Address -->
        </div>
        <div class="card">
        <!-- Billing History -->
        <h5 class="card-header text-md-start text-center">Billing History</h5>
        <div class="card-datatable border-top">
            <table class="invoice-list-table table border-top">
            <thead>
                <tr>
                <th></th>
                <th></th>
                <th>#</th>
                <th><i class="icon-base ti tabler-trending-up"></i></th>
                <th>Client</th>
                <th>Total</th>
                <th class="text-truncate">Issued Date</th>
                <th>Balance</th>
                <th>Invoice Status</th>
                <th class="cell-fit">Action</th>
                </tr>
            </thead>
            </table>
        </div>
        <!--/ Billing History -->
        </div>
    </div>
</div>

<!-- Modal -->
<!-- Pricing Modal -->
<div class="modal fade" id="pricingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-pricing">
        <div class="modal-content">
        <div class="modal-body">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <!-- Pricing Plans -->
            <div class="rounded-top">
            <h4 class="text-center mb-2">Pricing Plans</h4>
            <p class="text-center mb-0">
                All plans include 40+ advanced tools and features to boost your product. Choose the best plan
                to fit your needs.
            </p>
            <div class="d-flex align-items-center justify-content-center flex-wrap gap-2 pt-12 pb-4">
                <label class="switch switch-sm ms-sm-12 ps-sm-12 me-0">
                <span class="switch-label fs-6 text-body">Monthly</span>
                <input type="checkbox" class="switch-input price-duration-toggler" checked />
                <span class="switch-toggle-slider">
                    <span class="switch-on"></span>
                    <span class="switch-off"></span>
                </span>
                <span class="switch-label fs-6 text-body">Annually</span>
                </label>
                <div class="mt-n5 ms-n10 ml-2 mb-12 d-none d-sm-flex align-items-center gap-1">
                <i
                    class="icon-base ti tabler-corner-left-down icon-lg text-body-secondary scaleX-n1-rtl"></i>
                <span class="badge badge-sm bg-label-primary rounded-1 mb-2">Save up to 10%</span>
                </div>
            </div>

            <div class="row gy-6">
                <!-- Basic -->
                <div class="col-xl mb-md-0">
                <div class="card border rounded shadow-none">
                    <div class="card-body pt-12 p-5">
                    <div class="mt-3 mb-5 text-center">
                        <img
                        src="../../assets/img/illustrations/page-pricing-basic.png"
                        alt="Basic Image"
                        height="120" />
                    </div>
                    <h4 class="card-title text-center text-capitalize mb-1">Basic</h4>
                    <p class="text-center mb-5">A simple start for everyone</p>
                    <div class="text-center h-px-50">
                        <div class="d-flex justify-content-center">
                        <sup class="h6 text-body pricing-currency mt-2 mb-0 me-1">$</sup>
                        <h1 class="mb-0 text-primary">0</h1>
                        <sub class="h6 text-body pricing-duration mt-auto mb-1">/month</sub>
                        </div>
                    </div>

                    <ul class="list-group ps-6 my-5 pt-9">
                        <li class="mb-4">100 responses a month</li>
                        <li class="mb-4">Unlimited forms and surveys</li>
                        <li class="mb-4">Unlimited fields</li>
                        <li class="mb-4">Basic form creation tools</li>
                        <li class="mb-0">Up to 2 subdomains</li>
                    </ul>

                    <button
                        type="button"
                        class="btn btn-label-success d-grid w-100"
                        data-bs-dismiss="modal">
                        Your Current Plan
                    </button>
                    </div>
                </div>
                </div>

                <!-- Pro -->
                <div class="col-xl mb-md-0">
                <div class="card border-primary border shadow-none">
                    <div class="card-body position-relative pt-4 p-5">
                    <div class="position-absolute end-0 me-5 top-0 mt-4">
                        <span class="badge bg-label-primary rounded-1">Popular</span>
                    </div>
                    <div class="my-5 pt-6 text-center">
                        <img
                        src="../../assets/img/illustrations/page-pricing-standard.png"
                        alt="Standard Image"
                        height="120" />
                    </div>
                    <h4 class="card-title text-center text-capitalize mb-1">Standard</h4>
                    <p class="text-center mb-5">For small to medium businesses</p>
                    <div class="text-center h-px-50">
                        <div class="d-flex justify-content-center">
                        <sup class="h6 text-body pricing-currency mt-2 mb-0 me-1">$</sup>
                        <h1 class="price-toggle price-yearly text-primary mb-0">7</h1>
                        <h1 class="price-toggle price-monthly text-primary mb-0 d-none">9</h1>
                        <sub class="h6 text-body pricing-duration mt-auto mb-1">/month</sub>
                        </div>
                        <small class="price-yearly price-yearly-toggle text-body-secondary"
                        >USD 480 / year</small
                        >
                    </div>

                    <ul class="list-group ps-6 my-5 pt-9">
                        <li class="mb-4">Unlimited responses</li>
                        <li class="mb-4">Unlimited forms and surveys</li>
                        <li class="mb-4">Instagram profile page</li>
                        <li class="mb-4">Google Docs integration</li>
                        <li class="mb-0">Custom “Thank you” page</li>
                    </ul>

                    <button type="button" class="btn btn-primary d-grid w-100" data-bs-dismiss="modal">
                        Upgrade
                    </button>
                    </div>
                </div>
                </div>

                <!-- Enterprise -->
                <div class="col-xl">
                <div class="card border rounded shadow-none">
                    <div class="card-body pt-12 p-5">
                    <div class="mt-3 mb-5 text-center">
                        <img
                        src="../../assets/img/illustrations/page-pricing-enterprise.png"
                        alt="Enterprise Image"
                        height="120" />
                    </div>
                    <h4 class="card-title text-center text-capitalize mb-1">Enterprise</h4>
                    <p class="text-center mb-5">Solution for big organizations</p>

                    <div class="text-center h-px-50">
                        <div class="d-flex justify-content-center">
                        <sup class="h6 text-body pricing-currency mt-2 mb-0 me-1">$</sup>
                        <h1 class="price-toggle price-yearly text-primary mb-0">16</h1>
                        <h1 class="price-toggle price-monthly text-primary mb-0 d-none">19</h1>
                        <sub class="h6 text-body pricing-duration mt-auto mb-1">/month</sub>
                        </div>
                        <small class="price-yearly price-yearly-toggle text-body-secondary"
                        >USD 960 / year</small
                        >
                    </div>

                    <ul class="list-group ps-6 my-5 pt-9">
                        <li class="mb-4">PayPal payments</li>
                        <li class="mb-4">Logic Jumps</li>
                        <li class="mb-4">File upload with 5GB storage</li>
                        <li class="mb-4">Custom domain support</li>
                        <li class="mb-0">Stripe integration</li>
                    </ul>

                    <button
                        type="button"
                        class="btn btn-label-primary d-grid w-100"
                        data-bs-dismiss="modal">
                        Upgrade
                    </button>
                    </div>
                </div>
                </div>
            </div>
            </div>
            <!--/ Pricing Plans -->
        </div>
        </div>
    </div>
</div>
<!--/ Pricing Modal -->
<script src="../../assets//js/pages-pricing.js"></script>
<!--/ Modal -->
@endsection