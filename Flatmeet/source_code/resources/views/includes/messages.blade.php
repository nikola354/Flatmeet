@if ($errors->any() || session('error') || session('success'))
    <div id="errorsModal" class="modal fade">
        <div class="modal-dialog modal-confirm">
            <div class="modal-content">
                @if($errors->any())
                    <div class="modal-header justify-content-center" style="background: var(--maincolor)">
                        <div class="icon-box">
                            <i class="fas fa-info" style=" font-size: 50px; margin:0 0 5px 2px;"></i>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body text-center">
                        <h4>{{__('Ууууупс')}}!</h4>
                        <div class="alert alert-warning errorContent">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button class="btn btn-success" data-dismiss="modal">{{__('Опитай пак')}}</button>
                    </div>
                @elseif(session('error'))
                    <div class="modal-header justify-content-center">
                        <div class="icon-box">
                            <i class="material-icons" style="font-size: 58px; margin: -2px 0 0 -1px;">&#xE5CD;</i>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body text-center">
                        <h4>{{__('Ууууупс')}}!</h4>
                        <div class="alert alert-danger errorContent">
                            <ul>
                                <li>{{session('error')}}</li>
                            </ul>
                        </div>
                        <button class="btn btn-success" data-dismiss="modal">{{__('Опитай пак')}}</button>
                    </div>
                @else
                    <div class="modal-header justify-content-center" style="background: var(--maincolor)">
                        <div class="icon-box">
                            <i class="fas fa-info" style=" font-size: 50px; margin:0 0 5px 2px;"></i>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body text-center">
                        <h4>{{__('Ура')}}!</h4>
                        <div class="alert alert-warning errorContent">
                            <p>{{session('success')}}</p>

                        </div>
                        <button class="btn btn-success" data-dismiss="modal">{{__('Разбрах')}}</button>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <script>
        $('#errorsModal').modal('show');
    </script>
@endif

<div id="jsonErrorsModal" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <div class="icon-box">
                    <i class="material-icons" style="font-size: 58px; margin: -2px 0 0 -1px;">&#xE5CD;</i>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body text-center">
                <h4>{{__('Ууууупс')}}!</h4>
                <div class="alert alert-danger errorContent">
                    <p></p>
                </div>
                <button class="btn btn-success" data-dismiss="modal">{{__('Опитай пак')}}</button>
            </div>
        </div>
    </div>
</div>

<div id="jsonInfoModal" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header justify-content-center" style="background: var(--maincolor)">
                <div class="icon-box">
                    <i class="fas fa-info" style=" font-size: 50px; margin:0 0 5px 2px;"></i>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body text-center">
                <h4>{{__('Ура')}}!</h4>
                <div class="alert alert-warning content">
                    <p></p>
                </div>
                <button class="btn btn-success" data-dismiss="modal">{{__('Разбрах')}}</button>
            </div>
        </div>
    </div>
</div>

<div id="notSureModal" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header justify-content-center" style="background: var(--maincolor)">
                <div class="icon-box">
                    <i class="fas fa-info" style=" font-size: 50px; margin:0 0 5px 2px;"></i>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body text-center">
                <h4>{{__('Внимание')}}</h4>
                <div class="alert alert-warning content">
                    <p></p>
                </div>
                <button class="btn btn-success" id="confirmBtn" data-dismiss="modal">{{__('ДА')}}</button>
            </div>
        </div>
    </div>
</div>