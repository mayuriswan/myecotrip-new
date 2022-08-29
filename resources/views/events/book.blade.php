<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h3>Enter Address:</h3>

            <form action="../initiateEventBooking" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>First Name</label>
                            <input class="form-control" name="detail[0][first_name]" type="text" required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Last Name</label>
                            <input class="form-control" name="detail[0][last_name]" type="text" required />
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email</label>
                            <input class="form-control" name="detail[0][email]" type="email" required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Mobile Number</label>
                            <input class="form-control" pattern="^[6789]\d{9}$" name="detail[0][contact_no]" type="text" required />
                        </div>
                    </div>


                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Shipping Address</label>
                            <input class="form-control" name="detail[0][address]" type="text" required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>City / Town</label>
                            <input class="form-control" name="detail[0][city]" type="text" required />
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>PIN Code</label>
                            <input class="form-control" name="detail[0][pin_code]" type="number" required />
                        </div>
                    </div>
                </div>



                <strong><span style="color: red;">Note : Please follow the below instructions before booking</span>
                    <ol>
                        <li>Please refrain from using UPI payment, RuPay cards and foreign credit cards. We are having issues with these type of transactions.</li>
                        <li>Please do not make multiple booking in case of booking failure. Myecotrip team will contact you for booking assistance.</li>
                    </ol>
                </strong>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <input class="btn btn-primary" type="submit" value="Proceed Payment" />
                    </div>
                </div>
            </form>
        </div>

        <div class="col-md-4">
            <div class="booking-item-payment">
                <header class="clearfix">
                    <a class="booking-item-payment-img" href="#">
                        <img src="{{asset($displayData['eventLogo'])}}" alt="Image Alternative" title="Trail Image" />
                    </a>
                    <h2 class="booking-item-payment-title"><a href="#">{{$displayData['eventName']}}</a></h2>
                </header>
                <ul class="booking-item-payment-details">
                    <li>
                        <h5>Booking Details</h5>
                        <ul class="booking-item-payment-price">
                            <li>
                                <p class="booking-item-payment-price-title">Quantity</p>
                                <p class="booking-item-payment-price-amount">{{$displayData['tickets']}}
                                </p>
                            </li>

                            <li>
                                <p class="booking-item-payment-price-title">Price per unit</p>
                                <p class="booking-item-payment-price-amount">&#8377 {{$displayData['selectedBookingPrice']}}
                                </p>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <h5>Billing details</h5>
                        <ul class="booking-item-payment-price">
                            <li>
                                <p class="booking-item-payment-price-title">Total price</p>
                                <p class="booking-item-payment-price-amount">&#8377
                                    {{number_format((float)$displayData['total'], 2, '.', '')}}
                                </p>
                            </li>

                            <li>
                                <p class="booking-item-payment-price-title">KEDB Charges</p>
                                <p class="booking-item-payment-price-amount">&#8377
                                    {{number_format((float)$displayData['kedb_amount'], 2, '.', '')}}
                                </p>
                            </li>
                            <li>
                                <p class="booking-item-payment-price-title">GST charges</p>
                                <p class="booking-item-payment-price-amount">&#8377
                                {{number_format((float)$displayData['gstCharges'], 2, '.', '')}}
                                </p>
                            </li>
                            <li>
                                <p class="booking-item-payment-price-title">Shipping</p>
                                <p class="booking-item-payment-price-amount">&#8377
                                    {{number_format((float)$displayData['serviceCharges'], 2, '.', '')}}
                                </p>
                            </li>

                        </ul>
                    </li>
                </ul>
                <p class="booking-item-payment-total">Grand Total : <span>&#8377 {{$displayData['totalPayable']}}</span>
                </p>
            </div>
        </div>
    </div>
        <div class="gap"></div>
</div>
