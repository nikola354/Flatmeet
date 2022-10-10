@extends('master.master', ['title' => __('Смени паролата')])
@section('content')
    <div class="row">
        <div class="community-card boxShadow joinCommunityBox">
            <div class="card-body pt-5">
                <h3>{{__('Смени си паролата')}}</h3>
                <hr>
                <form method="post" action="{{route('postChangePassword')}}">
                    {{ csrf_field() }}
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-unlock"></i></span>
                        </div>
                        <input type="password" name="oldPassword" class="form-control" placeholder="{{__('Старата парола')}}">
                    </div>

                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        </div>
                        <input type="password" name="newPassword" class="form-control" placeholder="{{__('Новата парола')}}">
                    </div>

                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        </div>
                        <input type="password" name="newPasswordConfirmed" class="form-control" placeholder="{{__('Потвърди новата парола')}}">
                    </div>

                    <hr>
                    <div class="form-group">
                        <input type="submit" value="{{__('Смени паролата')}}" class="btn float-right login_btn">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection