@extends('layout.main')
@section('content')
<section class="forms">
    {!! Form::open(['route' => ['holding.update', $lims_holding_all->id ], 'method' => 'put', 'files' => true]) !!}
    <!--- header section  --->
    <div class="row ">
        <div class="col-md-12 item-sticky">
            <div class="card ">
                <div class="card-body item-page">
                    <div class="float-left brand-text mt-2 pl-4">
                        <h3>{{trans('file.Update Holding')}}</h3>
                    </div>
                    <div class="float-right mr-2">
                        <div class="form-group">
                            <a href="{{route('holding.index')}}" class="btn buttons-add"><i class="fa fa-times mr-1"></i> {{trans('file.Cancel')}}</a>
                            <button type="submit" id="submit-btn" class="btn btn-primary"><i class="fa fa-check mr-1"></i>{{trans('file.submit')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--- header section  --->

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.name')}}</label>
                                            <input type="text" name="name" class="form-control" value="{{$lims_holding_all->name}}" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.Code')}}</label>
                                            <input type="text" name="code" class="form-control" value="{{$lims_holding_all->code}}" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.Favicon')}}</label>
                                            <input type="file" name="favicon" class="form-control" value="{{$lims_holding_all->favicon}}" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.Company Logo')}}</label>
                                            <input type="file" name="company_logo" class="form-control" value="{{$lims_holding_all->company_logo}}" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.Email')}}</label>
                                            <input type="email" name="email" class="form-control" value="{{$lims_holding_all->email}}" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.Phone Number')}}</label>
                                            <input type="number" name="phone_number" class="form-control" value="{{$lims_holding_all->phone_number}}" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.Vat Number')}}</label>
                                            <input type="text" name="vat_number" class="form-control" value="{{$lims_holding_all->vat_number}}" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.Country')}}</label>
                                            <input type="hidden" name="country_hidden" value="{{$lims_holding_all->country}}" />
                                            <select name="country" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Country...">
                                                <option value="Afganistan">Afghanistan</option>
                                                <option value="Albania">Albania</option>
                                                <option value="Algeria">Algeria</option>
                                                <option value="American Samoa">American Samoa</option>
                                                <option value="Andorra">Andorra</option>
                                                <option value="Angola">Angola</option>
                                                <option value="Anguilla">Anguilla</option>
                                                <option value="Antigua & Barbuda">Antigua & Barbuda</option>
                                                <option value="Argentina">Argentina</option>
                                                <option value="Armenia">Armenia</option>
                                                <option value="Aruba">Aruba</option>
                                                <option value="Australia">Australia</option>
                                                <option value="Austria">Austria</option>
                                                <option value="Azerbaijan">Azerbaijan</option>
                                                <option value="Bahamas">Bahamas</option>
                                                <option value="Bahrain">Bahrain</option>
                                                <option value="Bangladesh">Bangladesh</option>
                                                <option value="Barbados">Barbados</option>
                                                <option value="Belarus">Belarus</option>
                                                <option value="Belgium">Belgium</option>
                                                <option value="Belize">Belize</option>
                                                <option value="Benin">Benin</option>
                                                <option value="Bermuda">Bermuda</option>
                                                <option value="Bhutan">Bhutan</option>
                                                <option value="Bolivia">Bolivia</option>
                                                <option value="Bonaire">Bonaire</option>
                                                <option value="Bosnia & Herzegovina">Bosnia & Herzegovina</option>
                                                <option value="Botswana">Botswana</option>
                                                <option value="Brazil">Brazil</option>
                                                <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                                                <option value="Brunei">Brunei</option>
                                                <option value="Bulgaria">Bulgaria</option>
                                                <option value="Burkina Faso">Burkina Faso</option>
                                                <option value="Burundi">Burundi</option>
                                                <option value="Cambodia">Cambodia</option>
                                                <option value="Cameroon">Cameroon</option>
                                                <option value="Canada">Canada</option>
                                                <option value="Canary Islands">Canary Islands</option>
                                                <option value="Cape Verde">Cape Verde</option>
                                                <option value="Cayman Islands">Cayman Islands</option>
                                                <option value="Central African Republic">Central African Republic</option>
                                                <option value="Chad">Chad</option>
                                                <option value="Channel Islands">Channel Islands</option>
                                                <option value="Chile">Chile</option>
                                                <option value="China">China</option>
                                                <option value="Christmas Island">Christmas Island</option>
                                                <option value="Cocos Island">Cocos Island</option>
                                                <option value="Colombia">Colombia</option>
                                                <option value="Comoros">Comoros</option>
                                                <option value="Congo">Congo</option>
                                                <option value="Cook Islands">Cook Islands</option>
                                                <option value="Costa Rica">Costa Rica</option>
                                                <option value="Cote DIvoire">Cote DIvoire</option>
                                                <option value="Croatia">Croatia</option>
                                                <option value="Cuba">Cuba</option>
                                                <option value="Curaco">Curacao</option>
                                                <option value="Cyprus">Cyprus</option>
                                                <option value="Czech Republic">Czech Republic</option>
                                                <option value="Denmark">Denmark</option>
                                                <option value="Djibouti">Djibouti</option>
                                                <option value="Dominica">Dominica</option>
                                                <option value="Dominican Republic">Dominican Republic</option>
                                                <option value="East Timor">East Timor</option>
                                                <option value="Ecuador">Ecuador</option>
                                                <option value="Egypt">Egypt</option>
                                                <option value="El Salvador">El Salvador</option>
                                                <option value="Equatorial Guinea">Equatorial Guinea</option>
                                                <option value="Eritrea">Eritrea</option>
                                                <option value="Estonia">Estonia</option>
                                                <option value="Ethiopia">Ethiopia</option>
                                                <option value="Falkland Islands">Falkland Islands</option>
                                                <option value="Faroe Islands">Faroe Islands</option>
                                                <option value="Fiji">Fiji</option>
                                                <option value="Finland">Finland</option>
                                                <option value="France">France</option>
                                                <option value="French Guiana">French Guiana</option>
                                                <option value="French Polynesia">French Polynesia</option>
                                                <option value="French Southern Ter">French Southern Ter</option>
                                                <option value="Gabon">Gabon</option>
                                                <option value="Gambia">Gambia</option>
                                                <option value="Georgia">Georgia</option>
                                                <option value="Germany">Germany</option>
                                                <option value="Ghana">Ghana</option>
                                                <option value="Gibraltar">Gibraltar</option>
                                                <option value="Great Britain">Great Britain</option>
                                                <option value="Greece">Greece</option>
                                                <option value="Greenland">Greenland</option>
                                                <option value="Grenada">Grenada</option>
                                                <option value="Guadeloupe">Guadeloupe</option>
                                                <option value="Guam">Guam</option>
                                                <option value="Guatemala">Guatemala</option>
                                                <option value="Guinea">Guinea</option>
                                                <option value="Guyana">Guyana</option>
                                                <option value="Haiti">Haiti</option>
                                                <option value="Hawaii">Hawaii</option>
                                                <option value="Honduras">Honduras</option>
                                                <option value="Hong Kong">Hong Kong</option>
                                                <option value="Hungary">Hungary</option>
                                                <option value="Iceland">Iceland</option>
                                                <option value="Indonesia">Indonesia</option>
                                                <option value="India">India</option>
                                                <option value="Iran">Iran</option>
                                                <option value="Iraq">Iraq</option>
                                                <option value="Ireland">Ireland</option>
                                                <option value="Isle of Man">Isle of Man</option>
                                                <option value="Israel">Israel</option>
                                                <option value="Italy">Italy</option>
                                                <option value="Jamaica">Jamaica</option>
                                                <option value="Japan">Japan</option>
                                                <option value="Jordan">Jordan</option>
                                                <option value="Kazakhstan">Kazakhstan</option>
                                                <option value="Kenya">Kenya</option>
                                                <option value="Kiribati">Kiribati</option>
                                                <option value="Korea North">Korea North</option>
                                                <option value="Korea Sout">Korea South</option>
                                                <option value="Kuwait">Kuwait</option>
                                                <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                <option value="Laos">Laos</option>
                                                <option value="Latvia">Latvia</option>
                                                <option value="Lebanon">Lebanon</option>
                                                <option value="Lesotho">Lesotho</option>
                                                <option value="Liberia">Liberia</option>
                                                <option value="Libya">Libya</option>
                                                <option value="Liechtenstein">Liechtenstein</option>
                                                <option value="Lithuania">Lithuania</option>
                                                <option value="Luxembourg">Luxembourg</option>
                                                <option value="Macau">Macau</option>
                                                <option value="Macedonia">Macedonia</option>
                                                <option value="Madagascar">Madagascar</option>
                                                <option value="Malaysia">Malaysia</option>
                                                <option value="Malawi">Malawi</option>
                                                <option value="Maldives">Maldives</option>
                                                <option value="Mali">Mali</option>
                                                <option value="Malta">Malta</option>
                                                <option value="Marshall Islands">Marshall Islands</option>
                                                <option value="Martinique">Martinique</option>
                                                <option value="Mauritania">Mauritania</option>
                                                <option value="Mauritius">Mauritius</option>
                                                <option value="Mayotte">Mayotte</option>
                                                <option value="Mexico">Mexico</option>
                                                <option value="Midway Islands">Midway Islands</option>
                                                <option value="Moldova">Moldova</option>
                                                <option value="Monaco">Monaco</option>
                                                <option value="Mongolia">Mongolia</option>
                                                <option value="Montserrat">Montserrat</option>
                                                <option value="Morocco">Morocco</option>
                                                <option value="Mozambique">Mozambique</option>
                                                <option value="Myanmar">Myanmar</option>
                                                <option value="Nambia">Nambia</option>
                                                <option value="Nauru">Nauru</option>
                                                <option value="Nepal">Nepal</option>
                                                <option value="Netherland Antilles">Netherland Antilles</option>
                                                <option value="Netherlands">Netherlands (Holland, Europe)</option>
                                                <option value="Nevis">Nevis</option>
                                                <option value="New Caledonia">New Caledonia</option>
                                                <option value="New Zealand">New Zealand</option>
                                                <option value="Nicaragua">Nicaragua</option>
                                                <option value="Niger">Niger</option>
                                                <option value="Nigeria">Nigeria</option>
                                                <option value="Niue">Niue</option>
                                                <option value="Norfolk Island">Norfolk Island</option>
                                                <option value="Norway">Norway</option>
                                                <option value="Oman">Oman</option>
                                                <option value="Pakistan">Pakistan</option>
                                                <option value="Palau Island">Palau Island</option>
                                                <option value="Palestine">Palestine</option>
                                                <option value="Panama">Panama</option>
                                                <option value="Papua New Guinea">Papua New Guinea</option>
                                                <option value="Paraguay">Paraguay</option>
                                                <option value="Peru">Peru</option>
                                                <option value="Phillipines">Philippines</option>
                                                <option value="Pitcairn Island">Pitcairn Island</option>
                                                <option value="Poland">Poland</option>
                                                <option value="Portugal">Portugal</option>
                                                <option value="Puerto Rico">Puerto Rico</option>
                                                <option value="Qatar">Qatar</option>
                                                <option value="Republic of Montenegro">Republic of Montenegro</option>
                                                <option value="Republic of Serbia">Republic of Serbia</option>
                                                <option value="Reunion">Reunion</option>
                                                <option value="Romania">Romania</option>
                                                <option value="Russia">Russia</option>
                                                <option value="Rwanda">Rwanda</option>
                                                <option value="St Barthelemy">St Barthelemy</option>
                                                <option value="St Eustatius">St Eustatius</option>
                                                <option value="St Helena">St Helena</option>
                                                <option value="St Kitts-Nevis">St Kitts-Nevis</option>
                                                <option value="St Lucia">St Lucia</option>
                                                <option value="St Maarten">St Maarten</option>
                                                <option value="St Pierre & Miquelon">St Pierre & Miquelon</option>
                                                <option value="St Vincent & Grenadines">St Vincent & Grenadines</option>
                                                <option value="Saipan">Saipan</option>
                                                <option value="Samoa">Samoa</option>
                                                <option value="Samoa American">Samoa American</option>
                                                <option value="San Marino">San Marino</option>
                                                <option value="Sao Tome & Principe">Sao Tome & Principe</option>
                                                <option value="Saudi Arabia">Saudi Arabia</option>
                                                <option value="Senegal">Senegal</option>
                                                <option value="Seychelles">Seychelles</option>
                                                <option value="Sierra Leone">Sierra Leone</option>
                                                <option value="Singapore">Singapore</option>
                                                <option value="Slovakia">Slovakia</option>
                                                <option value="Slovenia">Slovenia</option>
                                                <option value="Solomon Islands">Solomon Islands</option>
                                                <option value="Somalia">Somalia</option>
                                                <option value="South Africa">South Africa</option>
                                                <option value="Spain">Spain</option>
                                                <option value="Sri Lanka">Sri Lanka</option>
                                                <option value="Sudan">Sudan</option>
                                                <option value="Suriname">Suriname</option>
                                                <option value="Swaziland">Swaziland</option>
                                                <option value="Sweden">Sweden</option>
                                                <option value="Switzerland">Switzerland</option>
                                                <option value="Syria">Syria</option>
                                                <option value="Tahiti">Tahiti</option>
                                                <option value="Taiwan">Taiwan</option>
                                                <option value="Tajikistan">Tajikistan</option>
                                                <option value="Tanzania">Tanzania</option>
                                                <option value="Thailand">Thailand</option>
                                                <option value="Togo">Togo</option>
                                                <option value="Tokelau">Tokelau</option>
                                                <option value="Tonga">Tonga</option>
                                                <option value="Trinidad & Tobago">Trinidad & Tobago</option>
                                                <option value="Tunisia">Tunisia</option>
                                                <option value="Turkey">Turkey</option>
                                                <option value="Turkmenistan">Turkmenistan</option>
                                                <option value="Turks & Caicos Is">Turks & Caicos Is</option>
                                                <option value="Tuvalu">Tuvalu</option>
                                                <option value="Uganda">Uganda</option>
                                                <option value="United Kingdom">United Kingdom</option>
                                                <option value="Ukraine">Ukraine</option>
                                                <option value="United Arab Erimates">United Arab Emirates</option>
                                                <option value="United States of America">United States of America</option>
                                                <option value="Uraguay">Uruguay</option>
                                                <option value="Uzbekistan">Uzbekistan</option>
                                                <option value="Vanuatu">Vanuatu</option>
                                                <option value="Vatican City State">Vatican City State</option>
                                                <option value="Venezuela">Venezuela</option>
                                                <option value="Vietnam">Vietnam</option>
                                                <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                                                <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                                                <option value="Wake Island">Wake Island</option>
                                                <option value="Wallis & Futana Is">Wallis & Futana Is</option>
                                                <option value="Yemen">Yemen</option>
                                                <option value="Zaire">Zaire</option>
                                                <option value="Zambia">Zambia</option>
                                                <option value="Zimbabwe">Zimbabwe</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.Address')}}</label>
                                            <input type="text" name="address" class="form-control" value="{{$lims_holding_all->address}}" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.City')}}</label>
                                            <input type="text" name="city" class="form-control" value="{{$lims_holding_all->city}}" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.State')}}</label>
                                            <input type="text" name="state" class="form-control" value="{{$lims_holding_all->state}}" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.Postal Code')}}</label>
                                            <input type="text" name="postal_code" class="form-control" value="{{$lims_holding_all->postal_code}}" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.Currency')}}</label>
                                            <input type="hidden" name="currency_id_hidden" value="{{$lims_holding_all->currency_id}}" />
                                            <select name="currency_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Currency...">
                                                @foreach($lims_currency_all as $currency)
                                                    <option value="{{$currency->id}}">{{$currency->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.Currency Position')}}</label> <br>
                                            <input type="hidden" name="currency_position_hidden" value="{{$lims_holding_all->currency_position}}" />
                                            <select name="currency_position" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Currency Position...">
                                                <option value="prefix">{{trans('file.Prefix')}}</option>
                                                <option value="suffix">{{trans('file.Suffix')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.Date Format')}}</label>
                                            <input type="hidden" name="date_format_hidden" value="{{$lims_holding_all->date_format}}" />
                                            <select name="date_format" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Date Format...">
                                                <option value="dd-mm-yy"> dd-mmm-yyy</option>
                                                <option value="d-m-Y"> dd-mm-yyy</option>
                                                <option value="d/m/Y"> dd/mm/yyy</option>
                                                <option value="d.m.Y"> dd.mm.yyy</option>
                                                <option value="m-d-Y"> mm-dd-yyy</option>
                                                <option value="m/d/Y"> mm/dd/yyy</option>
                                                <option value="m.d.Y"> mm.dd.yyy</option>
                                                <option value="Y-m-d"> yyy-mm-dd</option>
                                                <option value="Y/m/d"> yyy/mm/dd</option>
                                                <option value="Y.m.d"> yyy.mm.dd</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.Invoice Format')}}</label>
                                            <input type="hidden" name="invoice_format_hidden" value="{{$lims_holding_all->invoice_format}}" />
                                            <select name="invoice_format" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Invoice Format...">
                                                <option value="standard">Standard</option>
                                                <option value="gst">Indian GST</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.Staff Access')}}</label>
                                            <input type="hidden" name="staff_access_hidden" value="{{$lims_holding_all->staff_access}}" />
                                            <select name="staff_access" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Staff Access...">
                                                <option value="all"> {{trans('file.All Records')}}</option>
                                                <option value="own"> {{trans('file.Own Records')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.Theme')}}</label>
                                            <input type="hidden" name="theme_hidden" value="{{$lims_holding_all->theme}}" />
                                            <select name="theme" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Theme...">
                                                @foreach($lims_theme_all as $theme)
                                                    <option value="{{$theme->id}}">{{$theme->theme}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.Active')}} <i class="fa fa-asterisk"></i></label>
                                            <input type="hidden" name="is_active_hidden" value="{{$lims_holding_all->is_active}}" />
                                            <select required name="is_active" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Status...">
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{trans('file.Description')}}</label><i class="fa fa-asterisk"></i>
                                            <textarea rows="5" class="form-control" name="description">{{$lims_holding_all->description}}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mt-2">
                                        <label>{{trans('file.Select Company')}}</label>
                                        <div class="search-box input-group">
                                            <button type="button" class="btn btn-secondary"><i class="fa fa-barcode"></i></button>
                                            <input type="text" name="company_code_name" id="lims_companycodeSearch"
                                                placeholder="Please type Company code and select..." class="form-control" />
                                            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#bulkCompany" title="{{ trans('file.Add multiple Company from list') }}"><i class="fa fa-plus"></i> <i class="fa fa-bars"></i></button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-5">
		                            <div class="col-md-12">
		                                <h5>{{trans('file.Company Table')}}<i class="fa fa-asterisk"></i></h5>
		                                <div class="table-responsive mt-3">
		                                    <table id="myTable" class="table table-hover order-list">
		                                        <thead>
		                                            <tr>
		                                                <th>{{trans('file.Image')}}</th>
		                                                <th>{{trans('file.Company Code')}}</th>
                                                        <th>{{trans('file.Company Name')}}</th>
                                                        <th>{{trans('file.Access')}}</th>
                                                        <th>{{trans('file.Active')}}</th>
                                                        <th><i class="dripicons-trash"></i></th>
		                                            </tr>
		                                        </thead>
		                                        <tbody id="displayProducts">
		                                        </tbody>
		                                    </table>
		                                </div>
		                            </div>
		                        </div>

                                <div class="form-group">
                                    <input type="submit" value="{{trans('file.submit')}}" class="btn btn-primary" id="submit-button">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    <!-- Add Bulk bulkCompany -->
    <div id="bulkCompany" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header item-page">
                    <div class="col-md-12">
                        <div class="float-left brand-text mt-2">
                            <h3>{{ trans('file.Add Multiple Company') }}</h3>
                        </div>
                        <div class="float-right">
                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                    aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                        </div>
                        <div class="float-right">
                            <div class="form-group">
                                <button type="button" class="btn btn-save"
                                    title="{{ trans('file.Use ctrl+s to save') }}" onclick="AddCompany()"><i
                                        class="fa fa-plus mr-1" aria-hidden="true"></i>
                                    {{ trans('file.Add Company') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="bulkcompany-table" class="table company-list" style="width: 100%">
                            <thead>
                                <tr>
                                    <th class="not-exported" style="border-radius: 5px 0px 0px 5px"></th>
                                    <th>{{ trans('file.Image') }}</th>
                                    <th>{{ trans('file.Company Code') }}</th>
                                    <th>{{ trans('file.Company Name') }}</th>
                                    <th class="d-none">{{ trans('file.ID') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lims_company_list as $key => $company)
                                    <tr>
                                        <td>{{ $key }}</td>
                                        <td>
                                            <img src="{{ asset("public/company/images/$company->company_logo") }}"
                                                alt="product image" class="product_image" width="80" height="80" />
                                        </td>
                                        <td>{{ $company->code }}</td>
                                        <td>{{ $company->name }}</td>
                                        <td class="d-none id">{{ $company->id }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
<?php $companyIds = []; ?>
@foreach ($lims_holding_all->holdingCompany as $row)
<?php
    array_push($companyIds, $row->company->id);
?>
@endforeach

<script type="text/javascript">

    // Ctrl+S and Cmd+S trigger Save button click
    $(document).keydown(function(e) {
        if ((e.which == '115' || e.which == '83' ) && (e.ctrlKey || e.metaKey))
        {
            e.preventDefault();
            // alert("Ctrl-s pressed");
            $("button[type=submit]").trigger('click');
            return false;
        }
        return true;
    });

    addCompanyEdit(`{{ implode(",", $companyIds) }}`);

    $('select[name="country"]').val($('input[name="country_hidden"]').val());
    $('select[name="is_active"]').val($('input[name="is_active_hidden"]').val());
    $('select[name="theme"]').val($('input[name="theme_hidden"]').val());
    $('select[name="staff_access"]').val($('input[name="staff_access_hidden"]').val());
    $('select[name="invoice_format"]').val($('input[name="invoice_format_hidden"]').val());
    $('select[name="date_format"]').val($('input[name="date_format_hidden"]').val());
    $('select[name="currency_position"]').val($('input[name="currency_position_hidden"]').val());
    $('select[name="currency_id"]').val($('input[name="currency_id_hidden"]').val());

    $('.selectpicker').selectpicker({
	    style: 'btn-link',
	});

    function confirmDelete() {
        if (confirm("Are you sure want to delete?")) {
            return true;
        }
        return false;
    }

    $('#bulkcompany-table tbody').on('click', 'tr', function(e) {
        var checkbox = $(this).find('td:first :checkbox').trigger('click');
        setTimeout(() => {
            if (checkbox[0].checked === true) {
                this.getElementsByClassName('id')[0].classList.add("selectedId");
            } else {
                this.getElementsByClassName('id')[0].classList.remove("selectedId");
            }
        }, 500);
    });

    function AddCompany() {
        let selectedIds = document.getElementsByClassName('selectedId');
        let ids = [];
        for (let selectedId of selectedIds) {
            ids.push(selectedId.innerText);
        }
        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: '/holding/getSelectedCompany',
            data: {
                _token: CSRF_TOKEN,
                ids: ids,
            },
            type: "POST",
            success: function(jsonData) {
                console.log(jsonData);
                AddCompanyToTable(jsonData);
                $('#bulkCompany').modal('hide');
            },
            error: function() {
                alert('Something went wrong!');
            }
        });
    }

    function addCompanyEdit(companyIds) {
        const ids = companyIds.split(",");
        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: '/holding/getSelectedCompany',
            data: {
                _token: CSRF_TOKEN,
                ids: ids,
            },
            type: "POST",
            success: function(jsonData) {
                console.log(jsonData);
                AddCompanyToTable(jsonData);
                $('#bulkCompany').modal('hide');
            },
            error: function() {
                alert('Something went wrong!');
            }
        });
    }

    // global variable of data table id
    var CompanyTableDataId = [];

    function hasDataOnTable(id) {
        for (let i = 0; i < CompanyTableDataId.length; i++)
            if (CompanyTableDataId[i] == id) return false;
            CompanyTableDataId.push(id);
        return true;
    }

    function AddCompanyToTable(data) {
        console.log(data);
        for (let company in data['companies']) {
            console.log(company);
            if (hasDataOnTable(data['companies'][company]['id'])) {
                let imgSrc = window.location.protocol + '//' + window.location.hostname + '/' + window.location.port +
                    '/company/images/' + data['companies'][company]['company_logo'];
                let newRow = $("<tr>");
                let cols = '';
                // pos = company_code.indexOf(company.code);
                cols += '<td> <img src="' + imgSrc + '" class="product_image" width="50" height="50"/></td>';
                cols += '<td>' + data['companies'][company]['code'] + '</td>';
                cols += '<td>' + data['companies'][company]['name'] + '</td>';
                // cols += '<td>' + data['companies'][company]['staff_access'] + '</td>';
                // cols += '<td><div class="badge badge-success">' + data['companies'][company]['is_active'] + '</div></td>';

                cols += '<td>';
                cols += '<select name="staff_access[]" class="form-control" required>';
                cols += '<option disabled selected>Select</option>';
                cols += '<option value="all">All Records</option>';
                cols += '<option value="own">Own Records</option>';
                cols += '</select>';
                cols += '</td>';
                cols += '<td> <a href="' + data['companies'][company]['is_active'] + '" class="badge badge-success"> Yes </a></td>';
                cols +=
                    `<td><button type="button" onclick="removeCompanyTableItem(this, ${data['companies'][company]['id']});" class="ibtnDel btn btn-md btn-danger"><i class="dripicons-trash"></i></button></td>`;
                cols += '<input type="hidden" class="form-control" name="company_id[]" value="' + data['companies'][company][
                    'id'
                ] + '"/>';

                newRow.append(cols);
                $("table.order-list tbody").prepend(newRow);
            }
        }

    }

    function removeCompanyTableItem(item, id) {
        CompanyTableDataId = CompanyTableDataId.filter(e => e !== id);
        item.parentNode.parentNode.remove()
    }


    $('#bulkcompany-table').DataTable({
        responsive: true,
        fixedHeader: {
            header: true,
            footer: true
        },
        "order": [],
        'language': {
            'lengthMenu': '_MENU_ {{trans("file.records")}}',
            "info":      '<small>{{trans("file.Showing")}} _START_ - _END_ (_TOTAL_)</small>',
            "search":  '{{trans("file.Search")}}',
            'paginate': {
                    'previous': '<i class="dripicons-chevron-left"></i>',
                    'next': '<i class="dripicons-chevron-right"></i>'
            }
        },
        'columnDefs': [{
                "orderable": false,
                'targets': [0, 3]
            },
            {
                'render': function(data, type, row, meta) {
                    if (type === 'display') {
                        data =
                            '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>';
                    }

                    return data;
                },
                'checkboxes': {
                    'selectRow': true,
                    'selectAllRender': '<div class="checkbox"><input type="checkbox" class="dt-checkboxes" id="dt-checkbox-checked"><label></label></div>'
                },
                'targets': [0]
            }
        ],
        'select': {
            style: 'multi',
            selector: 'td:first-child'
        },
        'lengthMenu': [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        dom: '<"row"lfB>rtip',
        buttons: [

        ],
        drawCallback: function() {
            // var api = this.api();
            // datatable_sum(api, false);
        }
    });


</script>
@endsection
