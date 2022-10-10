@extends('master.master', ['title' => __('Добави общ разход')])
@section('content')
    @if($minMonth === null)
        <h3 class="pageTitle">{{__('Този вход все още няма добавени разходи')}}.</h3>
    @else
        <div class="community-card boxShadow joinCommunityBox" id="addPaymentBox">
            <div class="card-body pt-5">
                @if(isset($payments[0]->file_name) && $payments[0]->file_name !== null)
                    <div id="receiptBtn">
                        <button type="button" class="btn" data-toggle="modal" data-target="#exampleModal">
                            <img width="50" height="50" src="/images/receipt.svg" id="pictureToShow" alt="">
                        </button>
                        <span></span>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group form-group paymentsInput">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-calendar-alt fa-2x"></i></span>
                            </div>
                            <input name="month" min="{{$minMonth->month}}" max="{{$maxMonth->month}}" type="month"
                                   value="{{$month}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group form-group paymentsInput">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-dollar-sign fa-2x"></i></span>
                            </div>
                            <select name="paymentType">
                                <option
                                        {{$type == null ? "selected" : ""}} value="default">{{__('Вид разход')}}</option>
                                @foreach($paymentsTypes as $p)
                                    <option
                                            {{$type == $p->id ? "selected" : ""}} value="{{$p->id}}">{{$p->name}}</option>
                                @endforeach
                                <option {{$type == "allPayments" ? "selected" : ""}} value="allPayments">{{__('Всички разходи')}}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <br>
                @if($payments === null)
                    <hr>
                    <h4 class="pageTitle">{{__('Избери месеца и вида разход, за да видиш кой от съседите ти вече е платил.')}}</h4>
                @elseif(sizeof($payments) === 0)
                    <hr>
                    <h4 class="pageTitle">{{__('Няма добавено плащане за този месец от този тип')}}.</h4>
                @else
                    <table class="table">
                        <thead>
                        <tr>
                            @if(isset($direction))
                                @if($direction === "asc")
                                    @if($orderBy === 'family_name')
                                        <th scope="col">
                                            <a href="{{route('sortPayments', [$building->building_code, $month, $type, 'family_name', 'desc'])}}">
                                                {{__('Семейство')}}<span>{!!html_entity_decode('&#9652')!!}</span>
                                            </a>
                                        </th>
                                    @else
                                        <th scope="col">
                                            <a href="{{route('sortPayments', [$building->building_code, $month, $type, 'family_name', 'asc'])}}">
                                                {{__('Семейство')}}
                                            </a>
                                        </th>
                                    @endif
                                    @if($orderBy === 'ap_num')
                                        <th scope="col">
                                            <a href="{{route('sortPayments', [$building->building_code, $month, $type, 'ap_num', 'desc'])}}">
                                                {{__('Ап.')}}<span>{!!html_entity_decode('&#9652')!!}</span>
                                            </a>
                                        </th>
                                    @else
                                        <th scope="col">
                                            <a href="{{route('sortPayments', [$building->building_code, $month, $type, 'ap_num', 'asc'])}}">
                                                {{__('Ап.')}}
                                            </a>
                                        </th>
                                    @endif
                                    @if($orderBy === 'floor')
                                        <th scope="col">
                                            <a href="{{route('sortPayments', [$building->building_code, $month, $type, 'floor', 'desc'])}}">
                                                {{__('Етаж')}}
                                                <span>{!!html_entity_decode('&#9652')!!}</span>
                                            </a>
                                        </th>
                                    @else
                                        <th scope="col">
                                            <a href="{{route('sortPayments', [$building->building_code, $month, $type, 'floor', 'asc'])}}">
                                                {{__('Етаж')}}
                                            </a>
                                        </th>
                                    @endif
                                    @if($orderBy === 'value')
                                        <th scope="col">
                                            <a href="{{route('sortPayments', [$building->building_code, $month, $type, 'value', 'desc'])}}">
                                                {{__('Сума')}}
                                                <span>{!!html_entity_decode('&#9652')!!}</span>
                                            </a>
                                        </th>
                                    @else
                                        <th scope="col">
                                            <a href="{{route('sortPayments', [$building->building_code, $month, $type, 'value', 'asc'])}}">
                                                {{__('Сума')}}
                                            </a>
                                        </th>
                                    @endif
                                    @if($orderBy === 'is_paid')
                                        <th scope="col">
                                            <a href="{{route('sortPayments', [$building->building_code, $month, $type, 'is_paid', 'desc'])}}">
                                                {{__('Платили')}}
                                                <span>{!!html_entity_decode('&#9652')!!}</span>
                                            </a>
                                        </th>
                                    @else
                                        <th scope="col">
                                            <a href="{{route('sortPayments', [$building->building_code, $month, $type, 'is_paid', 'asc'])}}">
                                                {{__('Платили')}}
                                            </a>
                                        </th>
                                    @endif
                                @else
                                    <th scope="col">
                                        <a href="{{route('sortPayments', [$building->building_code, $month, $type, 'family_name', 'asc'])}}">
                                            {{__('Семейство')}}
                                            <span>{!!$orderBy === 'family_name' ? html_entity_decode('&#9662') : ''!!}</span>
                                        </a>
                                    </th>
                                    <th scope="col">
                                        <a href="{{route('sortPayments', [$building->building_code, $month, $type, 'ap_num', 'asc'])}}">
                                            {{__('Ап.')}}
                                            <span>{!!$orderBy === 'ap_num' ? html_entity_decode('&#9662') : ''!!}</span>
                                        </a>
                                    </th>
                                    <th scope="col">
                                        <a href="{{route('sortPayments', [$building->building_code, $month, $type, 'floor', 'asc'])}}">
                                            {{__('Етаж')}}
                                            <span>{!!$orderBy === 'floor' ? html_entity_decode('&#9662') : ''!!}</span>
                                        </a>
                                    </th>
                                    <th scope="col">
                                        <a href="{{route('sortPayments', [$building->building_code, $month, $type, 'value', 'asc'])}}">
                                            {{__('Сума')}}
                                            <span>{!!$orderBy === 'value' ? html_entity_decode('&#9662') : ''!!}</span>
                                        </a>
                                    </th>
                                    <th scope="col">
                                        <a href="{{route('sortPayments', [$building->building_code, $month, $type, 'is_paid', 'asc'])}}">
                                            {{__('Платили')}}
                                            <span>{!!$orderBy === 'is_paid' ? html_entity_decode('&#9662') : ''!!}</span>
                                        </a>
                                    </th>
                                @endif
                            @else
                                <th scope="col"><a
                                            href="{{route('sortPayments', [$building->building_code, $month, $type, 'family_name', 'asc'])}}">{{__('Семейство')}}</a>
                                </th>
                                <th scope="col"><a
                                            href="{{route('sortPayments', [$building->building_code, $month, $type, 'ap_num', 'asc'])}}">{{__('Ап.')}}</a>
                                </th>
                                <th scope="col"><a
                                            href="{{route('sortPayments', [$building->building_code, $month, $type, 'floor', 'asc'])}}">{{__('Етаж')}}</a>
                                </th>
                                <th scope="col"><a
                                            href="{{route('sortPayments', [$building->building_code, $month, $type, 'value', 'asc'])}}">{{__('Сума')}}</a>
                                </th>
                                <th scope="col"><a
                                            href="{{route('sortPayments', [$building->building_code, $month, $type, 'is_paid', 'asc'])}}">{{__('Платили')}}</a>
                                </th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($payments as $p)
                            <tr>
                                <th scope="row">{{$p->family_name}}</th>
                                <td>{{$p->number}}</td>
                                <td>{{$p->floor}}</td>
                                <td>{{$p->value}}</td>

                                @if(auth()->user()->isTreasurer($building->building_code))
                                    <td>
                                        @if($p->is_paid)
                                            <a style="color: green"
                                               href="{{route('changeIsPaid', [$building->building_code, $month, $type, $p->number, $p->is_paid])}}">
                                                <i class="fas fa-check"></i>
                                            </a>
                                        @else
                                            <a style="color: red"
                                               href="{{route('changeIsPaid', [$building->building_code, $month, $type, $p->number, $p->is_paid])}}">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        @endif
                                    </td>
                                @else
                                    @if($p->is_paid)
                                        <td style="color: green">
                                            <i class="fas fa-check"></i>
                                        </td>
                                    @else
                                        <td style="color: red">
                                            <i class="fas fa-times"></i>
                                        </td>
                                    @endif
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @if(isset($payments[0]->file_name) && $payments[0]->file_name !== null)
                        <div id="receiptModal" class="paymentsModal modal">
                            <span class="paymentsClose">&times;</span>
                            <img class="payments-modal-content" src="/uploadedImages/{{$payments[0]->file_name}}">
                        </div>
                    @endif
                @endif
            </div>
        </div>
    @endif
@endsection
