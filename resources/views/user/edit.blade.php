@php($pageTitle = 'users')
@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="bg-white border rounded">
            <div class="row no-gutters">
                <div class="col-lg-4 col-xl-3">
                    <div class="profile-content-left pt-5 pb-3 px-3 px-xl-5">
                        <div class="card text-center widget-profile px-0 border-0">
                            <div class="card-img mx-auto w-100">
                                @if (isset($user->user_avatar))
                                    <img class="h-100" src="{{ asset($user->user_avatar) }}" alt="user image">
                                @else
                                    <img class="h-100" src="{{ asset('img/no-img.png') }}" alt="user image">
                                @endif
                            </div>
                            <div class="card-body">
                                <h4 class="py-2 text-dark">{{ $user->name }}</h4>
                                <p>{{ $user->email }}</p>
                            </div>
                        </div>
                        <hr class="w-100">
                        <div class="contact-info pt-4">
                            <h5 class="text-dark mb-1">{{ __('users.contact') }}</h5>
                            <p class="text-dark font-weight-medium pt-4 mb-2">{{ __('users.email') }}</p>
                            <p>{{ $user->email }}</p>
                            <p class="text-dark font-weight-medium pt-4 mb-2">{{ __('users.phone') }}</p>
                            <p>{{ $user->phone }}</p>
                            <p class="text-dark font-weight-medium pt-4 mb-2">{{ __('users.country') }}</p>
                            <p>{{ $user->country_name }}</p>
                            <p class="text-dark font-weight-medium pt-4 mb-2">{{ __('users.status') }}</p>
                            @if($user->status == 0)
                                <p>{{ __('users.no-groups-to-see') }}</p>
                            @else
                                <p>{{ __('users.see-all-groups') }}</p>
                            @endif
                            <p class="text-dark font-weight-medium pt-4 mb-2">{{ __('users.role') }}</p>
                            @if($user->role == 0)
                                <p>{{ __('users.normal') }}</p>
                            @else
                                <p>{{ __('users.admin') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-xl-9">
                    <div class="profile-content-right py-5">
                        <ul class="nav nav-tabs px-3 px-xl-5 nav-style-border" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">{{ __('users.profile') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="settings-tab" data-toggle="tab" href="#settings" role="tab" aria-controls="settings" aria-selected="false">{{ __('users.settings') }}</a>
                            </li>
                        </ul>
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success mt-1" role="alert">
                                {{ $message }}
                            </div>
                        @endif
                        <div class="tab-content px-3 px-xl-5" id="myTabContent">
                            <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="mt-5">
                                    <div class="row">
                                        <div class="col-xl-3">
                                            <div class="media widget-media p-4 bg-white border">
                                                <div class="icon rounded-circle mr-4 bg-danger">
                                                    <i class="mdi mdi-account-group text-white "></i>
                                                </div>
                                                <div class="media-body align-self-center">
                                                    <h4 class="text-primary mb-2">{{ $count_sub_groups }}</h4>
                                                    <p>{{ __('users.sub-groups.title') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3">
                                            <div class="media widget-media p-4 bg-white border">
                                                <div class="icon rounded-circle bg-primary mr-4">
                                                    <i class="mdi mdi-arrow-top-right text-white "></i>
                                                </div>
                                                <div class="media-body align-self-center">
                                                    <h4 class="text-primary mb-2">{{ $totalActiveInvest }}</h4>
                                                    <p>{{ __('users.active-invest') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3">
                                            <div class="media widget-media p-4 bg-white border">
                                                <div class="icon rounded-circle bg-dark mr-4">
                                                    <i class="mdi mdi-arrow-top-right text-white "></i>
                                                </div>
                                                <div class="media-body align-self-center">
                                                    <h4 class="text-primary mb-2">{{ $count_invest }}</h4>
                                                    <p>{{ __('users.total-invest') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3">
                                            <div class="media widget-media p-4 bg-white border">
                                                <div class="icon rounded-circle mr-4 bg-success">
                                                    <i class="mdi mdi-square-inc-cash text-white "></i>
                                                </div>
                                                <div class="media-body align-self-center">
                                                    <h4 class="text-primary mb-2">{{ $balance }}</h4>
                                                    <p>{{ __('users.sub-groups.balance') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <!-- Recent Order Table -->
                                            <div class="card card-table-border-none" id="recent-orders">
                                                <div class="card-header justify-content-between">
                                                    <h2>{{ __('users.sub-groups.title') }}</h2>
                                                </div>
                                                @if(count($sub_groups) > 0)
                                                <div class="card-body pt-0 pb-5">
                                                    <table class="table card-table table-responsive table-responsive-large d-block" style="width:100%">
                                                        <thead>
                                                        <tr>
                                                            <th>{{ __('users.sub-groups.id') }}</th>
                                                            <th>{{ __('users.sub-groups.name') }}</th>
                                                            <th>{{ __('users.sub-groups.code') }}</th>
                                                            <th>{{ __('users.sub-groups.balance') }}</th>
                                                            <th>{{ __('users.sub-groups.sub-at') }}</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($sub_groups as $sub)
                                                        <tr>
                                                            <td>{{ $sub->id }}</td>
                                                            <td>
                                                                @foreach($allGroups as $group)
                                                                    @if ($group->id == $sub->group_id) {{ $group->group_name }} @endif
                                                                @endforeach
                                                            </td>
                                                            <td>
                                                                @foreach($allCodes as $code)
                                                                    @if ($code->id == $sub->code_id) {{ $code->code_key }} @endif
                                                                @endforeach
                                                            </td>
                                                            <td>{{ $sub->code_balance }}</td>
                                                            <td>{{ $sub->subscribed_at }}</td>
                                                        </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                @else
                                                <div class="card-body pt-0 pb-5">
                                                    <h2>{{ __('users.no-data') }}</h2>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <!-- Recent Order Table -->
                                            <div class="card card-table-border-none" id="recent-orders">
                                                <div class="card-header justify-content-between">
                                                    <h2>{{ __('users.active-invest') }}</h2>
                                                </div>
                                                @if(count($activeInvest) > 0)
                                                    <div class="card-body pt-0 pb-5">
                                                        <table class="table card-table table-responsive table-responsive-large" style="width:100%">
                                                            <thead>
                                                            <tr>
                                                                <th>{{ __('users.sub-groups.name') }}</th>
                                                                <th>{{ __('users.sub-groups.balance') }}</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($activeInvest as $inv)
                                                                <tr>
                                                                    <td>
                                                                        @foreach($allGroups as $group)
                                                                            @if ($group->id == $inv->group_id) {{ $group->group_name }} @endif
                                                                        @endforeach
                                                                    </td>
                                                                    <td>{{ $inv->total_balance }}</td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @else
                                                    <div class="card-body pt-0 pb-5">
                                                        <h2>{{ __('users.no-data') }}</h2>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                                <div class="mt-5">
                                    <form action="{{ route('update.user', $user->id) }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group row mb-6">
                                            <label for="{{ __('users.avatar') }}" class="col-sm-3 col-lg-3 col-form-label">{{ __('users.avatar') }}</label>
                                            <a href="{{ route('delete.avatar', $user->id) }}" class="col-sm-3 col-lg-3 btn btn-danger">{{ __('users.avatar-remove') }}</a>
                                            <div class="col-sm-8 col-lg-6">
                                                <div class="custom-file mb-1">
                                                    <input type="file" name="user_avatar" class="custom-file-input" id="{{ __('users.avatar') }}" accept="image/*">
                                                    <label class="custom-file-label" for="{{ __('users.avatar') }}">{{ __('users.choose') }}</label>
                                                    @error('user_avatar')
                                                        <div class="alert alert-danger col-12 mt-1" role="alert">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mb-4">
                                            <label for="{{ __('users.name') }}">{{ __('users.name') }}</label>
                                            <input type="text" name="name" class="form-control" id="{{ __('users.name') }}" value="{{ $user->name }}">
                                            @error('name')
                                                <div class="alert alert-danger col-12 mt-1" role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-4">
                                            <label for="{{ __('users.email') }}">{{ __('users.email') }}</label>
                                            <input type="email" name="email" class="form-control" id="{{ __('users.email') }}" value="{{ $user->email }}">
                                            @error('email')
                                                <div class="alert alert-danger col-12 mt-1" role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-4">
                                            <label for="{{ __('users.phone') }}">{{ __('users.phone') }}</label>
                                            <input type="text" name="phone" class="form-control" id="{{ __('users.phone') }}" value="{{ $user->phone }}">
                                            @error('phone')
                                                <div class="alert alert-danger col-12 mt-1" role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-4">
                                            <label for="{{ __('users.country') }}">{{ __('users.country') }}</label>
                                            <select class="form-control" name="country" id="{{ __('users.country') }}" >
                                                <option value="{{ $user->country }}">{{ $user->country }}</option>
                                                <option value="AF">Afghanistan</option>
                                                <option value="AX">Aland Islands</option>
                                                <option value="AL">Albania</option>
                                                <option value="DZ">Algeria</option>
                                                <option value="AS">American Samoa</option>
                                                <option value="AD">Andorra</option>
                                                <option value="AO">Angola</option>
                                                <option value="AI">Anguilla</option>
                                                <option value="AQ">Antarctica</option>
                                                <option value="AG">Antigua and Barbuda</option>
                                                <option value="AR">Argentina</option>
                                                <option value="AM">Armenia</option>
                                                <option value="AW">Aruba</option>
                                                <option value="AU">Australia</option>
                                                <option value="AT">Austria</option>
                                                <option value="AZ">Azerbaijan</option>
                                                <option value="BS">Bahamas</option>
                                                <option value="BH">Bahrain</option>
                                                <option value="BD">Bangladesh</option>
                                                <option value="BB">Barbados</option>
                                                <option value="BY">Belarus</option>
                                                <option value="BE">Belgium</option>
                                                <option value="BZ">Belize</option>
                                                <option value="BJ">Benin</option>
                                                <option value="BM">Bermuda</option>
                                                <option value="BT">Bhutan</option>
                                                <option value="BO">Bolivia</option>
                                                <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                                                <option value="BA">Bosnia and Herzegovina</option>
                                                <option value="BW">Botswana</option>
                                                <option value="BV">Bouvet Island</option>
                                                <option value="BR">Brazil</option>
                                                <option value="IO">British Indian Ocean Territory</option>
                                                <option value="BN">Brunei Darussalam</option>
                                                <option value="BG">Bulgaria</option>
                                                <option value="BF">Burkina Faso</option>
                                                <option value="BI">Burundi</option>
                                                <option value="KH">Cambodia</option>
                                                <option value="CM">Cameroon</option>
                                                <option value="CA">Canada</option>
                                                <option value="CV">Cape Verde</option>
                                                <option value="KY">Cayman Islands</option>
                                                <option value="CF">Central African Republic</option>
                                                <option value="TD">Chad</option>
                                                <option value="CL">Chile</option>
                                                <option value="CN">China</option>
                                                <option value="CX">Christmas Island</option>
                                                <option value="CC">Cocos (Keeling) Islands</option>
                                                <option value="CO">Colombia</option>
                                                <option value="KM">Comoros</option>
                                                <option value="CG">Congo</option>
                                                <option value="CD">Congo, Democratic Republic of the Congo</option>
                                                <option value="CK">Cook Islands</option>
                                                <option value="CR">Costa Rica</option>
                                                <option value="CI">Cote D'Ivoire</option>
                                                <option value="HR">Croatia</option>
                                                <option value="CU">Cuba</option>
                                                <option value="CW">Curacao</option>
                                                <option value="CY">Cyprus</option>
                                                <option value="CZ">Czech Republic</option>
                                                <option value="DK">Denmark</option>
                                                <option value="DJ">Djibouti</option>
                                                <option value="DM">Dominica</option>
                                                <option value="DO">Dominican Republic</option>
                                                <option value="EC">Ecuador</option>
                                                <option value="EG">Egypt</option>
                                                <option value="SV">El Salvador</option>
                                                <option value="GQ">Equatorial Guinea</option>
                                                <option value="ER">Eritrea</option>
                                                <option value="EE">Estonia</option>
                                                <option value="ET">Ethiopia</option>
                                                <option value="FK">Falkland Islands (Malvinas)</option>
                                                <option value="FO">Faroe Islands</option>
                                                <option value="FJ">Fiji</option>
                                                <option value="FI">Finland</option>
                                                <option value="FR">France</option>
                                                <option value="GF">French Guiana</option>
                                                <option value="PF">French Polynesia</option>
                                                <option value="TF">French Southern Territories</option>
                                                <option value="GA">Gabon</option>
                                                <option value="GM">Gambia</option>
                                                <option value="GE">Georgia</option>
                                                <option value="DE">Germany</option>
                                                <option value="GH">Ghana</option>
                                                <option value="GI">Gibraltar</option>
                                                <option value="GR">Greece</option>
                                                <option value="GL">Greenland</option>
                                                <option value="GD">Grenada</option>
                                                <option value="GP">Guadeloupe</option>
                                                <option value="GU">Guam</option>
                                                <option value="GT">Guatemala</option>
                                                <option value="GG">Guernsey</option>
                                                <option value="GN">Guinea</option>
                                                <option value="GW">Guinea-Bissau</option>
                                                <option value="GY">Guyana</option>
                                                <option value="HT">Haiti</option>
                                                <option value="HM">Heard Island and Mcdonald Islands</option>
                                                <option value="VA">Holy See (Vatican City State)</option>
                                                <option value="HN">Honduras</option>
                                                <option value="HK">Hong Kong</option>
                                                <option value="HU">Hungary</option>
                                                <option value="IS">Iceland</option>
                                                <option value="IN">India</option>
                                                <option value="ID">Indonesia</option>
                                                <option value="IR">Iran, Islamic Republic of</option>
                                                <option value="IQ">Iraq</option>
                                                <option value="IE">Ireland</option>
                                                <option value="IM">Isle of Man</option>
                                                <option value="IL">Israel</option>
                                                <option value="IT">Italy</option>
                                                <option value="JM">Jamaica</option>
                                                <option value="JP">Japan</option>
                                                <option value="JE">Jersey</option>
                                                <option value="JO">Jordan</option>
                                                <option value="KZ">Kazakhstan</option>
                                                <option value="KE">Kenya</option>
                                                <option value="KI">Kiribati</option>
                                                <option value="KP">Korea, Democratic People's Republic of</option>
                                                <option value="KR">Korea, Republic of</option>
                                                <option value="XK">Kosovo</option>
                                                <option value="KW">Kuwait</option>
                                                <option value="KG">Kyrgyzstan</option>
                                                <option value="LA">Lao People's Democratic Republic</option>
                                                <option value="LV">Latvia</option>
                                                <option value="LB">Lebanon</option>
                                                <option value="LS">Lesotho</option>
                                                <option value="LR">Liberia</option>
                                                <option value="LY">Libyan Arab Jamahiriya</option>
                                                <option value="LI">Liechtenstein</option>
                                                <option value="LT">Lithuania</option>
                                                <option value="LU">Luxembourg</option>
                                                <option value="MO">Macao</option>
                                                <option value="MK">Macedonia, the Former Yugoslav Republic of</option>
                                                <option value="MG">Madagascar</option>
                                                <option value="MW">Malawi</option>
                                                <option value="MY">Malaysia</option>
                                                <option value="MV">Maldives</option>
                                                <option value="ML">Mali</option>
                                                <option value="MT">Malta</option>
                                                <option value="MH">Marshall Islands</option>
                                                <option value="MQ">Martinique</option>
                                                <option value="MR">Mauritania</option>
                                                <option value="MU">Mauritius</option>
                                                <option value="YT">Mayotte</option>
                                                <option value="MX">Mexico</option>
                                                <option value="FM">Micronesia, Federated States of</option>
                                                <option value="MD">Moldova, Republic of</option>
                                                <option value="MC">Monaco</option>
                                                <option value="MN">Mongolia</option>
                                                <option value="ME">Montenegro</option>
                                                <option value="MS">Montserrat</option>
                                                <option value="MA">Morocco</option>
                                                <option value="MZ">Mozambique</option>
                                                <option value="MM">Myanmar</option>
                                                <option value="NA">Namibia</option>
                                                <option value="NR">Nauru</option>
                                                <option value="NP">Nepal</option>
                                                <option value="NL">Netherlands</option>
                                                <option value="AN">Netherlands Antilles</option>
                                                <option value="NC">New Caledonia</option>
                                                <option value="NZ">New Zealand</option>
                                                <option value="NI">Nicaragua</option>
                                                <option value="NE">Niger</option>
                                                <option value="NG">Nigeria</option>
                                                <option value="NU">Niue</option>
                                                <option value="NF">Norfolk Island</option>
                                                <option value="MP">Northern Mariana Islands</option>
                                                <option value="NO">Norway</option>
                                                <option value="OM">Oman</option>
                                                <option value="PK">Pakistan</option>
                                                <option value="PW">Palau</option>
                                                <option value="PS">Palestinian Territory, Occupied</option>
                                                <option value="PA">Panama</option>
                                                <option value="PG">Papua New Guinea</option>
                                                <option value="PY">Paraguay</option>
                                                <option value="PE">Peru</option>
                                                <option value="PH">Philippines</option>
                                                <option value="PN">Pitcairn</option>
                                                <option value="PL">Poland</option>
                                                <option value="PT">Portugal</option>
                                                <option value="PR">Puerto Rico</option>
                                                <option value="QA">Qatar</option>
                                                <option value="RE">Reunion</option>
                                                <option value="RO">Romania</option>
                                                <option value="RU">Russian Federation</option>
                                                <option value="RW">Rwanda</option>
                                                <option value="BL">Saint Barthelemy</option>
                                                <option value="SH">Saint Helena</option>
                                                <option value="KN">Saint Kitts and Nevis</option>
                                                <option value="LC">Saint Lucia</option>
                                                <option value="MF">Saint Martin</option>
                                                <option value="PM">Saint Pierre and Miquelon</option>
                                                <option value="VC">Saint Vincent and the Grenadines</option>
                                                <option value="WS">Samoa</option>
                                                <option value="SM">San Marino</option>
                                                <option value="ST">Sao Tome and Principe</option>
                                                <option value="SA">Saudi Arabia</option>
                                                <option value="SN">Senegal</option>
                                                <option value="RS">Serbia</option>
                                                <option value="CS">Serbia and Montenegro</option>
                                                <option value="SC">Seychelles</option>
                                                <option value="SL">Sierra Leone</option>
                                                <option value="SG">Singapore</option>
                                                <option value="SX">Sint Maarten</option>
                                                <option value="SK">Slovakia</option>
                                                <option value="SI">Slovenia</option>
                                                <option value="SB">Solomon Islands</option>
                                                <option value="SO">Somalia</option>
                                                <option value="ZA">South Africa</option>
                                                <option value="GS">South Georgia and the South Sandwich Islands</option>
                                                <option value="SS">South Sudan</option>
                                                <option value="ES">Spain</option>
                                                <option value="LK">Sri Lanka</option>
                                                <option value="SD">Sudan</option>
                                                <option value="SR">Suriname</option>
                                                <option value="SJ">Svalbard and Jan Mayen</option>
                                                <option value="SZ">Swaziland</option>
                                                <option value="SE">Sweden</option>
                                                <option value="CH">Switzerland</option>
                                                <option value="SY">Syrian Arab Republic</option>
                                                <option value="TW">Taiwan, Province of China</option>
                                                <option value="TJ">Tajikistan</option>
                                                <option value="TZ">Tanzania, United Republic of</option>
                                                <option value="TH">Thailand</option>
                                                <option value="TL">Timor-Leste</option>
                                                <option value="TG">Togo</option>
                                                <option value="TK">Tokelau</option>
                                                <option value="TO">Tonga</option>
                                                <option value="TT">Trinidad and Tobago</option>
                                                <option value="TN">Tunisia</option>
                                                <option value="TR">Turkey</option>
                                                <option value="TM">Turkmenistan</option>
                                                <option value="TC">Turks and Caicos Islands</option>
                                                <option value="TV">Tuvalu</option>
                                                <option value="UG">Uganda</option>
                                                <option value="UA">Ukraine</option>
                                                <option value="AE">United Arab Emirates</option>
                                                <option value="GB">United Kingdom</option>
                                                <option value="US">United States</option>
                                                <option value="UM">United States Minor Outlying Islands</option>
                                                <option value="UY">Uruguay</option>
                                                <option value="UZ">Uzbekistan</option>
                                                <option value="VU">Vanuatu</option>
                                                <option value="VE">Venezuela</option>
                                                <option value="VN">Viet Nam</option>
                                                <option value="VG">Virgin Islands, British</option>
                                                <option value="VI">Virgin Islands, U.s.</option>
                                                <option value="WF">Wallis and Futuna</option>
                                                <option value="EH">Western Sahara</option>
                                                <option value="YE">Yemen</option>
                                                <option value="ZM">Zambia</option>
                                                <option value="ZW">Zimbabwe</option>
                                            </select>
                                            @error('country')
                                                <div class="alert alert-danger col-12 mt-1" role="alert">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="{{ __('users.status') }}">{{ __('users.status') }}</label>
                                            <select class="form-control" id="{{ __('users.status') }}" name="status" required>
                                                <option {{ $user->status == 0 ? 'selected' : '' }} value="0">{{ __('users.no-groups-to-see') }}</option>
                                                <option {{ $user->status == 1 ? 'selected' : '' }} value="1">{{ __('users.see-all-groups') }}</option>
                                            </select>
                                            @error('status')
                                            <div class="alert alert-danger col-12 mt-1" role="alert">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="{{ __('users.role') }}">{{ __('users.role') }}</label>
                                            <select class="form-control" id="{{ __('users.role') }}" name="role" required>
                                                <option {{ $user->role == 0 ? 'selected' : '' }} value="0">{{ __('users.normal') }}</option>
                                                <option {{ $user->role == 1 ? 'selected' : '' }} value="1">{{ __('users.admin') }}</option>
                                            </select>
                                            @error('role')
                                            <div class="alert alert-danger col-12 mt-1" role="alert">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="d-flex justify-content-end mt-5">
                                            <button type="submit" class="btn btn-primary mb-2 btn-pill">{{ __('users.buttons.update') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
